<?php
require_once $abs_us_root . $us_url_root . 'users/auth/vendor/autoload.php';

if (!class_exists('Assert\Assertion')) {
    class_alias('Webmozart\Assert\Assert', 'Assert\Assertion');
}

$userId = $user->data()->id ?? null;
require_once 'UserSpicePasskeyCredentialRepository.php';

use Webauthn\PublicKeyCredentialRpEntity;
use Webauthn\PublicKeyCredentialUserEntity;
use Webauthn\PublicKeyCredentialCreationOptions;
use Webauthn\PublicKeyCredentialRequestOptions;
use Webauthn\PublicKeyCredentialParameters;
use Webauthn\PublicKeyCredentialDescriptor;
use Webauthn\AuthenticatorSelectionCriteria;
use Webauthn\AttestationStatement\AttestationStatementSupportManager;
use Webauthn\AttestationStatement\NoneAttestationStatementSupport;
use Webauthn\AuthenticatorAttestationResponse;
use Webauthn\AuthenticatorAttestationResponseValidator;
use Webauthn\AuthenticatorAssertionResponse;
use Webauthn\AuthenticatorAssertionResponseValidator;
use Webauthn\PublicKeyCredentialLoader;
use Webauthn\PublicKeyCredentialSource;
use Webauthn\PublicKeyCredential;
use Webauthn\Denormalizer\WebauthnSerializerFactory;
use Cose\Algorithms;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Webauthn\AttestationStatement\AttestationObjectLoader;
use Cose\Algorithm\Manager as AlgorithmManager;
use Cose\Algorithm\Signature\ECDSA\ES256;
use Cose\Algorithm\Signature\RSA\RS256;
use Webauthn\Counter\ThrowExceptionIfInvalid;
use Webauthn\CeremonyStep\CeremonyStepManager;

class PasskeyHandler
{
    private $db;
    private UserSpicePasskeyCredentialRepository $userSpicePasskeyCredentialRepository;
    private PublicKeyCredentialRpEntity $publicKeyCredentialRpEntity;
    private PublicKeyCredentialLoader $publicKeyCredentialLoader;
    private AuthenticatorAttestationResponseValidator $authenticatorAttestationResponseValidator;
    private AuthenticatorAssertionResponseValidator $authenticatorAssertionResponseValidator;
    private ServerRequestCreator $serverRequestCreator;

    /** @define PASSKEY_RP_ID */
    public function __construct($db, $options = [])
    {
        $this->db = $db;
        $this->userSpicePasskeyCredentialRepository = new UserSpicePasskeyCredentialRepository($this->db);

        if (defined('PASSKEY_RP_ID')) {
            if (is_string(PASSKEY_RP_ID)) {
                // Single domain configured
                $rpId = PASSKEY_RP_ID;
            } elseif (is_array(PASSKEY_RP_ID)) {
                // Multiple domains - match against current host
                $currentHost = Server::get('HTTP_HOST', '');
                $rpId = in_array($currentHost, PASSKEY_RP_ID) ? $currentHost : PASSKEY_RP_ID[0];
            } else {
                throw new InvalidArgumentException('PASSKEY_RP_ID must be a string or array');
            }
        } else {
            // Fallback to HTTP_HOST with sanitization
            $rpId = $options['rpId'] ?? Server::get('HTTP_HOST', '');
            if ($rpId !== 'localhost' && strpos($rpId, ':') !== false) {
                $rpId = explode(':', $rpId)[0];
            }
        }
        $rpName = $options['rpName'] ?? 'UserSpice';
        $this->publicKeyCredentialRpEntity = new PublicKeyCredentialRpEntity($rpName, $rpId, null);

        $attestationStatementSupportManager = new AttestationStatementSupportManager([
            new NoneAttestationStatementSupport(),
        ]);

        $this->publicKeyCredentialLoader = new PublicKeyCredentialLoader(
            new AttestationObjectLoader($attestationStatementSupportManager)
        );

        $algorithmManager = new AlgorithmManager();
        $algorithmManager->add(new ES256());
        $algorithmManager->add(new RS256());

        $ceremonyStepManager = new CeremonyStepManager([]);

        $this->authenticatorAttestationResponseValidator = new AuthenticatorAttestationResponseValidator(
            $ceremonyStepManager,
            $attestationStatementSupportManager,
            $this->userSpicePasskeyCredentialRepository,
            null,
            null,
            $algorithmManager
        );

        $this->authenticatorAssertionResponseValidator = new AuthenticatorAssertionResponseValidator(
            $ceremonyStepManager,
            $this->userSpicePasskeyCredentialRepository,
            null,
            null,
            $algorithmManager,
            new ThrowExceptionIfInvalid()
        );

        $psr17Factory = new Psr17Factory();

        $this->serverRequestCreator = new ServerRequestCreator(
            $psr17Factory,
            $psr17Factory,
            $psr17Factory,
            $psr17Factory
        );

        // logger(0, "PasskeyHandlerInit", "Passkey Handler Initialized with RP ID: " . $rpId . ", RP Name: " . $rpName . " using webauthn-lib v5+.");
    }

    /**
     * Enhanced device detection with detailed analysis
     */
    private function getDetailedDeviceInfo(): array
    {
        $userAgent = Server::get('HTTP_USER_AGENT', '');
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent);
        $isUnity = strpos($userAgent, 'Unity') !== false;
        $isTablet = preg_match('/iPad|Android(?!.*Mobile)/i', $userAgent);

        // Check for device type hints from client
        $deviceTypeJson = $_GET['device_type'] ?? null;
        $clientHints = [];
        if ($deviceTypeJson) {
            $clientHints = json_decode($deviceTypeJson, true) ?: [];
        }

        return [
            'is_mobile' => $isMobile,
            'is_unity' => $isUnity,
            'is_tablet' => $isTablet,
            'user_agent' => $userAgent,
            'client_hints' => $clientHints,
            'likely_needs_cross_device' => !$isMobile && !$isUnity && !isset($clientHints['hasTouch'])
        ];
    }

    /**
     * Analyze network conditions that might affect cross-device auth
     */
    private function analyzeNetworkConditions(): array
    {
        $analysis = [
            'likely_issues' => [],
            'network_type' => 'unknown'
        ];

        $remoteAddr = Server::get('REMOTE_ADDR', '');
        $userAgent = Server::get('HTTP_USER_AGENT', '');

        // Corporate network indicators
        if (
            strpos($remoteAddr, '10.') === 0 ||
            strpos($remoteAddr, '172.') === 0 ||
            strpos($remoteAddr, '192.168.') === 0
        ) {
            $analysis['network_type'] = 'private';
            $analysis['likely_issues'][] = lang("PASSKEY_NETWORK_PRIVATE");
        }

        // Proxy/VPN indicators
        if (
            Server::get('HTTP_X_FORWARDED_FOR', '') !== '' ||
            Server::get('HTTP_X_REAL_IP', '') !== '' ||
            Server::get('HTTP_VIA', '') !== ''
        ) {
            $analysis['likely_issues'][] = lang("PASSKEY_NETWORK_PROXY");
        }

        // Mobile carrier indicators
        if (preg_match('/Mobile|Android|iPhone/i', $userAgent)) {
            $analysis['network_type'] = 'mobile';
            $analysis['likely_issues'][] = lang("PASSKEY_NETWORK_MOBILE");
        }

        // Corporate firewall indicators
        if (Server::get('HTTP_X_FORWARDED_PROTO', '') === 'https') {
            $analysis['likely_issues'][] = lang("PASSKEY_NETWORK_CORPORATE");
        }

        return $analysis;
    }

    /**
     * Get specific recommendations based on device and network analysis
     */
    private function getCrossDeviceRecommendations(array $deviceInfo): array
    {
        $recommendations = [];

        if ($deviceInfo['likely_needs_cross_device']) {
            $recommendations[] = lang("PASSKEY_RECOMMENDATION_CROSS_DEVICE");
            $recommendations[] = lang("PASSKEY_RECOMMENDATION_SAME_NETWORK");
            $recommendations[] = lang("PASSKEY_RECOMMENDATION_QR_QUICK");
            $recommendations[] = lang("PASSKEY_RECOMMENDATION_INTERNET");
        }

        if ($deviceInfo['is_unity']) {
            $recommendations[] = lang("PASSKEY_RECOMMENDATION_UNITY_WEBVIEW");
            $recommendations[] = lang("PASSKEY_RECOMMENDATION_UNITY_TIMEOUT");
        }

        if ($deviceInfo['is_mobile']) {
            $recommendations[] = lang("PASSKEY_RECOMMENDATION_MOBILE_LOCAL");
            $recommendations[] = lang("PASSKEY_RECOMMENDATION_GOOGLE_MANAGER");
        }

        return $recommendations;
    }

    /**
     * Create AuthenticatorSelectionCriteria with proper discoverable credential settings
     */
    private function createDiscoverableCredentialCriteria(): AuthenticatorSelectionCriteria
    {
        try {
            return new AuthenticatorSelectionCriteria(
                'null', //make this one null so bitwarden etc works and let the others try/catch?
                true,
                AuthenticatorSelectionCriteria::USER_VERIFICATION_REQUIREMENT_PREFERRED,
                AuthenticatorSelectionCriteria::RESIDENT_KEY_REQUIREMENT_REQUIRED
            );
        } catch (Throwable $e1) {
            try {
                return new AuthenticatorSelectionCriteria(
                    'cross-platform',
                    true,
                    'preferred',
                    'required'
                );
            } catch (Throwable $e2) {
                try {
                    return new AuthenticatorSelectionCriteria(
                        null,
                        true,
                        AuthenticatorSelectionCriteria::USER_VERIFICATION_REQUIREMENT_PREFERRED
                    );
                } catch (Throwable $e3) {
                    try {
                        return new AuthenticatorSelectionCriteria(
                            null,
                            true,
                            'preferred'
                        );
                    } catch (Throwable $e4) {
                        // logger(0, "PasskeyHandlerWarning", "Could not create discoverable credential criteria. Using fallback.");
                        return new AuthenticatorSelectionCriteria();
                    }
                }
            }
        }
    }

    /**
     * Create cross-platform friendly criteria for mobile/Unity scenarios
     */
    private function createCrossPlatformCriteria(): AuthenticatorSelectionCriteria
    {
        try {
            return new AuthenticatorSelectionCriteria(
                null,
                true,
                AuthenticatorSelectionCriteria::USER_VERIFICATION_REQUIREMENT_PREFERRED,
                AuthenticatorSelectionCriteria::RESIDENT_KEY_REQUIREMENT_PREFERRED
            );
        } catch (Throwable $e1) {
            try {
                return new AuthenticatorSelectionCriteria(
                    null,
                    true,
                    'preferred',
                    'preferred'
                );
            } catch (Throwable $e2) {
                try {
                    return new AuthenticatorSelectionCriteria(
                        null,
                        true,
                        AuthenticatorSelectionCriteria::USER_VERIFICATION_REQUIREMENT_PREFERRED
                    );
                } catch (Throwable $e3) {
                    try {
                        return new AuthenticatorSelectionCriteria(
                            null,
                            true,
                            'preferred'
                        );
                    } catch (Throwable $e4) {
                        // logger(0, "PasskeyHandler", "All cross-platform criteria attempts failed, using basic criteria");
                        return new AuthenticatorSelectionCriteria();
                    }
                }
            }
        }
    }

    /**
     * Detect if this is a mobile device
     */
    private function isMobileDevice(): bool
    {
        $userAgent = Server::get('HTTP_USER_AGENT', '');
        return preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent);
    }

    /**
     * Detect if this is a Unity WebView
     */
    private function isUnityWebView(): bool
    {
        $userAgent = Server::get('HTTP_USER_AGENT', '');
        return strpos($userAgent, 'Unity') !== false;
    }

    /**
     * Improved base64url encoding
     */
    private function base64urlEncode($data): string
    {
        if (is_string($data)) {
            $encoded = base64_encode($data);
        } else {
            $encoded = base64_encode($data);
        }
        return rtrim(strtr($encoded, '+/', '-_'), '=');
    }

    /**
     * Improved base64url decoding
     */
    private function base64urlDecode($data): string
    {
        $padded = $data . str_repeat('=', (4 - strlen($data) % 4) % 4);
        return base64_decode(strtr($padded, '-_', '+/'));
    }

    /**
     * Convert binary data to consistent hex representation for logging
     */
    private function binaryToHex($data): string
    {
        return bin2hex($data);
    }

    public function generateRegistrationOptions($userId): PublicKeyCredentialCreationOptions
    {
        $deviceInfo = $this->getDetailedDeviceInfo();

        $userInfo = $this->db->query("SELECT email, fname, lname FROM users WHERE id = ?", [$userId])->first();
        if (!$userInfo) {
            // logger($userId, 'PasskeyRegChallengeFail', 'User not found.');
            throw new Exception(lang("PASSKEY_USER_NOT_FOUND_REGISTRATION"));
        }

        $userDisplayName = ($userInfo->fname && $userInfo->lname) ? ($userInfo->fname . " " . $userInfo->lname) : $userInfo->email;
        $userHandle = (string) $userId;

        $userEntity = new PublicKeyCredentialUserEntity(
            $userInfo->email,
            $userHandle,
            $userDisplayName
        );

        $challenge = random_bytes(32);

        $pubKeyCredParams = [
            new PublicKeyCredentialParameters('public-key', Algorithms::COSE_ALGORITHM_ES256),
            new PublicKeyCredentialParameters('public-key', Algorithms::COSE_ALGORITHM_RS256),
        ];

        $existingCredentials = $this->userSpicePasskeyCredentialRepository->findAllForUserEntity($userEntity);

        // Enhanced excludeCredentials with device-specific transport hints
        $excludeCredentials = array_map(function (PublicKeyCredentialSource $credential) use ($deviceInfo) {
            $descriptor = $credential->getPublicKeyCredentialDescriptor();

            $transports = ['usb', 'nfc', 'ble', 'internal'];
            if ($deviceInfo['likely_needs_cross_device']) {
                array_unshift($transports, 'hybrid');
            }

            return new PublicKeyCredentialDescriptor(
                $descriptor->type,
                $descriptor->id,
                $transports
            );
        }, $existingCredentials);

        // Enhanced timeout based on device type
        if ($deviceInfo['likely_needs_cross_device'] || $deviceInfo['is_unity']) {
            $timeout = 120000; // 2 minutes for cross-device scenarios
        } elseif ($deviceInfo['is_mobile'] || $deviceInfo['is_tablet']) {
            $timeout = 90000; // 1.5 minutes for mobile
        } else {
            $timeout = 60000; // 1 minute default
        }

        $attestationPreference = PublicKeyCredentialCreationOptions::ATTESTATION_CONVEYANCE_PREFERENCE_NONE;

        // Choose appropriate authenticator selection criteria based on device
        if ($deviceInfo['is_unity'] || $deviceInfo['is_mobile'] || $deviceInfo['likely_needs_cross_device']) {
            $authenticatorSelectionCriteria = $this->createCrossPlatformCriteria();
            // logger($userId, 'PasskeyRegistrationChallenge', 'Using cross-platform criteria for device type: ' . 
            // ($deviceInfo['is_mobile'] ? 'mobile' : ($deviceInfo['is_unity'] ? 'unity' : 'cross-device-desktop')));
        } else {
            $authenticatorSelectionCriteria = $this->createDiscoverableCredentialCriteria();
            // logger($userId, 'PasskeyRegistrationChallenge', 'Using standard discoverable criteria for desktop');
        }

        $publicKeyCredentialCreationOptions = PublicKeyCredentialCreationOptions::create(
            $this->publicKeyCredentialRpEntity,
            $userEntity,
            $challenge,
            pubKeyCredParams: $pubKeyCredParams,
            timeout: $timeout,
            excludeCredentials: $excludeCredentials,
            authenticatorSelection: $authenticatorSelectionCriteria,
            attestation: $attestationPreference,
            extensions: null
        );

        // Enhanced session data with device context
        $_SESSION['passkey_creation_options'] = [
            'challenge' => base64_encode($challenge),
            'challenge_raw' => $challenge,
            'user_id' => $userHandle,
            'user_email' => $userInfo->email,
            'user_display_name' => $userDisplayName,
            'rp_id' => $this->publicKeyCredentialRpEntity->id,
            'timeout' => $timeout,
            'attestation' => $attestationPreference,
            'device_info' => $deviceInfo,
            'timestamp' => time()
        ];
        $_SESSION['passkey_creation_user_id_for_verification'] = $userHandle;

        // logger($userId, 'PasskeyRegistrationChallenge', 
        // 'Creation options generated. Challenge: ' . $this->binaryToHex($challenge) . 
        // ', Device: ' . ($deviceInfo['is_mobile'] ? 'mobile' : ($deviceInfo['is_unity'] ? 'unity' : 'desktop')) . 
        // ', Cross-device likely: ' . ($deviceInfo['likely_needs_cross_device'] ? 'yes' : 'no') . 
        // ', Timeout: ' . $timeout . 'ms');

        return $publicKeyCredentialCreationOptions;
    }

    public function storePasskey($userId, array $credentialData): bool
    {
        if (!isset($_SESSION['passkey_creation_options'])) {
            // logger($userId, "PasskeyStoreFail", "Session: No passkey_creation_options found.");
            throw new Exception(lang("PASSKEY_NO_CHALLENGE_SESSION"));
        }

        $sessionOptions = $_SESSION['passkey_creation_options'];
        unset($_SESSION['passkey_creation_options']);

        $sessionUserHandleForVerification = $_SESSION['passkey_creation_user_id_for_verification'] ?? null;
        unset($_SESSION['passkey_creation_user_id_for_verification']);

        if ($sessionUserHandleForVerification && $sessionUserHandleForVerification !== (string) $userId) {
            // logger($userId, "PasskeyStoreFail", "User ID mismatch between current user and session challenge.");
            throw new Exception(lang("PASSKEY_USER_MISMATCH"));
        }

        if ($sessionOptions['user_id'] !== (string) $userId) {
            // logger($userId, "PasskeyStoreFail", "User ID in challenge options does not match current user.");
            throw new Exception(lang("PASSKEY_CHALLENGE_USER_MISMATCH"));
        }

        try {
            // logger($userId, "PasskeyStoreDebug", "Credential data received: ID=" . substr($credentialData['id'], 0, 20) . "..., RawId length=" . strlen($credentialData['rawId']));

            $userEntity = new PublicKeyCredentialUserEntity(
                $sessionOptions['user_email'],
                $sessionOptions['user_id'],
                $sessionOptions['user_display_name']
            );

            $pubKeyCredParams = [
                new PublicKeyCredentialParameters('public-key', Algorithms::COSE_ALGORITHM_ES256),
                new PublicKeyCredentialParameters('public-key', Algorithms::COSE_ALGORITHM_RS256),
            ];

            $authenticatorSelectionCriteria = $this->createDiscoverableCredentialCriteria();

            $challenge = $sessionOptions['challenge_raw'] ?? base64_decode($sessionOptions['challenge']);

            $publicKeyCredentialCreationOptions = PublicKeyCredentialCreationOptions::create(
                $this->publicKeyCredentialRpEntity,
                $userEntity,
                $challenge,
                pubKeyCredParams: $pubKeyCredParams,
                timeout: $sessionOptions['timeout'],
                excludeCredentials: [],
                authenticatorSelection: $authenticatorSelectionCriteria,
                attestation: $sessionOptions['attestation'],
                extensions: null
            );

            $serializerFactory = new WebauthnSerializerFactory(
                AttestationStatementSupportManager::create()
            );
            $serializer = $serializerFactory->create();

            $credentialJson = json_encode([
                'id' => $credentialData['id'],
                'rawId' => $this->base64urlEncode($credentialData['rawId']),
                'type' => 'public-key',
                'response' => [
                    'clientDataJSON' => $this->base64urlEncode($credentialData['response']['clientDataJSON']),
                    'attestationObject' => $this->base64urlEncode($credentialData['response']['attestationObject'])
                ]
            ]);

            // logger($userId, "PasskeyStoreSerialize", "Credential JSON prepared, length: " . strlen($credentialJson));

            $publicKeyCredential = $serializer->deserialize($credentialJson, PublicKeyCredential::class, 'json');
            $authenticatorResponse = $publicKeyCredential->response;

            $host = Server::getOrigin([]);

            // logger($userId, "PasskeyStoreAttempt", "Attempting to validate attestation. Origin: " . $host);

            $publicKeyCredentialSource = $this->authenticatorAttestationResponseValidator->check(
                $authenticatorResponse,
                $publicKeyCredentialCreationOptions,
                $host
            );

            // logger($userId, "PasskeyStoreValidated", "Attestation validated. Credential ID (hex): " . $this->binaryToHex($publicKeyCredentialSource->publicKeyCredentialId));

            $this->userSpicePasskeyCredentialRepository->saveCredentialSource($publicKeyCredentialSource);
            $this->db->update('users', $userId, ['passkey_enabled' => 1]);

            // logger($userId, 'PasskeyStored', 'Passkey stored successfully. Credential ID (hex): ' . $this->binaryToHex($publicKeyCredentialSource->publicKeyCredentialId));
            return true;
        } catch (Throwable $e) {
            // logger($userId, "PasskeyStoreFail", "Error storing passkey: " . $e->getMessage());
            throw new Exception(lang("PASSKEY_REGISTRATION_FAILED_ERROR") . " " . $e->getMessage(), 0, $e);
        }
    }

    public function generateAuthenticationOptions($userId = null): PublicKeyCredentialRequestOptions
    {
        $deviceInfo = $this->getDetailedDeviceInfo();
        $challenge = random_bytes(32);
        $allowedCredentials = [];

        if ($userId) {
            $userHandle = (string) $userId;
            $userEntity = new PublicKeyCredentialUserEntity(
                'user_lookup_for_auth_challenge',
                $userHandle,
                'User Lookup for Auth Challenge'
            );
            $userCredentialSources = $this->userSpicePasskeyCredentialRepository->findAllForUserEntity($userEntity);

            foreach ($userCredentialSources as $credentialSource) {
                $descriptor = $credentialSource->getPublicKeyCredentialDescriptor();

                $transports = ['usb', 'nfc', 'ble', 'internal'];
                if ($deviceInfo['likely_needs_cross_device'] || !empty($deviceInfo['client_hints']['isLikelyNeedsCrossDevice'])) {
                    array_unshift($transports, 'hybrid');
                }

                $allowedCredentials[] = new PublicKeyCredentialDescriptor(
                    $descriptor->type,
                    $descriptor->id,
                    $transports
                );
            }

            // logger($userId, "PasskeyAuthChallengeInfo", 
            // "Device info - Mobile: " . ($deviceInfo['is_mobile'] ? 'yes' : 'no') . 
            // ", Unity: " . ($deviceInfo['is_unity'] ? 'yes' : 'no') . 
            // ", Cross-device likely: " . ($deviceInfo['likely_needs_cross_device'] ? 'yes' : 'no') . 
            // ", Found " . count($userCredentialSources) . " passkeys");
        }

        // Dynamic timeout based on device type
        if ($deviceInfo['likely_needs_cross_device'] || $deviceInfo['is_unity']) {
            $timeout = 120000; // 2 minutes for cross-device or Unity
        } elseif ($deviceInfo['is_mobile'] || $deviceInfo['is_tablet']) {
            $timeout = 90000; // 1.5 minutes for mobile devices
        } else {
            $timeout = 60000; // 1 minute default
        }

        $rpId = is_string($this->publicKeyCredentialRpEntity->id) ? $this->publicKeyCredentialRpEntity->id : null;

        $publicKeyCredentialRequestOptions = PublicKeyCredentialRequestOptions::create(
            challenge: $challenge,
            timeout: $timeout,
            rpId: $rpId,
            allowCredentials: $allowedCredentials,
            userVerification: AuthenticatorSelectionCriteria::USER_VERIFICATION_REQUIREMENT_PREFERRED,
            extensions: null
        );

        $_SESSION['passkey_assertion_options'] = [
            'challenge' => base64_encode($challenge),
            'challenge_raw' => $challenge,
            'timeout' => $timeout,
            'rp_id' => $rpId,
            'user_verification' => AuthenticatorSelectionCriteria::USER_VERIFICATION_REQUIREMENT_PREFERRED,
            'device_info' => $deviceInfo,
            'allowed_credentials' => array_map(function ($cred) {
                return [
                    'type' => $cred->type,
                    'id' => base64_encode($cred->id),
                    'id_raw' => $cred->id,
                    'transports' => $cred->transports
                ];
            }, $allowedCredentials),
            'timestamp' => time()
        ];

        if ($userId) {
            $_SESSION['passkey_assertion_user_id_for_verification'] = (string) $userId;
        }

        $logContext = $userId ?? 'general_login';
        $discoverable = empty($allowedCredentials) && !$userId;
        // logger($logContext, 'PasskeyAuthChallengeGenerated', 
        // 'Assertion options generated. Discoverable: ' . ($discoverable ? 'yes' : 'no') . 
        // ', Challenge: ' . $this->binaryToHex($challenge) . 
        // ', Device: ' . ($deviceInfo['is_mobile'] ? 'mobile' : ($deviceInfo['is_unity'] ? 'unity' : 'desktop')) . 
        // ', Cross-device likely: ' . ($deviceInfo['likely_needs_cross_device'] ? 'yes' : 'no') . 
        // ', Timeout: ' . $timeout . 'ms');

        return $publicKeyCredentialRequestOptions;
    }

    public function validateAuthentication(array $authData, $expectedUserSpiceId = null): array
    {
        if (!isset($_SESSION['passkey_assertion_options'])) {
            // logger($expectedUserSpiceId ?? 'unknown_user_auth_validate', "PasskeyAuthFail", "Session: No passkey_assertion_options found.");
            throw new Exception(lang("PASSKEY_NO_AUTH_CHALLENGE_SESSION"));
        }

        $sessionOptions = $_SESSION['passkey_assertion_options'];
        $sessionExpectedUserHandle = $_SESSION['passkey_assertion_user_id_for_verification'] ?? null;
        unset($_SESSION['passkey_assertion_options']);
        unset($_SESSION['passkey_assertion_user_id_for_verification']);

        $actualUserHandleForLog = 'unknown_user_handle';

        try {
            // logger($expectedUserSpiceId ?? 'auth_validate', "PasskeyAuthDebug", "Auth data received: ID=" . substr($authData['id'], 0, 20) . "..., RawId length=" . strlen($authData['rawId']));

            $allowedCredentials = [];
            foreach ($sessionOptions['allowed_credentials'] as $credData) {
                $credId = $credData['id_raw'] ?? base64_decode($credData['id']);
                $allowedCredentials[] = new PublicKeyCredentialDescriptor(
                    $credData['type'],
                    $credId,
                    $credData['transports']
                );
            }

            $challenge = $sessionOptions['challenge_raw'] ?? base64_decode($sessionOptions['challenge']);

            $publicKeyCredentialRequestOptions = PublicKeyCredentialRequestOptions::create(
                challenge: $challenge,
                timeout: $sessionOptions['timeout'],
                rpId: $sessionOptions['rp_id'],
                allowCredentials: $allowedCredentials,
                userVerification: $sessionOptions['user_verification'],
                extensions: null
            );

            // logger($expectedUserSpiceId ?? 'auth_validate', "PasskeyAuthValidateChallenge", "Using challenge (hex): " . $this->binaryToHex($challenge));

            $serializerFactory = new WebauthnSerializerFactory(
                AttestationStatementSupportManager::create()
            );
            $serializer = $serializerFactory->create();

            $userHandle = null;
            if (isset($authData['response']['userHandle']) && $authData['response']['userHandle'] !== null && $authData['response']['userHandle'] !== '') {
                $userHandle = $this->base64urlEncode($authData['response']['userHandle']);
            }

            $authJson = json_encode([
                'id' => $authData['id'],
                'rawId' => $this->base64urlEncode($authData['rawId']),
                'type' => 'public-key',
                'response' => [
                    'clientDataJSON' => $this->base64urlEncode($authData['response']['clientDataJSON']),
                    'authenticatorData' => $this->base64urlEncode($authData['response']['authenticatorData']),
                    'signature' => $this->base64urlEncode($authData['response']['signature']),
                    'userHandle' => $userHandle
                ]
            ]);

            $publicKeyCredential = $serializer->deserialize($authJson, PublicKeyCredential::class, 'json');
            $authenticatorResponse = $publicKeyCredential->response;

            $credentialIdBinary = $authData['rawId'];
            // logger($expectedUserSpiceId ?? 'auth_validate', "PasskeyAuthLookup", "Looking up credential ID (hex): " . $this->binaryToHex($credentialIdBinary));

            $publicKeyCredentialSource = $this->userSpicePasskeyCredentialRepository->findOneByCredentialId($credentialIdBinary);

            if (!$publicKeyCredentialSource) {
                // logger($expectedUserSpiceId ?? 'unknown_user_auth_validate', "PasskeyAuthFail", "Credential ID not found in DB: " . $this->binaryToHex($credentialIdBinary));
                throw new Exception(lang("PASSKEY_CREDENTIAL_NOT_IN_DB"));
            }

            $actualUserHandle = $publicKeyCredentialSource->userHandle;
            $actualUserHandleForLog = $actualUserHandle;

            // logger($expectedUserSpiceId ?? 'auth_validate', "PasskeyAuthFound", "Credential found: UserHandle=" . $actualUserHandle);

            $userToAuthenticateHandle = (string)($expectedUserSpiceId ?? $sessionExpectedUserHandle ?? $actualUserHandle);

            if ($actualUserHandle !== $userToAuthenticateHandle) {
                // logger($userToAuthenticateHandle, "PasskeyAuthFail", "Credential user ID (".$actualUserHandle.") does not match expected user ID (".$userToAuthenticateHandle.").");
                throw new Exception(lang("PASSKEY_CREDENTIAL_WRONG_USER"));
            }

            $host = Server::getOrigin([]);

            // logger($userToAuthenticateHandle, "PasskeyAuthAttempt", "Validating assertion. RP ID: " . $this->publicKeyCredentialRpEntity->id . ". Host: " . $host);

            $updatedCredentialSource = $this->authenticatorAssertionResponseValidator->check(
                $publicKeyCredentialSource,
                $authenticatorResponse,
                $publicKeyCredentialRequestOptions,
                $host,
                $userToAuthenticateHandle
            );

            // logger($userToAuthenticateHandle, "PasskeyAuthValidated", "Assertion validated successfully. Counter updated from " . $publicKeyCredentialSource->counter . " to " . $updatedCredentialSource->counter);

            $this->userSpicePasskeyCredentialRepository->saveCredentialSource($updatedCredentialSource);

            $this->db->query("UPDATE us_passkeys SET times_used = times_used + 1, last_used = NOW(), last_ip = ? WHERE credential_id = ?", [
                Server::get('REMOTE_ADDR', ''),
                $updatedCredentialSource->publicKeyCredentialId
            ]);

            if ($this->db->error()) {
                // logger($userToAuthenticateHandle, 'PasskeyAuthWarning', 'Failed to update times_used/last_used for credential. DB Error: ' . $this->db->errorString());
            }

            // logger($userToAuthenticateHandle, 'PasskeyAuthSuccess', 'Authentication successful for credential ID (hex): ' . $this->binaryToHex($updatedCredentialSource->publicKeyCredentialId));
            return [
                'success' => true,
                'user_id' => $userToAuthenticateHandle,
                'credentialId' => $this->binaryToHex($updatedCredentialSource->publicKeyCredentialId)
            ];
        } catch (Throwable $e) {
            $logUserIdForError = $expectedUserSpiceId ?? ($sessionExpectedUserHandle ?? $actualUserHandleForLog ?? 'unknown_user_auth_validate_error');
            // logger($logUserIdForError, "PasskeyAuthFail", "Error validating passkey: " . $e->getMessage());
            throw new Exception(lang("PASSKEY_VALIDATION_FAILED_ERROR") . " " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Complete cross-device debugging and diagnostics
     */
    public function getDiagnosticInfo($userId = null): array
    {
        $deviceInfo = $this->getDetailedDeviceInfo();
        $context = $userId ?? 'system';

        $debugInfo = [
            'device_analysis' => $deviceInfo,
            'server_info' => [
                'host'            => Server::get('HTTP_HOST', 'unknown'),
                'origin'          => Server::get('HTTP_ORIGIN', 'unknown'),
                'user_agent'      => Server::get('HTTP_USER_AGENT', ''),
                'remote_addr'     => Server::get('REMOTE_ADDR', ''),
                'request_scheme'  => Server::getScheme(),
                'server_port'     => Server::get('SERVER_PORT', 0),
            ],
            'rp_config' => [
                'rp_id'   => $this->publicKeyCredentialRpEntity->id,
                'rp_name' => $this->publicKeyCredentialRpEntity->name,
            ],
            'session_info' => [
                'has_assertion_options' => isset($_SESSION['passkey_assertion_options']),
                'has_creation_options'  => isset($_SESSION['passkey_creation_options']),
                'session_id'            => session_id(),
            ],
            'network_analysis' => $this->analyzeNetworkConditions(),
            'recommendations'  => $this->getCrossDeviceRecommendations($deviceInfo),
        ];

        return $debugInfo;
    }

    /**
     * Validate current environment for cross-device authentication
     */
    public function validateCrossDeviceEnvironment($userId = null): array
    {
        $validation = [
            'is_suitable' => true,
            'warnings' => [],
            'errors' => [],
            'recommendations' => []
        ];

        $deviceInfo = $this->getDetailedDeviceInfo();
        $networkAnalysis = $this->analyzeNetworkConditions();

        // Check RP ID configuration
        $rpId = $this->publicKeyCredentialRpEntity->id;
        if (filter_var($rpId, FILTER_VALIDATE_IP)) {
            $validation['warnings'][] = lang("PASSKEY_VALIDATION_RP_IP") . " ($rpId)";
            $validation['recommendations'][] = lang("PASSKEY_VALIDATION_RP_DOMAIN");
        }

        // Check for HTTPS
        $isHttps = Server::getScheme() === 'https';
        if (!$isHttps && $rpId !== 'localhost') {
            $validation['errors'][] = lang("PASSKEY_VALIDATION_HTTPS_REQUIRED");
            $validation['is_suitable'] = false;
        }

        // Check network conditions
        if (!empty($networkAnalysis['likely_issues'])) {
            foreach ($networkAnalysis['likely_issues'] as $issue) {
                $validation['warnings'][] = lang("PASSKEY_VALIDATION_NETWORK") . ": $issue";
            }
            $validation['recommendations'][] = lang("PASSKEY_VALIDATION_TRY_DIFFERENT_NETWORK");
        }

        // Device-specific checks
        if ($deviceInfo['likely_needs_cross_device']) {
            $validation['recommendations'][] = lang("PASSKEY_VALIDATION_CROSS_DEVICE_INTERNET");
            $validation['recommendations'][] = lang("PASSKEY_VALIDATION_MOBILE_FALLBACK");
        }

        if ($userId) {
            // logger($userId, 'CrossDeviceValidation', 
            // 'Environment validation - Suitable: ' . ($validation['is_suitable'] ? 'yes' : 'no') . 
            // ', Warnings: ' . count($validation['warnings']) . 
            // ', Errors: ' . count($validation['errors']));
        }

        return $validation;
    }
}

// Global instantiation logic
global $db, $settings, $user;
$rpIdConfig = $settings->passkey_rp_id ?? null;
if (empty($rpIdConfig)) {
    $rpIdConfig = Server::get('HTTP_HOST', 'localhost');
    if ($rpIdConfig === '127.0.0.1') {
        $rpIdConfig = "localhost";
    }
}

if (filter_var($rpIdConfig, FILTER_VALIDATE_IP) && !in_array($rpIdConfig, ['127.0.0.1', '::1']) && $rpIdConfig !== 'localhost') {
    // logger(0, "PasskeyConfigWarning", "RP ID is an IP address (" . $rpIdConfig . ") which is not recommended for WebAuthn. Please configure 'passkey_rp_id' in settings with a domain name.");
}
$rpNameConfig = $settings->site_name ?? 'UserSpice Application';

$passkeyHandler = new PasskeyHandler($db, [
    'rpId' => $rpIdConfig,
    'rpName' => $rpNameConfig
]);