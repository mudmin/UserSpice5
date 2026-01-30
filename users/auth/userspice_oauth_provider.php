<?php
class UserSpiceOAuthProvider {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function handleRequest() {
        $requestUri = Server::get('REQUEST_URI');
        
        if (strpos($requestUri, '/oauth/authorize') !== false) {
            return $this->handleAuthorizationRequest();
        } elseif (strpos($requestUri, '/oauth/token') !== false) {
            return $this->handleTokenRequest();
        } elseif (strpos($requestUri, '/oauth/userinfo') !== false) {
            return $this->handleUserInfoRequest();
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Not Found']);
        }
    }

public function handleAuthorizationRequest() {
    $clientId = $_GET['client_id'] ?? '';
    $redirectUri = $_GET['redirect_uri'] ?? '';
    $responseType = $_GET['response_type'] ?? '';
    $state = $_GET['state'] ?? '';
    $scope = $_GET['scope'] ?? '';

    // Validate required parameters
    if (empty($clientId)) {
        return $this->sendErrorResponse('invalid_request', 'Missing client_id parameter');
    }

    if (empty($redirectUri)) {
        // If redirect_uri is not provided, try to get it from database
        $clientData = $this->db->query("SELECT redirect_uri FROM us_oauth_server_clients WHERE client_id = ? AND client_enabled = 1", [$clientId])->first();
        if (!$clientData) {
            return $this->sendErrorResponse('invalid_client', 'Invalid client_id');
        }
        $redirectUri = $clientData->redirect_uri;
    }

    // Validate response_type (only 'code' is supported)
    if (!empty($responseType) && $responseType !== 'code') {
        return $this->redirectWithError($redirectUri, 'unsupported_response_type', $state);
    }

    // Validate client exists and is enabled
    $clientData = $this->db->query("SELECT * FROM us_oauth_server_clients WHERE client_id = ? AND client_enabled = 1", [$clientId])->first();
    if (!$clientData) {
        return $this->redirectWithError($redirectUri, 'invalid_client', $state);
    }

    // Validate redirect_uri matches registered URI
    if ($redirectUri !== $clientData->redirect_uri) {
        // dump($redirectUri); dump($clientData->redirect_uri);
        return $this->sendErrorResponse('invalid_request', 'Invalid redirect_uri, expected ' . $clientData->redirect_uri);
    }

    logger(1, "OAuth Server", "Valid authorization request received for client: $clientId");

    return [
        'client_id' => $clientId,
        'redirect_uri' => $redirectUri,
        'response_type' => $responseType ?: 'code',
        'state' => $state,
        'scope' => $scope,
        'login_title' => $clientData->login_title,
        'login_form' => $clientData->login_form
    ];
}

    public function generateAuthCode($userId, $clientId, $redirectUri) {
        // Verify the client ID and redirect URI
        if (!$this->verifyClient($clientId, $redirectUri)) {
            logger(1, "OAuth Server", "Invalid client ID or redirect URI: $clientId, $redirectUri");
            return false;
        }
    
        $authCode = bin2hex(random_bytes(16));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        
        $result = $this->db->insert('us_oauth_server_codes', [
            'client_id' => $clientId,
            'user_id' => $userId,
            'auth_code' => $authCode,
            'redirect_uri' => $redirectUri,
            'expires_at' => $expiresAt
        ]);
        
        if ($result) {
            logger(1, "OAuth Server", "Generated auth code: $authCode for user: $userId and client: $clientId");
            return $authCode;
        } else {
            logger(1, "OAuth Server", "Failed to generate auth code. Error: " . $this->db->errorString());
            return false;
        }
    }

    private function sendJsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function handleUserInfoRequest() {
        $accessToken = $this->getBearerToken();
        $userId = $this->validateAccessToken($accessToken);
        
        if (!$userId) {
            $this->sendJsonResponse(['error' => 'invalid_token'], 401);
            return;
        }

        $user = new User($userId);
        $userInfo = [
            'sub' => $userId,
            'name' => $user->data()->fname . ' ' . $user->data()->lname,
            'email' => $user->data()->email
        ];

        $this->sendJsonResponse($userInfo);
    }

    private function verifyClient($clientId, $redirectUri) {
        $q = $this->db->query("SELECT * FROM us_oauth_server_clients WHERE client_id = ? AND redirect_uri = ? AND client_enabled = 1", [$clientId, $redirectUri]);
        
        if ($q->count() == 0) {
            logger(1, "OAuth Server", "Invalid or disabled client: $clientId, $redirectUri");
            return false;
        }
        
        return true;
    }

    private function verifyClientCredentials($clientId, $clientSecret) {
        // SECURITY: Fetch client and verify secret using password_verify for timing-safe comparison
        // Supports both hashed secrets (preferred) and plaintext secrets (deprecated, pending migration)
        $q = $this->db->query("SELECT client_secret FROM us_oauth_server_clients WHERE client_id = ?", [$clientId]);
        if ($q->count() === 0) {
            return false;
        }
        $storedSecret = $q->first()->client_secret;

        // Check if it's a bcrypt hash (starts with $2) or plaintext
        if (strpos($storedSecret, '$2') === 0) {
            // Hashed secret - use password_verify (preferred)
            return password_verify($clientSecret, $storedSecret);
        } else {
            // Plaintext secret (deprecated) - use timing-safe comparison
            // Admin UI will show warning and migration option for these clients
            return hash_equals($storedSecret, $clientSecret);
        }
    }

    private function validateAuthCode($authCode, $clientId) {
        logger(1, "OAuth Server", "Validating auth code: $authCode for client: $clientId");
        $q = $this->db->query("SELECT user_id, expires_at FROM us_oauth_server_codes WHERE auth_code = ? AND client_id = ?", [$authCode, $clientId]);
        
        if ($q->error()) {
            logger(1, "OAuth Server", "Database error during auth code validation: " . $this->db->errorString());
            return false;
        }
    
        if ($q->count() > 0) {
            $row = $q->first();
            $userId = $row->user_id;
            $expiresAt = strtotime($row->expires_at);
            
            if ($expiresAt > time()) {
                $deleteResult = $this->db->delete('us_oauth_server_codes', ['auth_code' => $authCode]);
                if (!$deleteResult) {
                    logger(1, "OAuth Server", "Failed to delete used auth code. Error: " . $this->db->errorString());
                }
                logger(1, "OAuth Server", "Auth code valid for user: $userId");
                return $userId;
            } else {
                logger(1, "OAuth Server", "Auth code expired. Expired at: " . date('Y-m-d H:i:s', $expiresAt));
            }
        } else {
            logger(1, "OAuth Server", "Auth code not found in database");
        }
        return false;
    }
    
    public function handleTokenRequest() {
        // SECURITY FIX: Don't log sensitive data like client_secret
        $safeLogData = [
            'client_id' => $_POST['client_id'] ?? '[not provided]',
            'grant_type' => $_POST['grant_type'] ?? '[not provided]',
            'has_code' => isset($_POST['code']) ? 'yes' : 'no',
            'has_secret' => isset($_POST['client_secret']) ? 'yes' : 'no'
        ];
        logger(1, "OAuth Server", "Received token request: " . json_encode($safeLogData));

        $clientId = $_POST['client_id'] ?? '';
        $clientSecret = $_POST['client_secret'] ?? '';
        $grantType = $_POST['grant_type'] ?? '';
        $authCode = $_POST['code'] ?? '';

        // Rate limiting - treat OAuth token requests like login attempts
        $rateLimit = new RateLimit();
        $rateLimitIdentifiers = ['ip' => $rateLimit->getRealIP()];

        if (!$rateLimit->check('login_attempt', $rateLimitIdentifiers)) {
            logger(0, "OAuth Server", "Rate limit exceeded for token request");
            $this->sendJsonResponse(['error' => 'too_many_requests', 'error_description' => 'Rate limit exceeded'], 429);
            return;
        }

        // Retrieve redirect_uri from the database based on client_id
        $clientData = $this->db->query("SELECT redirect_uri FROM us_oauth_server_clients WHERE client_id = ?", [$clientId])->first();
        $redirectUri = $clientData->redirect_uri;

        if (!$this->verifyClientCredentials($clientId, $clientSecret)) {
            logger(1, "OAuth Server", "Invalid client credentials: $clientId");
            $rateLimit->record('login_attempt', $rateLimitIdentifiers, false, ['type' => 'oauth_invalid_client']);
            $this->sendJsonResponse(['error' => 'invalid_client'], 401);
            return;
        }

        if ($grantType !== 'authorization_code') {
            logger(1, "OAuth Server", "Unsupported grant type: $grantType");
            $this->sendJsonResponse(['error' => 'unsupported_grant_type'], 400);
            return;
        }

        $userId = $this->validateAuthCode($authCode, $clientId);

        if (!$userId) {
            // SECURITY FIX: Don't log the actual auth code
            logger(1, "OAuth Server", "Invalid auth code for client: $clientId");
            $rateLimit->record('login_attempt', $rateLimitIdentifiers, false, ['type' => 'oauth_invalid_code']);
            $this->sendJsonResponse(['error' => 'invalid_grant'], 400);
            return;
        }

        $accessToken = $this->generateAccessToken($userId, $clientId);

        // Record success and clear failed attempts
        $rateLimit->record('login_attempt', $rateLimitIdentifiers, true, ['type' => 'oauth_token']);
        $rateLimit->clearFailed('login_attempt', $rateLimitIdentifiers);

        $response = [
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'expires_in' => 3600 // 1 hour
        ];
        // SECURITY FIX: Don't log access tokens - log success without sensitive data
        logger(1, "OAuth Server", "Token issued successfully for user: $userId, client: $clientId");
        $this->sendJsonResponse($response);
    }

    private function generateAccessToken($userId, $clientId) {
        $accessToken = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $this->db->insert('us_oauth_server_tokens', [
            'access_token' => $accessToken,
            'user_id' => $userId,
            'client_id' => $clientId,
            'expires_at' => $expiresAt
        ]);
        
        return $accessToken;
    }

    private function validateAccessToken($accessToken) {
        $q = $this->db->query("SELECT user_id FROM us_oauth_server_tokens WHERE access_token = ? AND expires_at > NOW()", [$accessToken]);
        return $q->count() > 0 ? $q->first()->user_id : false;
    }

    private function getBearerToken() {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

private function sendErrorResponse($error, $description = null) {
    http_response_code(400);
    header('Content-Type: application/json');
    $response = ['error' => $error];
    if ($description) {
        $response['error_description'] = $description;
    }
    echo json_encode($response);
    logger(1, "OAuth Server Error", "Error response sent: $error - $description");
    return false;
}

private function redirectWithError($redirectUri, $error, $state = null) {
    $args = ['error' => $error];
    if ($state) {
        $args['state'] = $state;
    }

    // Log the intended redirect for debugging
    $intendedUrl = $redirectUri . '?' . http_build_query($args);
    $msg = Input::sanitize( "Redirecting with error: $error to $intendedUrl");
    logger(1, "OAuth Server Error", $msg);
    

    Redirect::sanitized($redirectUri, $args);
    // Note: Redirect::sanitized() calls exit(), so the script will stop here.
    return false;
}

}
