<?php

/**
 * UserSpice Rate Limiting Class v1.2
 * Provides database-backed rate limiting for all authentication operations
 * All data is sanitized at the class level
 */
class RateLimit
{
	private $db;
	private $rateLimits;
	private $proxyConfig;

	public function __construct($database = null)
	{
		global $db, $abs_us_root, $us_url_root, $rateLimits;
		$this->db = $database ?? $db;

		if (!isset($rateLimits)) {
			require_once $abs_us_root . $us_url_root . 'users/includes/rate_limits.php';
		}
		$this->rateLimits = $rateLimits;

		$this->loadProxyConfig();
		$this->createTableIfNotExists();
	}

	/**
	 * Check if an action is allowed under rate limits.
	 * This checks against both failed attempt limits and total attempt limits.
	 *
	 * @param string $action The action being performed
	 * @param array $identifiers Array of identifiers (user_id, email, etc.)
	 * @return bool True if allowed, false if rate limited
	 */
	public function check($action, $identifiers = [])
	{
		$action = $this->sanitizeAction($action);
		if (!$action || !isset($this->rateLimits[$action])) {
			return true; // No limits defined for this action
		}

		$limits = $this->rateLimits[$action];
		$identifiers = $this->sanitizeIdentifiers($identifiers);

		// Add default IP identifier if not present and a valid IP is found
		if (!isset($identifiers['ip'])) {
			$ip = $this->getRealIP();
			if ($ip) {
				$identifiers['ip'] = $ip;
			}
		}

		foreach ($identifiers as $type => $value) {
			if (empty($value)) continue;

			$identifier = $this->buildIdentifierKey($type, $value);

			// Check failed attempts limit
			$maxKey = $type . '_max';
			$windowKey = $type . '_window';

			if (isset($limits[$maxKey]) && isset($limits[$windowKey])) {
				$maxAttempts = (int)$limits[$maxKey];
				$windowSeconds = (int)$limits[$windowKey];

				if ($maxAttempts > 0 && $windowSeconds > 0) {
					$failedCount = $this->getAttemptCount($identifier, $action, $windowSeconds, false);
					if ($failedCount >= $maxAttempts) {
						logger(0, "RateLimit", "Rate limit (failed attempts) exceeded for $action on $type.");
						return false;
					}
				}
			}

			// [RESTORED] Check total attempts limit if configured
			$totalMaxKey = 'total_max';
			$totalWindowKey = 'total_window';
			if (isset($limits[$totalMaxKey]) && isset($limits[$totalWindowKey])) {
				$totalMax = (int)$limits[$totalMaxKey];
				$totalWindow = (int)$limits[$totalWindowKey];

				if ($totalMax > 0 && $totalWindow > 0) {
					$totalCount = $this->getAttemptCount($identifier, $action, $totalWindow, null);
					if ($totalCount >= $totalMax) {
						logger(0, "RateLimit", "Rate limit (total attempts) exceeded for $action on $type.");
						return false;
					}
				}
			}
		}

		return true;
	}

	/**
	 * Record an attempt (success or failure).
	 *
	 * @param string $action The action being performed
	 * @param array $identifiers Array of identifiers
	 * @param bool $success Whether the attempt was successful
	 * @param array $metadata Optional metadata to store
	 */
	public function record($action, $identifiers = [], $success = false, $metadata = [])
	{
		$action = $this->sanitizeAction($action);
		if (!$action) return false;

		$identifiers = $this->sanitizeIdentifiers($identifiers);
		if (!isset($identifiers['ip'])) {
			$ip = $this->getRealIP();
			if ($ip) {
				$identifiers['ip'] = $ip;
			}
		}

		$success = (bool)$success;
		$metadata = $this->sanitizeMetadata($metadata);
		$now = date('Y-m-d H:i:s');

		foreach ($identifiers as $type => $value) {
			if (empty($value)) continue;

			$identifier = $this->buildIdentifierKey($type, $value);
			$this->db->insert('us_rate_limits', [
				'identifier_key' => $identifier,
				'action' => $action,
				'success' => $success ? 1 : 0,
				'attempt_time' => $now,
				'metadata' => json_encode($metadata)
			]);
		}
		return true;
	}

	/**
	 * Clear failed attempts for successful authentication.
	 *
	 * @param string $action The action that succeeded
	 * @param array $identifiers Array of identifiers to clear
	 */
	public function clearFailed($action, $identifiers = [])
	{
		$action = $this->sanitizeAction($action);
		if (!$action) return false;

		$identifiers = $this->sanitizeIdentifiers($identifiers);
		if (!isset($identifiers['ip'])) {
			$ip = $this->getRealIP();
			if ($ip) {
				$identifiers['ip'] = $ip;
			}
		}

		foreach ($identifiers as $type => $value) {
			if (empty($value)) continue;

			$identifier = $this->buildIdentifierKey($type, $value);
			$this->db->delete('us_rate_limits', ['identifier_key' => $identifier, 'action' => $action, 'success' => 0]);
		}

		logger(0, "RateLimit", "Cleared failed attempts for $action: " . implode(', ', array_keys($identifiers)));
		return true;
	}

	/**
	 * Get rate limit status for debugging.
	 *
	 * @param string $action The action to check
	 * @param array $identifiers Array of identifiers
	 * @return array Status information
	 */
	public function getStatus($action, $identifiers = [])
	{
		$action = $this->sanitizeAction($action);
		if (!$action) return ['configured' => false, 'error' => 'Invalid action'];
		if (!isset($this->rateLimits[$action])) return ['configured' => false];

		$limits = $this->rateLimits[$action];
		$status = [
			'configured' => true,
			'action' => $action,
			'limits' => $limits,
			'identifiers' => []
		];

		$identifiers = $this->sanitizeIdentifiers($identifiers);
		if (!isset($identifiers['ip'])) {
			$ip = $this->getRealIP();
			if ($ip) {
				$identifiers['ip'] = $ip;
			}
		}

		foreach ($identifiers as $type => $value) {
			if (empty($value)) continue;

			$identifier = $this->buildIdentifierKey($type, $value);

			$maxAttempts = 0;
			$windowSeconds = 0;
			$failedCount = 0;
			$isLimited = false;

			// Status for failed attempts
			$maxKey = $type . '_max';
			$windowKey = $type . '_window';
			if (isset($limits[$maxKey]) && isset($limits[$windowKey])) {
				$maxAttempts = (int)$limits[$maxKey];
				$windowSeconds = (int)$limits[$windowKey];
				if ($windowSeconds > 0) {
					$failedCount = $this->getAttemptCount($identifier, $action, $windowSeconds, false);
				}
				if ($maxAttempts > 0 && $failedCount >= $maxAttempts) {
					$isLimited = true;
				}
			}

			// [RESTORED] Status for total attempts
			$totalCount = 0;
			$totalWindowKey = 'total_window';
			if (isset($limits[$totalWindowKey]) && $limits[$totalWindowKey] > 0) {
				$totalCount = $this->getAttemptCount($identifier, $action, (int)$limits[$totalWindowKey], null);

				$totalMaxKey = 'total_max';
				if (isset($limits[$totalMaxKey]) && $limits[$totalMaxKey] > 0) {
					if ($totalCount >= (int)$limits[$totalMaxKey]) {
						$isLimited = true;
					}
				}
			}

			$status['identifiers'][$type] = [
				'value' => $value,
				'failed_attempts' => $failedCount,
				'total_attempts' => $totalCount, // Restored this key
				'max_allowed' => $maxAttempts,
				'window_seconds' => $windowSeconds,
				'is_limited' => $isLimited,
			];
		}

		return $status;
	}

	/**
	 * Create the rate limits table if it doesn't exist.
	 */
	private function createTableIfNotExists()
	{
		if ($this->db->tableExists('us_rate_limits')) return true;

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
	 * Clean up old rate limit records.
	 * @param int $olderThanHours Remove records older than this many hours
	 */
	public function cleanup($olderThanHours = 24)
	{
		$olderThanHours = max(1, (int)$olderThanHours);
		$cutoffTime = date('Y-m-d H:i:s', time() - ($olderThanHours * 3600));
		$this->db->delete('us_rate_limits', ['attempt_time', '<', $cutoffTime]);
		$count = $this->db->count();
		if ($count > 0) {
			logger(0, "RateLimit", "Cleaned up $count old rate limit records");
		}
		return $count;
	}

	// ============== PROXY AND IP DETECTION METHODS ==============

	private function loadProxyConfig()
	{
		global $settings;

		$this->proxyConfig = [

			'behind_reverse_proxy' => isset($settings->behind_reverse_proxy) && (bool)$settings->behind_reverse_proxy,
			'trusted_proxies'      => [],
			'trusted_headers'      => [],
		];

		try {

			$result = $this->db->query(
				"SELECT proxy_ip, header_name, priority 
                 FROM us_rate_limit_proxy_settings 
                 WHERE enabled = 1 
                 ORDER BY priority ASC"
			);

			if ($result && !$result->error()) {
				foreach ($result->results() as $row) {
					$this->proxyConfig['trusted_proxies'][] = trim($row->proxy_ip);
					$this->proxyConfig['trusted_headers'][$row->header_name] = (int)$row->priority;
				}
			}
		} catch (Exception $e) {
			// Fails gracefully if db/tables don't exist yet
			logger(0, "RateLimit", "Could not load proxy config: " . $e->getMessage());
		}
	}

	public function getRealIP()
	{
		$remoteAddr = Server::get('REMOTE_ADDR', 'unknown');

		if (!$this->proxyConfig['behind_reverse_proxy'] || empty($this->proxyConfig['trusted_proxies'])) {
			return $this->validateIP($remoteAddr, false); // Check without disallowing private ranges
		}

		if (!$this->isTrustedProxy($remoteAddr)) {
			logger(0, "RateLimit", "Untrusted proxy detected: $remoteAddr");
			return $this->validateIP($remoteAddr);
		}

		$headers = $this->proxyConfig['trusted_headers'];
		asort($headers);

		foreach (array_keys($headers) as $header) {
			$serverHeader = 'HTTP_' . strtoupper(str_replace('-', '_', $header));

			if (!empty($_SERVER[$serverHeader])) {
				$ips = explode(',', $_SERVER[$serverHeader]);
				$clientIp = trim(end($ips)); // Get the last IP in the list
				if ($validatedIP = $this->validateIP($clientIp)) {
					return $validatedIP;
				}
			}
		}

		logger(0, "RateLimit", "No valid IP found in trusted headers, falling back to REMOTE_ADDR.");
		return $this->validateIP($remoteAddr, false);
	}

	private function validateIP($ip, $noPrivate = true)
	{
		$flags = FILTER_FLAG_NO_RES_RANGE;
		if ($noPrivate) {
			$flags |= FILTER_FLAG_NO_PRIV_RANGE;
		}
		return filter_var($ip, FILTER_VALIDATE_IP, $flags) ? $ip : false;
	}

	private function isTrustedProxy($ip)
	{
		if (!filter_var($ip, FILTER_VALIDATE_IP)) {
			return false;
		}

		$ip_long = ip2long($ip);
		if ($ip_long === false) return false;

		foreach ($this->proxyConfig['trusted_proxies'] as $proxyAddress) {
			if (strpos($proxyAddress, '/') !== false) {
				list($subnet, $mask) = explode('/', $proxyAddress, 2);
				if (filter_var($subnet, FILTER_VALIDATE_IP)) {
					$subnet_long = ip2long($subnet);
					$mask_long = ~((1 << (32 - (int)$mask)) - 1);
					if (($ip_long & $mask_long) == ($subnet_long & $mask_long)) {
						return true;
					}
				}
			} elseif ($ip === $proxyAddress) {
				return true;
			}
		}
		return false;
	}

	// ============== HELPER AND SANITIZATION METHODS ==============

	private function getAttemptCount($identifier, $action, $window, $success = null)
	{
		$window = (int)$window;
		if ($window <= 0 || empty($identifier)) return 0;

		$cutoffTime = date('Y-m-d H:i:s', time() - $window);
		$sql = "SELECT COUNT(*) as count FROM us_rate_limits WHERE identifier_key = ? AND action = ? AND attempt_time > ?";
		$params = [$identifier, $action, $cutoffTime];

		if ($success !== null) {
			$sql .= " AND success = ?";
			$params[] = $success ? 1 : 0;
		}

		$result = $this->db->query($sql, $params);
		return ($result && !$result->error()) ? (int)$result->first()->count : 0;
	}

	private function buildIdentifierKey($type, $value)
	{
		return hash('sha256', $type . '::' . (string)$value);
	}

	private function sanitizeAction($action)
	{
		if (!is_string($action) || !preg_match('/^[a-zA-Z0-9_]+$/', $action)) {
			return false;
		}
		$action = Input::sanitize($action);
		return (empty($action) || strlen($action) > 100) ? false : $action;
	}

	private function sanitizeIdentifiers($identifiers)
	{
		if (!is_array($identifiers)) return [];

		$sanitized = [];
		$allowedTypes = ['ip', 'user', 'email', 'token', 'session', 'credential'];

		foreach ($identifiers as $type => $value) {
			if (!in_array($type, $allowedTypes)) continue;

			$value = Input::sanitize($value);

			switch ($type) {
				case 'ip':
					if (filter_var($value, FILTER_VALIDATE_IP)) $sanitized[$type] = $value;
					break;
				case 'user':
					if (filter_var($value, FILTER_VALIDATE_INT) && (int)$value > 0) $sanitized[$type] = (int)$value;
					break;
				case 'email':
					if (filter_var($value, FILTER_VALIDATE_EMAIL)) $sanitized[$type] = strtolower(trim($value));
					break;
				case 'token':
				case 'session':
				case 'credential':
					if (!empty($value) && strlen($value) <= 255) $sanitized[$type] = $value;
					break;
			}
		}
		return $sanitized;
	}

	private function sanitizeMetadata($metadata)
	{
		return is_array($metadata) ? Input::recursive($metadata, true, false) : [];
	}
}
