<?php

/**
 * UserSpice Rate Limiting Class
 * Provides database-backed rate limiting for all authentication operations
 * All data is sanitized at the class level
 */

class RateLimit
{
	private $db;
	private $rateLimits;

	public function __construct($database = null)
	{
		global $db, $abs_us_root, $us_url_root, $rateLimits;

		$this->db = $database ?? $db;

		// Load rate limit configuration
		if (!isset($rateLimits)) {
			require_once $abs_us_root . $us_url_root . 'users/includes/rate_limits.php';
		}
		$this->rateLimits = $rateLimits;

		// Ensure rate limits table exists
		$this->createTableIfNotExists();
	}

	/**
	 * Check if an action is allowed under rate limits
	 * 
	 * @param string $action The action being performed
	 * @param array $identifiers Array of identifiers (ip, user_id, email, etc.)
	 * @return bool True if allowed, false if rate limited
	 */
	public function check($action, $identifiers = [])
	{
		// Sanitize action parameter
		$action = $this->sanitizeAction($action);
		if (!$action) {
			return false;
		}

		if (!isset($this->rateLimits[$action])) {
			// No limits defined for this action - allow it
			return true;
		}

		$limits = $this->rateLimits[$action];
		$now = time();

		// Sanitize and validate identifiers
		$identifiers = $this->sanitizeIdentifiers($identifiers);

		// Add default IP identifier if not present
		if (!isset($identifiers['ip'])) {
			$identifiers['ip'] = $this->getRealIP();
		}

		// Check each identifier type
		foreach ($identifiers as $type => $value) {
			if (empty($value)) continue;

			$maxKey = $type . '_max';
			$windowKey = $type . '_window';

			if (!isset($limits[$maxKey]) || !isset($limits[$windowKey])) {
				continue; // No limits for this identifier type
			}

			// Cast limits to integers for safety
			$maxAttempts = (int)$limits[$maxKey];
			$windowSeconds = (int)$limits[$windowKey];

			if ($maxAttempts <= 0 || $windowSeconds <= 0) {
				continue; // Invalid configuration
			}

			$identifier = $this->buildIdentifierKey($type, $value);

			// Check failed attempts
			$failedCount = $this->getAttemptCount($identifier, $action, $windowSeconds, false);
			if ($failedCount >= $maxAttempts) {
				logger(0, "RateLimit", "Rate limit exceeded for $action: $identifier ($failedCount failed attempts)");
				return false;
			}

			// Check total attempts if configured
			$totalMaxKey = 'total_max';
			$totalWindowKey = 'total_window';
			if (isset($limits[$totalMaxKey]) && isset($limits[$totalWindowKey])) {
				$totalMax = (int)$limits[$totalMaxKey];
				$totalWindow = (int)$limits[$totalWindowKey];

				if ($totalMax > 0 && $totalWindow > 0) {
					$totalCount = $this->getAttemptCount($identifier, $action, $totalWindow, null);
					if ($totalCount >= $totalMax) {
						logger(0, "RateLimit", "Total rate limit exceeded for $action: $identifier ($totalCount total attempts)");
						return false;
					}
				}
			}
		}

		return true;
	}

	/**
	 * Record an attempt (success or failure)
	 * 
	 * @param string $action The action being performed
	 * @param array $identifiers Array of identifiers
	 * @param bool $success Whether the attempt was successful
	 * @param array $metadata Optional metadata to store
	 */
	public function record($action, $identifiers = [], $success = false, $metadata = [])
	{
		// Sanitize action parameter
		$action = $this->sanitizeAction($action);
		if (!$action) {
			return false;
		}

		// Sanitize and validate identifiers
		$identifiers = $this->sanitizeIdentifiers($identifiers);

		// Add default IP identifier if not present
		if (!isset($identifiers['ip'])) {
			$identifiers['ip'] = $this->getRealIP();
		}

		// Sanitize success flag
		$success = (bool)$success;

		// Sanitize metadata
		$metadata = $this->sanitizeMetadata($metadata);

		$now = time();

		// Record attempt for each identifier
		foreach ($identifiers as $type => $value) {
			if (empty($value)) continue;

			$identifier = $this->buildIdentifierKey($type, $value);

			$fields = [
				'identifier_key' => $identifier,
				'action' => $action,
				'success' => $success ? 1 : 0,
				'attempt_time' => date('Y-m-d H:i:s', $now),
				'metadata' => json_encode($metadata)
			];

			$this->db->insert('us_rate_limits', $fields);
		}

		return true;
	}

	/**
	 * Clear failed attempts for successful authentication
	 * 
	 * @param string $action The action that succeeded
	 * @param array $identifiers Array of identifiers to clear
	 */
	public function clearFailed($action, $identifiers = [])
	{
		// Sanitize action parameter
		$action = $this->sanitizeAction($action);
		if (!$action) {
			return false;
		}

		// Sanitize and validate identifiers
		$identifiers = $this->sanitizeIdentifiers($identifiers);

		// Add default IP identifier if not present
		if (!isset($identifiers['ip'])) {
			$identifiers['ip'] = $this->getRealIP();
		}

		foreach ($identifiers as $type => $value) {
			if (empty($value)) continue;

			$identifier = $this->buildIdentifierKey($type, $value);

			$where = [
				'identifier_key' => $identifier,
				'action' => $action,
				'success' => 0
			];

			$this->db->delete('us_rate_limits', $where);
		}

		logger(0, "RateLimit", "Cleared failed attempts for $action: " . implode(', ', array_keys($identifiers)));
		return true;
	}

	/**
 * Get current attempt count for an identifier
 * 
 * @param string $identifier The identifier key
 * @param string $action The action
 * @param int $window Time window in seconds
 * @param bool|null $success Filter by success (true/false) or null for all
 * @return int Number of attempts
 */
private function getAttemptCount($identifier, $action, $window, $success = null)
{
	// Cast window to integer for safety
	$window = (int)$window;
	if ($window <= 0) {
		return 0;
	}

	$cutoffTime = date('Y-m-d H:i:s', time() - $window);
	
	// Build base SQL query
	$sql = "SELECT COUNT(*) as count FROM us_rate_limits WHERE identifier_key = ? AND action = ? AND attempt_time > ?";
	$params = [$identifier, $action, $cutoffTime];
	
	// Add success filter if specified
	if ($success !== null) {
		$sql .= " AND success = ?";
		$params[] = $success ? 1 : 0;
	}
	
	$result = $this->db->query($sql, $params);
	
	if ($result && !$result->error()) {
		$row = $result->first();
		return $row ? (int)$row->count : 0;
	}
	
	return 0;
}

	/**
	 * Get the real IP address, accounting for proxies
	 * 
	 * @return string IP address
	 */
	private function getRealIP()
	{
		// Check for Cloudflare
		if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
			$ip = trim($_SERVER['HTTP_CF_CONNECTING_IP']);
			if (filter_var($ip, FILTER_VALIDATE_IP)) {
				return $ip;
			}
		}

		// Check for other common proxy headers
		$headers = [
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_REAL_IP',
			'HTTP_CLIENT_IP'
		];

		foreach ($headers as $header) {
			if (!empty($_SERVER[$header])) {
				$ips = explode(',', $_SERVER[$header]);
				$ip = trim($ips[0]);
				if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
					return $ip;
				}
			}
		}

		// Fallback to REMOTE_ADDR
		$remoteAddr = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
		if (filter_var($remoteAddr, FILTER_VALIDATE_IP)) {
			return $remoteAddr;
		}

		return 'unknown';
	}

	/**
	 * Clean up old rate limit records
	 * Should be called periodically (e.g., via cron)
	 * 
	 * @param int $olderThanHours Remove records older than this many hours
	 */
	public function cleanup($olderThanHours = 24)
	{
		// Cast to integer for safety
		$olderThanHours = max(1, (int)$olderThanHours);

		$cutoffTime = date('Y-m-d H:i:s', time() - ($olderThanHours * 3600));

		$where = [
			['attempt_time', '<', $cutoffTime]
		];

		$result = $this->db->delete('us_rate_limits', $where);

		if ($result && $this->db->count() > 0) {
			logger(0, "RateLimit", "Cleaned up " . $this->db->count() . " old rate limit records");
		}

		return $this->db->count();
	}

	/**
	 * Get rate limit status for debugging
	 * 
	 * @param string $action The action to check
	 * @param array $identifiers Array of identifiers
	 * @return array Status information
	 */
	public function getStatus($action, $identifiers = [])
	{
		// Sanitize action parameter
		$action = $this->sanitizeAction($action);
		if (!$action) {
			return ['configured' => false, 'error' => 'Invalid action'];
		}

		if (!isset($this->rateLimits[$action])) {
			return ['configured' => false];
		}

		$limits = $this->rateLimits[$action];
		$status = [
			'configured' => true,
			'action' => $action,
			'limits' => $limits,
			'identifiers' => []
		];

		// Sanitize and validate identifiers
		$identifiers = $this->sanitizeIdentifiers($identifiers);

		// Add default IP identifier if not present
		if (!isset($identifiers['ip'])) {
			$identifiers['ip'] = $this->getRealIP();
		}

		foreach ($identifiers as $type => $value) {
			if (empty($value)) continue;

			$maxKey = $type . '_max';
			$windowKey = $type . '_window';

			if (!isset($limits[$maxKey]) || !isset($limits[$windowKey])) {
				continue;
			}

			$maxAttempts = (int)$limits[$maxKey];
			$windowSeconds = (int)$limits[$windowKey];

			$identifier = $this->buildIdentifierKey($type, $value);
			$failedCount = $this->getAttemptCount($identifier, $action, $windowSeconds, false);
			$totalCount = $this->getAttemptCount($identifier, $action, $windowSeconds, null);

			$status['identifiers'][$type] = [
				'value' => $value,
				'failed_attempts' => $failedCount,
				'total_attempts' => $totalCount,
				'max_allowed' => $maxAttempts,
				'window_seconds' => $windowSeconds,
				'is_limited' => $failedCount >= $maxAttempts
			];
		}

		return $status;
	}

	/**
	 * Create the rate limits table if it doesn't exist
	 */
	private function createTableIfNotExists()
	{
		if ($this->db->tableExists('us_rate_limits')) {
			return true;
		}

		$sql = "CREATE TABLE IF NOT EXISTS us_rate_limits (
            id INT AUTO_INCREMENT PRIMARY KEY,
            identifier_key VARCHAR(255) NOT NULL,
            action VARCHAR(100) NOT NULL,
            success TINYINT(1) DEFAULT 0,
            attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            metadata JSON NULL,
            INDEX idx_identifier_action (identifier_key, action),
            INDEX idx_attempt_time (attempt_time),
            INDEX idx_cleanup (attempt_time, success)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

		$result = $this->db->query($sql);

		if ($result->error()) {
			throw new Exception("Failed to create rate limits table: " . $this->db->errorString());
		}

		return true;
	}

	/**
	 * Sanitize action parameter
	 * 
	 * @param string $action
	 * @return string|false Sanitized action or false if invalid
	 */
	private function sanitizeAction($action)
	{
		if (!is_string($action)) {
			return false;
		}

		// Use Input::sanitize for basic sanitization
		$action = Input::sanitize($action);

		// Additional validation for action names - only allow alphanumeric and underscore
		if (!preg_match('/^[a-zA-Z0-9_]+$/', $action)) {
			return false;
		}

		if (empty($action) || strlen($action) > 100) {
			return false;
		}

		return $action;
	}

	/**
	 * Sanitize identifiers array
	 * 
	 * @param array $identifiers
	 * @return array Sanitized identifiers
	 */
	private function sanitizeIdentifiers($identifiers)
	{
		if (!is_array($identifiers)) {
			return [];
		}

		// Use Input::sanitize for basic sanitization first
		$identifiers = Input::sanitize($identifiers);

		$sanitized = [];
		$allowedTypes = ['ip', 'user', 'email', 'token', 'session', 'credential'];

		foreach ($identifiers as $type => $value) {
			// Validate type key
			if (!is_string($type) || !in_array($type, $allowedTypes)) {
				continue;
			}

			// Additional validation based on type
			switch ($type) {
				case 'ip':
					if (filter_var($value, FILTER_VALIDATE_IP)) {
						$sanitized[$type] = $value;
					}
					break;

				case 'user':
					$userId = filter_var($value, FILTER_VALIDATE_INT);
					if ($userId !== false && $userId > 0) {
						$sanitized[$type] = $userId;
					}
					break;

				case 'email':
					if (filter_var($value, FILTER_VALIDATE_EMAIL) && strlen($value) <= 255) {
						$sanitized[$type] = strtolower(trim($value));
					}
					break;

				case 'token':
				case 'credential':                
					if (is_string($value) && strlen($value) <= 255) {
						$sanitized[$type] = $value; 
					}
					break;
				case 'session':
					// For tokens and sessions, ensure reasonable length
					if (is_string($value) && !empty($value) && strlen($value) <= 255) {
						$sanitized[$type] = $value;
					}
					break;
			}
		}

		return $sanitized;
	}

	/**
	 * Sanitize metadata array
	 * 
	 * @param array $metadata
	 * @return array Sanitized metadata
	 */
	private function sanitizeMetadata($metadata)
	{
		if (!is_array($metadata)) {
			return [];
		}

		// Use Input class recursive sanitization
		return Input::recursive($metadata, true, false);
	}

	/**
	 * Build a safe identifier key
	 * 
	 * @param string $type
	 * @param mixed $value
	 * @return string
	 */
	private function buildIdentifierKey($type, $value)
	{
		// Convert value to string and truncate if necessary
		$valueStr = (string)$value;
		if (strlen($valueStr) > 200) {
			$valueStr = substr($valueStr, 0, 200);
		}

		return $type . '_' . $valueStr;
	}
}
