<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once "../../init.php";

require_once $abs_us_root . $us_url_root . 'users/auth/PasskeyHandler.php';

// Check if any output was generated before our script
$unexpected_output = ob_get_contents();
if (!empty($unexpected_output)) {
    // logger(0, "PasskeyParser", "Unexpected output before script start: " . $unexpected_output);
}
ob_clean();

header('Content-Type: application/json');



// Enhanced error handling function
function handlePasskeyError($e, $userId = null, $context = 'unknown')
{
    global $passkeyHandler;

    // logger(
    // $userId ?? 'passkey_error',
    // "PasskeyError_$context",
    // "Error: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString()
    // );

    try {
        $diagnostics = $passkeyHandler->getDiagnosticInfo($userId);
        $validation = $passkeyHandler->validateCrossDeviceEnvironment($userId);

        $errorResponse = [
            'error' => $e->getMessage(),
            'context' => $context,
            'suggestions' => $validation['recommendations'] ?? [],
            'diagnostic_available' => true
        ];

        // Add specific suggestions based on error type and environment
        if (
            strpos($e->getMessage(), 'network') !== false ||
            strpos($e->getMessage(), 'connection') !== false
        ) {
            $errorResponse['suggestions'][] = lang("PASSKEY_ERR_NETWORK_SUGGESTION");
        }

        if ($diagnostics['device_analysis']['likely_needs_cross_device'] ?? false) {
            $errorResponse['suggestions'][] = lang("PASSKEY_ERR_CROSS_DEVICE_SUGGESTION");
            $errorResponse['alternative'] = lang("PASSKEY_ERR_CROSS_DEVICE_ALTERNATIVE");
        }

        return $errorResponse;
    } catch (Exception $diagError) {
        return [
            'error' => $e->getMessage(),
            'context' => $context,
            'diagnostic_error' => lang("PASSKEY_ERR_DIAGNOSTIC_FAILED") . $diagError->getMessage()
        ];
    }
}

try {
    // Get action early for security validation
    $action = null;
    $data = [];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception(lang("PASSKEY_INVALID_JSON") . json_last_error_msg());
        }

        $action = $data['action'] ?? null;
    }

    if (!$action) {
        throw new Exception(lang("PASSKEY_NO_ACTION_SPECIFIED"));
    }
    $csrf = $data['csrf'] ?? null;
    if (!$csrf || !Token::check($csrf)) {
        throw new Exception(lang("CSRF_ERROR"));
    }

    // Apply security validation

    $userId = null;
    if (isset($user) && $user->isLoggedIn()) {
        $userId = $user->data()->id;
    }
    if (!validateRateLimit('passkey_' . $action, $userId)) {
        throw new Exception(getRateLimitErrorMessage('passkey_' . $action));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        switch ($action) {
            case 'log':
                // Handle JavaScript logging
                $message = $data['message'] ?? lang("PASSKEY_LOG_NO_MESSAGE");
                $type = $data['type'] ?? 'info';
                $timestamp = $data['timestamp'] ?? date('Y-m-d H:i:s');

                // logger(0, "PasskeyJS", "[$type] $message (Timestamp: $timestamp)");
                echo json_encode(['success' => true]);
                break;

            case 'store':
                if (!isset($user) || !$user->isLoggedIn()) {
                    throw new Exception(lang("PASSKEY_LOGIN_REQUIRED"));
                }

                $userId = $user->data()->id;

                if (!isset($data['credentialId'], $data['clientDataJSON'], $data['attestationObject'])) {
                    throw new Exception(lang("PASSKEY_MISSING_CREDENTIAL_DATA"));
                }

                // logger($userId, 'PasskeyStore', 'Attempting to store passkey credential');

                // Convert base64url back to binary
                $credentialData = [
                    'id' => $data['credentialId'],
                    'rawId' => base64_decode(strtr($data['credentialId'], '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data['credentialId'])) % 4)),
                    'response' => [
                        'clientDataJSON' => base64_decode(strtr($data['clientDataJSON'], '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data['clientDataJSON'])) % 4)),
                        'attestationObject' => base64_decode(strtr($data['attestationObject'], '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data['attestationObject'])) % 4))
                    ]
                ];

                $success = $passkeyHandler->storePasskey($userId, $credentialData);

                if ($success) {
                    handleAuthSuccess('passkey_store', $userId);
                    echo json_encode(['success' => true, 'message' => lang("PASSKEY_STORED_SUCCESS")]);
                } else {
                    handleAuthFailure('passkey_store', $userId);
                    throw new Exception(lang("PASSKEY_STORAGE_FAILED"));
                }
                break;

            case 'verify':
                if (!isset($data['credentialId'], $data['clientDataJSON'], $data['authenticatorData'], $data['signature'])) {
                    throw new Exception(lang("PASSKEY_MISSING_AUTH_DATA"));
                }

                // logger(0, 'PasskeyVerify', 'Attempting to verify passkey authentication');

                // Convert base64url back to binary
                $authData = [
                    'id' => $data['credentialId'],
                    'rawId' => base64_decode(strtr($data['credentialId'], '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data['credentialId'])) % 4)),
                    'response' => [
                        'clientDataJSON' => base64_decode(strtr($data['clientDataJSON'], '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data['clientDataJSON'])) % 4)),
                        'authenticatorData' => base64_decode(strtr($data['authenticatorData'], '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data['authenticatorData'])) % 4)),
                        'signature' => base64_decode(strtr($data['signature'], '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data['signature'])) % 4)),
                        'userHandle' => isset($data['userHandle']) && $data['userHandle'] ?
                            base64_decode(strtr($data['userHandle'], '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data['userHandle'])) % 4)) : null
                    ]
                ];

                $expectedUserId = null;
                if (isset($user) && $user->isLoggedIn()) {
                    $expectedUserId = $user->data()->id;
                }

                $result = $passkeyHandler->validateAuthentication($authData, $expectedUserId);

                if ($result['success']) {
                    // Record successful attempt
                    handleAuthSuccess('passkey_verify', $result['user_id']);

                    // Log the user in if not already logged in
                    if (!isset($user) || !$user->isLoggedIn()) {
                        $userToLogin = new User();
                        $userToLogin->find((int)$result['user_id']);

                        if (!$userToLogin->data()) {
                            // logger($result['user_id'], "PasskeyLoginFail", "User data not found for validated passkey user_id.");
                            throw new Exception(lang("PASSKEY_USER_NOT_FOUND"));
                        }

                        $userToLogin->login();
                        $_SESSION['last_confirm'] = date("Y-m-d H:i:s");
                        setLoginMethod('passkeys');
                        // logger($result['user_id'], 'PasskeyLogin', 'User logged in via passkey. Credential ID: ' . $result['credentialId']);
                    }


                    echo json_encode([
                        'success' => true,
                        'user_id' => $result['user_id'],
                        'credentialId' => $result['credentialId'],
                        'redirect' => null,
                        'message' => lang("PASSKEY_LOGIN_SUCCESS")
                    ]);
                } else {
                    handleAuthFailure('passkey_verify', $expectedUserId);
                    throw new Exception(lang("PASSKEY_LOGIN_FAILED"));
                }
                break;

            case 'register':

                if (!isset($user) || !$user->isLoggedIn()) {
                    throw new Exception(lang("PASSKEY_LOGIN_REQUIRED"));
                }

                $userId = $user->data()->id;
                // logger($userId, 'PasskeyRegChallenge', 'Registration challenge requested');

                // Check if user already has maximum passkeys
                $existingCount = $db->query("SELECT COUNT(*) as count FROM us_passkeys WHERE user_id = ?", [$userId])->first()->count;
                if ($existingCount >= 10) {
                    throw new Exception(lang("PASSKEY_ERR_LIMIT_REACHED"));
                }

                $publicKeyCredentialCreationOptions = $passkeyHandler->generateRegistrationOptions($userId);

                // Build authenticatorSelection with proper null handling for iOS
                $authenticatorSelection = [];
                $authSel = $publicKeyCredentialCreationOptions->authenticatorSelection;

                if (is_object($authSel)) {
                    if (property_exists($authSel, 'authenticatorAttachment') && $authSel->authenticatorAttachment !== null) {
                        $authenticatorSelection['authenticatorAttachment'] = $authSel->authenticatorAttachment;
                    }

                    if (property_exists($authSel, 'requireResidentKey') && $authSel->requireResidentKey !== null) {
                        $authenticatorSelection['requireResidentKey'] = (bool)$authSel->requireResidentKey;
                    }

                    if (property_exists($authSel, 'userVerification') && $authSel->userVerification !== null) {
                        $authenticatorSelection['userVerification'] = $authSel->userVerification;
                    }

                    if (property_exists($authSel, 'residentKey') && $authSel->residentKey !== null) {
                        $authenticatorSelection['residentKey'] = $authSel->residentKey;


                        if (!isset($authenticatorSelection['requireResidentKey'])) {
                            $authenticatorSelection['requireResidentKey'] = ($authSel->residentKey === 'required');
                        }
                    }
                }


                // Convert for JSON response
                $response = [
                    'rp' => [
                        'name' => $publicKeyCredentialCreationOptions->rp->name,
                        'id' => $publicKeyCredentialCreationOptions->rp->id
                    ],
                    'user' => [
                        'id' => base64_encode($publicKeyCredentialCreationOptions->user->id),
                        'name' => $publicKeyCredentialCreationOptions->user->name,
                        'displayName' => $publicKeyCredentialCreationOptions->user->displayName
                    ],
                    'challenge' => base64_encode($publicKeyCredentialCreationOptions->challenge),
                    'pubKeyCredParams' => array_map(function ($param) {
                        return [
                            'type' => $param->type,
                            'alg' => $param->alg
                        ];
                    }, $publicKeyCredentialCreationOptions->pubKeyCredParams),
                    'timeout' => $publicKeyCredentialCreationOptions->timeout,
                    'attestation' => $publicKeyCredentialCreationOptions->attestation,
                    'authenticatorSelection' => $authenticatorSelection,  // Use the cleaned version
                    'excludeCredentials' => array_map(function ($cred) {
                        return [
                            'type' => $cred->type,
                            'id' => base64_encode($cred->id),
                            'transports' => $cred->transports
                        ];
                    }, $publicKeyCredentialCreationOptions->excludeCredentials)
                ];

                // Log the cleaned authenticatorSelection for debugging
                // logger($userId, 'PasskeyRegChallenge', 'Cleaned authenticatorSelection: ' . json_encode($authenticatorSelection));
                // logger($userId, 'PasskeyDebugIOS', 'Full response: ' . json_encode($response, JSON_PRETTY_PRINT));

                echo json_encode($response);
                break;

            case 'auth':
                // logger(0, 'PasskeyAuthChallenge', 'Authentication challenge requested');

                $userId = null;
                if (isset($user) && $user->isLoggedIn()) {
                    $userId = $user->data()->id;
                }

                $publicKeyCredentialRequestOptions = $passkeyHandler->generateAuthenticationOptions($userId);

                // Convert for JSON response
                $response = [
                    'challenge' => base64_encode($publicKeyCredentialRequestOptions->challenge),
                    'timeout' => $publicKeyCredentialRequestOptions->timeout,
                    'rpId' => $publicKeyCredentialRequestOptions->rpId,
                    'userVerification' => $publicKeyCredentialRequestOptions->userVerification,
                    'allowCredentials' => array_map(function ($cred) {
                        return [
                            'type' => $cred->type,
                            'id' => base64_encode($cred->id),
                            'transports' => $cred->transports
                        ];
                    }, $publicKeyCredentialRequestOptions->allowCredentials)
                ];

                echo json_encode($response);
                break;

            case 'diagnostics':
                $userId = null;
                if (isset($user) && $user->isLoggedIn()) {
                    $userId = $user->data()->id;
                }

                $diagnostics = $passkeyHandler->getDiagnosticInfo($userId);
                $validation = $passkeyHandler->validateCrossDeviceEnvironment($userId);

                echo json_encode([
                    'diagnostics' => $diagnostics,
                    'validation' => $validation,
                    'timestamp' => date('Y-m-d H:i:s'),
                    'user_logged_in' => isset($user) && $user->isLoggedIn()
                ], JSON_PRETTY_PRINT);
                break;

            case 'network-test':
                $networkInfo = [
                    'server_time' => date('Y-m-d H:i:s'),
                    'client_ip' => Server::get('REMOTE_ADDR', 'unknown'),
                    'user_agent' => Server::get('HTTP_USER_AGENT', 'unknown'),
                    'host' => Server::get('HTTP_HOST', 'unknown'),
                    'protocol' => isset($_SERVER['HTTPS']) ? 'https' : 'http',
                    'headers' => getallheaders(),
                    'session_active' => session_status() === PHP_SESSION_ACTIVE
                ];

                echo json_encode($networkInfo, JSON_PRETTY_PRINT);
                break;






            default:
                throw new Exception(lang("PASSKEY_INVALID_ACTION") . $action);
        }
    } else {
        throw new Exception(lang("PASSKEY_INVALID_METHOD") . Server::get('REQUEST_METHOD'));
    }
} catch (Exception $e) {
    // Make sure we clear any output buffer that might contain HTML
    if (isset($action) && $action) {
        handleAuthFailure('passkey_' . $action, $userId, null, [], [
            'error_message' => $e->getMessage(),
            'user_agent' => Server::get('HTTP_USER_AGENT')
        ]);
    }
    if (ob_get_level()) {
        ob_clean();
    }

    // Determine user ID for logging
    $userId = null;
    if (isset($user) && $user->isLoggedIn()) {
        $userId = $user->data()->id;
    }

    // Handle the error with enhanced diagnostics
    $errorResponse = handlePasskeyError($e, $userId, $action ?? 'unknown');

    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode($errorResponse);
} catch (Error $e) {
    // Catch fatal errors too
    if (ob_get_level()) {
        ob_clean();
    }

    // logger(0, "PasskeyParser", "Fatal error caught: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString());
    http_response_code(500);

    header('Content-Type: application/json');
    echo json_encode(['error' => lang("PASSKEY_FATAL_ERROR") . $e->getMessage()]);
}

// Helper function for base64url decoding
function base64urlDecode($data)
{
    return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data)) % 4));
}
