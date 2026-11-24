<?php
class UserSpiceOAuthProvider {
    private $db;
    private $hasV1Schema = null;
    private $v1Gaps = [];
    private $corsHeadersSent = false;

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

    /**
     * Client version: 0 keeps the original contract (no PKCE, redirect_uri not
     * checked at the token step), 1 requires PKCE (S256) and redirect_uri.
     * Reads 0 until update 2026-11-10a adds the column.
     */
    public static function clientVersion($client) {
        return (int)($client->client_ver ?? 0);
    }

    /**
     * Public clients (apps that can't keep a secret) are only allowed at v1,
     * where PKCE stands in for the secret.
     */
    public static function isPublicClient($client) {
        return self::clientVersion($client) >= 1 && !empty($client->public_client);
    }

    /**
     * Parse an IP allowlist (addresses or CIDR ranges separated by commas,
     * spaces or new lines). Returns the entries, or false if any entry is invalid.
     */
    public static function parseIpList($list) {
        $entries = preg_split('/[\s,]+/', trim((string)$list), -1, PREG_SPLIT_NO_EMPTY);
        foreach ($entries as $entry) {
            $parts = explode('/', $entry, 2);
            $isV4 = filter_var($parts[0], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
            $isV6 = !$isV4 && filter_var($parts[0], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
            if (!$isV4 && !$isV6) {
                return false;
            }
            if (isset($parts[1]) && (!ctype_digit($parts[1]) || (int)$parts[1] > ($isV4 ? 32 : 128))) {
                return false;
            }
        }
        return $entries;
    }

    /**
     * Normalize a browser origin to scheme://host[:port] (lowercase, default
     * port dropped). Returns null for anything that isn't a plain origin.
     */
    public static function normalizeOrigin($origin) {
        if (!is_string($origin) || !preg_match('#^([a-z][a-z0-9+.-]*)://(\[[0-9a-f:.]+\]|[^/:?\#@\s\[\]]+)(?::(\d{1,5}))?/?$#i', trim($origin), $m)) {
            return null;
        }
        $scheme = strtolower($m[1]);
        $host = strtolower($m[2]);
        $port = $m[3] ?? '';
        if ($port !== '' && ((int)$port < 1 || (int)$port > 65535)) {
            return null;
        }
        if (($scheme === 'https' && $port === '443') || ($scheme === 'http' && $port === '80')) {
            $port = '';
        }
        return $scheme . '://' . $host . ($port !== '' ? ':' . (int)$port : '');
    }

    /**
     * Parse a list of allowed browser origins (separated by commas, spaces or
     * new lines). Returns the normalized origins, or false if any entry is invalid.
     */
    public static function parseOriginList($list) {
        $out = [];
        foreach (preg_split('/[\s,]+/', trim((string)$list), -1, PREG_SPLIT_NO_EMPTY) as $entry) {
            $origin = self::normalizeOrigin($entry);
            if ($origin === null) {
                return false;
            }
            $out[] = $origin;
        }
        return array_values(array_unique($out));
    }

    private static function requestOrigin() {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? null;
        return is_string($origin) ? self::normalizeOrigin($origin) : null;
    }

    private static function clientAllowsOrigin($client, $origin) {
        if (!$client || !self::isPublicClient($client)) {
            return false;
        }
        $allowed = self::parseOriginList($client->cors_origins ?? '');
        return is_array($allowed) && in_array($origin, $allowed, true);
    }

    /**
     * Is the origin registered on any enabled public client? Used for preflight
     * and error responses, where the client isn't known yet.
     */
    private function originRegistered($origin) {
        $q = $this->db->query(
            "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'us_oauth_server_clients' AND COLUMN_NAME = 'cors_origins'"
        );
        if ($this->db->error() || $q->count() < 1) {
            return false;
        }
        $clients = $this->db->query("SELECT * FROM us_oauth_server_clients WHERE client_enabled = 1 AND public_client = 1 AND cors_origins <> ''")->results();
        foreach ($clients as $client) {
            if (self::clientAllowsOrigin($client, $origin)) {
                return true;
            }
        }
        return false;
    }

    /**
     * CORS for browser-based public clients. With a client, the origin must be
     * registered on that client; without one (error responses), on any enabled
     * public client. Requests without an Origin header get nothing.
     */
    private function sendCorsHeaders($client = null) {
        if ($this->corsHeadersSent) {
            return;
        }
        $origin = self::requestOrigin();
        if ($origin === null) {
            return;
        }
        header('Vary: Origin');
        if ($client ? self::clientAllowsOrigin($client, $origin) : $this->originRegistered($origin)) {
            header('Access-Control-Allow-Origin: ' . $origin);
            $this->corsHeadersSent = true;
        }
    }

    /**
     * OPTIONS preflight for the token and userinfo endpoints.
     */
    public function handleCorsPreflight() {
        $origin = self::requestOrigin();
        if ($origin !== null) {
            header('Vary: Origin');
            if ($this->originRegistered($origin)) {
                header('Access-Control-Allow-Origin: ' . $origin);
                header('Access-Control-Allow-Methods: GET, POST');
                header('Access-Control-Allow-Headers: Authorization, Content-Type');
                header('Access-Control-Max-Age: 600');
            }
        }
        http_response_code(204);
        exit;
    }

    private function hasV1Schema() {
        if ($this->hasV1Schema === null) {
            $q = $this->db->query(
                "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'us_oauth_server_codes' AND COLUMN_NAME = 'code_challenge'"
            );
            $this->hasV1Schema = !$this->db->error() && $q->count() > 0;
        }
        return $this->hasV1Schema;
    }

    private function findEnabledClient($clientId) {
        if (!is_string($clientId) || $clientId === '') {
            return null;
        }
        return $this->db->query("SELECT * FROM us_oauth_server_clients WHERE client_id = ? AND client_enabled = 1", [$clientId])->first() ?: null;
    }

    /**
     * Codes and tokens are stored as "sha256:<hex>" so a database leak doesn't
     * expose usable credentials.
     */
    private static function storedHash($secret) {
        return 'sha256:' . hash('sha256', $secret);
    }

    /**
     * Values to match a presented code or token against: its hash, plus the raw
     * value for rows written before hashing (they expire within an hour).
     * Codes and tokens are always hex, so a presented stored hash never matches.
     */
    private static function lookupValues($secret, $length) {
        if (!is_string($secret) || strlen($secret) !== $length || !ctype_xdigit($secret)) {
            return null;
        }
        return [self::storedHash($secret), $secret];
    }

    /**
     * The registered redirect URI as plain text. Older admin saves stored it
     * HTML-escaped (& as &amp;), which would never match a real request.
     */
    private static function registeredRedirectUri($client) {
        return hed((string)($client->redirect_uri ?? ''));
    }

    private static function postString($key) {
        return isset($_POST[$key]) && is_string($_POST[$key]) ? $_POST[$key] : '';
    }

    private static function isS256Challenge($challenge, $method) {
        return $method === 'S256' && is_string($challenge) && preg_match('/^[A-Za-z0-9_-]{43}$/', $challenge) === 1;
    }

public function handleAuthorizationRequest() {
    $clientId = $_GET['client_id'] ?? '';
    $redirectUri = $_GET['redirect_uri'] ?? '';
    $responseType = $_GET['response_type'] ?? '';
    $state = $_GET['state'] ?? '';
    $scope = $_GET['scope'] ?? '';
    $codeChallenge = is_string($_GET['code_challenge'] ?? null) ? $_GET['code_challenge'] : '';
    $codeChallengeMethod = is_string($_GET['code_challenge_method'] ?? null) ? $_GET['code_challenge_method'] : '';

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
        $redirectUri = self::registeredRedirectUri($clientData);
    }

    // Validate client exists and is enabled
    $clientData = $this->db->query("SELECT * FROM us_oauth_server_clients WHERE client_id = ? AND client_enabled = 1", [$clientId])->first();
    if (!$clientData) {
        return $this->sendErrorResponse('invalid_client', 'Invalid client_id');
    }

    // Validate redirect_uri matches registered URI
    if (!is_string($redirectUri) || $redirectUri !== self::registeredRedirectUri($clientData)) {
        logger(1, "OAuth Server Error", "Redirect URI mismatch for client: $clientId. Provided: " . Input::sanitize((string)$redirectUri));
        return $this->sendErrorResponse('invalid_request', 'Invalid redirect_uri');
    }

    // Validate response_type (only 'code' is supported)
    if (!empty($responseType) && $responseType !== 'code') {
        return $this->redirectWithError($redirectUri, 'unsupported_response_type', $state);
    }

    if (self::clientVersion($clientData) >= 1) {
        if (!self::isS256Challenge($codeChallenge, $codeChallengeMethod)) {
            logger(1, "OAuth Server", "Authorization request without a valid S256 code_challenge for v1 client: $clientId");
            return $this->redirectWithError($redirectUri, 'invalid_request', $state, 'code_challenge with code_challenge_method=S256 is required');
        }
    } elseif (!self::isS256Challenge($codeChallenge, $codeChallengeMethod)) {
        // v0 never enforces PKCE. A well-formed S256 challenge is kept only to
        // report whether the client is ready for v1.
        $codeChallenge = '';
        $codeChallengeMethod = '';
    }

    logger(1, "OAuth Server", "Valid authorization request received for client: $clientId");

    return [
        'client_id' => $clientId,
        'redirect_uri' => $redirectUri,
        'response_type' => $responseType ?: 'code',
        'state' => $state,
        'scope' => $scope,
        'login_title' => $clientData->login_title,
        'login_form' => $clientData->login_form,
        'code_challenge' => $codeChallenge,
        'code_challenge_method' => $codeChallengeMethod
    ];
}

    public function generateAuthCode($userId, $clientId, $redirectUri, $codeChallenge = '', $codeChallengeMethod = '') {
        // Verify the client ID and redirect URI
        if (!$this->verifyClient($clientId, $redirectUri)) {
            logger(1, "OAuth Server", "Invalid client ID or redirect URI: $clientId, $redirectUri");
            return false;
        }

        // Banned users (permissions = 0) never get codes
        $perm = $this->db->query("SELECT permissions FROM users WHERE id = ?", [$userId])->first();
        if (!$perm || (int)$perm->permissions === 0) {
            logger($userId, "OAuth Server", "Auth code refused for banned or missing user");
            return false;
        }

        $authCode = bin2hex(random_bytes(16));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        $fields = [
            'client_id' => $clientId,
            'user_id' => $userId,
            'auth_code' => self::storedHash($authCode),
            'redirect_uri' => $redirectUri,
            'expires_at' => $expiresAt
        ];
        if ($codeChallenge !== '' && $this->hasV1Schema()) {
            $fields['code_challenge'] = $codeChallenge;
            $fields['code_challenge_method'] = $codeChallengeMethod;
        }

        $result = $this->db->insert('us_oauth_server_codes', $fields);

        if ($result) {
            logger(1, "OAuth Server", "Generated auth code for user: $userId and client: $clientId");
            return $authCode;
        } else {
            logger(1, "OAuth Server", "Failed to generate auth code. Error: " . $this->db->errorString());
            return false;
        }
    }

    private function sendJsonResponse($data, $statusCode = 200) {
        if ($statusCode >= 400) {
            $this->sendCorsHeaders();
        }
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * GET or POST users/auth/userinfo.php with "Authorization: Bearer <access token>".
     * Returns standard OpenID Connect claims for the token's user.
     */
    public function handleUserInfoRequest() {
        $accessToken = $this->getBearerToken();
        if ($accessToken === null) {
            header('WWW-Authenticate: Bearer');
            $this->sendJsonResponse(['error' => 'invalid_request', 'error_description' => 'Bearer token required'], 401);
        }

        $token = $this->validateAccessToken($accessToken);
        $client = $token ? $this->findEnabledClient((string)$token->client_id) : null;
        if (!$token || !$client || !$this->ipAllowed($client)) {
            $this->sendInvalidToken();
        }

        $this->sendCorsHeaders($client);
        $u = $this->db->query("SELECT id, fname, lname, email, email_verified, permissions FROM users WHERE id = ?", [$token->user_id])->first();
        if (!$u || (int)$u->permissions === 0) {
            logger((int)$token->user_id, "OAuth Server", "Userinfo refused for banned or missing user, client: {$client->client_id}");
            $this->sendInvalidToken();
        }

        // Profile fields are stored HTML-escaped; return the plain values.
        header('Cache-Control: no-store');
        header('Pragma: no-cache');
        $this->sendJsonResponse([
            'sub' => (string)$u->id,
            'name' => trim(hed($u->fname) . ' ' . hed($u->lname)),
            'given_name' => hed($u->fname),
            'family_name' => hed($u->lname),
            'email' => hed($u->email),
            'email_verified' => (int)$u->email_verified === 1
        ]);
    }

    private function sendInvalidToken() {
        header('WWW-Authenticate: Bearer error="invalid_token"');
        $this->sendJsonResponse(['error' => 'invalid_token'], 401);
    }

    private function verifyClient($clientId, $redirectUri) {
        $client = $this->findEnabledClient((string)$clientId);

        if (!$client || !is_string($redirectUri) || $redirectUri !== self::registeredRedirectUri($client)) {
            logger(1, "OAuth Server", "Invalid or disabled client: $clientId, $redirectUri");
            return false;
        }

        return true;
    }

    private function secretMatches($client, $clientSecret) {
        $storedSecret = (string)$client->client_secret;

        // bcrypt hash (preferred), or a plaintext secret from before hashing,
        // which the admin page flags for migration
        if (strpos($storedSecret, '$2') === 0) {
            return password_verify($clientSecret, $storedSecret);
        }
        return $storedSecret !== '' && hash_equals($storedSecret, $clientSecret);
    }

    /**
     * Opt-in per-client allowlist for the token and userinfo endpoints.
     * Uses the resolved client address (ClientIP::get()), not peer(): this is a
     * second check on top of the client secret, and behind a CDN peer() is the
     * CDN's address.
     */
    private function ipAllowed($client) {
        if (empty($client->ip_restrict_on) || self::isPublicClient($client)) {
            return true;
        }
        $ip = ClientIP::get();
        $entries = self::parseIpList($client->ip_restrict ?? '');
        if ($entries === false || $entries === []) {
            logger(1, "OAuth Server", "IP allowlist for client {$client->client_id} is empty or invalid; refusing request from $ip");
            return false;
        }
        foreach ($entries as $entry) {
            if (ClientIP::inRange($ip, $entry)) {
                return true;
            }
        }
        logger(1, "OAuth Server", "Request for client {$client->client_id} refused: $ip is not in its IP allowlist");
        return false;
    }

    private function verifyPkce($codeVerifier, $codeChallenge, $codeChallengeMethod) {
        if ($codeChallengeMethod !== 'S256' || !preg_match('/^[A-Za-z0-9._~-]{43,128}$/', $codeVerifier)) {
            return false;
        }
        $computed = rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');
        return hash_equals((string)$codeChallenge, $computed);
    }

    private function redeemAuthCode($authCode, $client, $redirectUri, $codeVerifier) {
        $clientId = $client->client_id;
        $this->v1Gaps = [];
        logger(1, "OAuth Server", "Validating auth code for client: $clientId");

        $lookup = self::lookupValues($authCode, 32);
        if ($lookup === null) {
            return false;
        }

        $q = $this->db->query("SELECT * FROM us_oauth_server_codes WHERE auth_code IN (?, ?) AND client_id = ?", [$lookup[0], $lookup[1], $clientId]);
        if ($q->error()) {
            logger(1, "OAuth Server", "Database error during auth code validation: " . $this->db->errorString());
            return false;
        }
        if ($q->count() < 1) {
            logger(1, "OAuth Server", "Auth code not found in database");
            return false;
        }
        $row = $q->first();

        // Only the request whose delete removes the row may use the code, so
        // concurrent requests can't both redeem it. Any failure below also burns it.
        $this->db->query("DELETE FROM us_oauth_server_codes WHERE id = ?", [$row->id]);
        if ($this->db->error() || $this->db->count() !== 1) {
            logger(1, "OAuth Server", "Auth code already redeemed for client: $clientId");
            return false;
        }

        $expiresAt = strtotime($row->expires_at);
        if ($expiresAt <= time()) {
            logger(1, "OAuth Server", "Auth code expired. Expired at: " . date('Y-m-d H:i:s', $expiresAt));
            return false;
        }

        // Before update 2026-11-10a the column is a tinyint holding 0, not a URI.
        $storedRedirect = is_string($row->redirect_uri ?? null) && strpos($row->redirect_uri, ':') !== false ? $row->redirect_uri : '';
        $redirectOk = $redirectUri !== '' && $storedRedirect !== '' && hash_equals($storedRedirect, $redirectUri);
        $challenge = $row->code_challenge ?? '';
        $pkceOk = !empty($challenge) && $this->verifyPkce($codeVerifier, $challenge, $row->code_challenge_method ?? '');

        if (self::clientVersion($client) >= 1) {
            if (!$redirectOk) {
                logger(1, "OAuth Server", "Auth code refused for v1 client $clientId: redirect_uri missing or different from the authorization request");
                return false;
            }
            if (!$pkceOk) {
                logger(1, "OAuth Server", "Auth code refused for v1 client $clientId: PKCE verification failed");
                return false;
            }
        } else {
            if (empty($challenge)) {
                $this->v1Gaps[] = 'no PKCE';
            } elseif (!$pkceOk) {
                $this->v1Gaps[] = 'PKCE verifier mismatch';
            }
            if ($redirectUri === '') {
                $this->v1Gaps[] = 'no redirect_uri';
            } elseif ($storedRedirect !== '' && !$redirectOk) {
                $this->v1Gaps[] = 'redirect_uri mismatch';
            }
        }

        logger(1, "OAuth Server", "Auth code valid for user: {$row->user_id}");
        return $row->user_id;
    }

    public function handleTokenRequest() {
        $safeLogData = [
            'client_id' => self::postString('client_id') ?: '[not provided]',
            'grant_type' => self::postString('grant_type') ?: '[not provided]',
            'has_code' => isset($_POST['code']) ? 'yes' : 'no',
            'has_secret' => isset($_POST['client_secret']) ? 'yes' : 'no',
            'has_verifier' => isset($_POST['code_verifier']) ? 'yes' : 'no'
        ];
        logger(1, "OAuth Server", "Received token request: " . json_encode($safeLogData));

        $clientId = self::postString('client_id');
        $clientSecret = self::postString('client_secret');
        $grantType = self::postString('grant_type');
        $authCode = self::postString('code');
        $redirectUri = self::postString('redirect_uri');
        $codeVerifier = self::postString('code_verifier');

        // Rate limiting - treat OAuth token requests like login attempts
        $rateLimit = new RateLimit();
        $rateLimitIdentifiers = ['ip' => $rateLimit->getRealIP()];

        if (!$rateLimit->check('login_attempt', $rateLimitIdentifiers)) {
            logger(0, "OAuth Server", "Rate limit exceeded for token request");
            $this->sendJsonResponse(['error' => 'too_many_requests', 'error_description' => 'Rate limit exceeded'], 429);
            return;
        }

        // The grant is authenticated by the client secret (or PKCE for public
        // clients) plus the auth code, which is bound to this client_id.
        $client = $this->findEnabledClient($clientId);
        $this->sendCorsHeaders($client);
        $authenticated = $client
            && $this->ipAllowed($client)
            && (self::isPublicClient($client) || $this->secretMatches($client, $clientSecret));
        if (!$authenticated) {
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

        $userId = $this->redeemAuthCode($authCode, $client, $redirectUri, $codeVerifier);

        if (!$userId) {
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
            'expires_in' => 3600, // 1 hour
            // Server-confirmed identity; clients use this instead of the unsigned redirect data.
            'email' => $this->db->query("SELECT email FROM users WHERE id = ?", [$userId])->first()->email ?? null
        ];
        $version = self::clientVersion($client) >= 1 ? 'v1' : 'v0; ' . ($this->v1Gaps ? 'not v1-ready: ' . implode(', ', $this->v1Gaps) : 'v1-ready');
        logger(1, "OAuth Server", "Token issued successfully for user: $userId, client: $clientId ($version)");
        header('Cache-Control: no-store');
        header('Pragma: no-cache');
        $this->sendJsonResponse($response);
    }

    private function generateAccessToken($userId, $clientId) {
        $accessToken = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $this->db->insert('us_oauth_server_tokens', [
            'access_token' => self::storedHash($accessToken),
            'user_id' => $userId,
            'client_id' => $clientId,
            'expires_at' => $expiresAt
        ]);

        return $accessToken;
    }

    private function validateAccessToken($accessToken) {
        $lookup = self::lookupValues($accessToken, 64);
        if ($lookup === null) {
            return false;
        }
        // expires_at is written in PHP's timezone, so compare in PHP rather than with MySQL NOW().
        $row = $this->db->query("SELECT user_id, client_id, expires_at FROM us_oauth_server_tokens WHERE access_token IN (?, ?)", [$lookup[0], $lookup[1]])->first();
        return $row && strtotime($row->expires_at) > time() ? $row : false;
    }

    private function getBearerToken() {
        // Apache + PHP-FPM only passes the header through when configured to, e.g.
        // SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1
        $header = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';
        if ($header === '' && function_exists('apache_request_headers')) {
            foreach (apache_request_headers() as $name => $value) {
                if (strcasecmp($name, 'Authorization') === 0) {
                    $header = $value;
                    break;
                }
            }
        }
        if (is_string($header) && preg_match('/Bearer\s+(\S+)/i', $header, $matches)) {
            return $matches[1];
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
    exit;
}

private function redirectWithError($redirectUri, $error, $state = null, $description = null) {
    $args = ['error' => $error];
    if ($description) {
        $args['error_description'] = $description;
    }
    if ($state) {
        $args['state'] = $state;
    }

    // Log the intended redirect for debugging
    $intendedUrl = $redirectUri . '?' . http_build_query($args);
    $msg = Input::sanitize( "Redirecting with error: $error to $intendedUrl");
    logger(1, "OAuth Server Error", $msg);


    Redirect::sanitized($redirectUri, $args, 302, ['same_origin' => false, 'allowed_hosts' => [parse_url($redirectUri, PHP_URL_HOST)]]);
    // Note: Redirect::sanitized() calls exit(), so the script will stop here.
    return false;
}

}
