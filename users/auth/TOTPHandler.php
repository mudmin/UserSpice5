<?php
$currentSessionName = $config['session']['session_name'];
require_once $abs_us_root . $us_url_root . 'users/auth/vendor/autoload.php'; 
use PragmaRX\Google2FA\Google2FA;

class TOTPHandler
{
    private $db;
    private $google2fa;
    private $companyName;

    public function __construct($db, $companyName = 'UserSpice')
    {
        if ($db === null) {
            throw new Exception("Database connection is null in TOTPHandler.");
        }
        $this->db = $db;
        $this->google2fa = new Google2FA();
        $this->companyName = $companyName;
        
        // Ensure encryption is initialized
        global $abs_us_root, $us_url_root;
        $totpKeyFile = $abs_us_root . $us_url_root . 'usersc/includes/totp_key.php';
        totp_init_encryption($totpKeyFile);
    }

    public function generateSecret(): string
    {
        return $this->google2fa->generateSecretKey();
    }

    public function getQRCodeUrl(string $email, string $secret): string
    {
        return $this->google2fa->getQRCodeUrl(
            $this->companyName,
            $email, // Changed from username to email
            $secret
        );
    }

public function getQRCodeImageDataUri(string $email, string $secret): string
{
    $uri = $this->google2fa->getQRCodeUrl(
        $this->companyName,
        $email,
        $secret
    );

    try {
        /* ---------- 1. SVG – no PHP extensions required (Bacon 2.x) ---- */
        if (class_exists('\BaconQrCode\Renderer\Image\SvgImageBackEnd')) {
            $renderer = new \BaconQrCode\Renderer\ImageRenderer(
                new \BaconQrCode\Renderer\RendererStyle\RendererStyle(256),
                new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
            );
            $writer  = new \BaconQrCode\Writer($renderer);
            $svgData = $writer->writeString($uri);

            return 'data:image/svg+xml;base64,' . base64_encode($svgData);
        }

        /* ---------- 2. GD – needs only the very common php-gd ----------- */
        if (extension_loaded('gd') &&
            class_exists('\BaconQrCode\Renderer\Image\GDLibRenderer')) {

            $renderer = new \BaconQrCode\Renderer\Image\GDLibRenderer(
                new \BaconQrCode\Renderer\RendererStyle\RendererStyle(256)
            );
            $writer   = new \BaconQrCode\Writer($renderer);
            $pngData  = $writer->writeString($uri);

            return 'data:image/png;base64,' . base64_encode($pngData);
        }

        /* ---------- 3. Bacon 1.x fallback (Image\Png) ------------------- */
        if (class_exists('\BaconQrCode\Renderer\Image\Png')) {
            $renderer = new \BaconQrCode\Renderer\Image\Png();
            $writer   = new \BaconQrCode\Writer($renderer);
            $pngData  = $writer->writeString($uri);

            return 'data:image/png;base64,' . base64_encode($pngData);
        }

        /* ---------- 4. Nothing left – abort ---------------------------- */
        throw new \Exception(lang('2FA_FATAL'));

    } catch (\Exception $e) {
        // Pass the error up the stack for whatever logging/handling you already have
        throw $e;
    }
}


    public function verifyCode(string $secret, string $code, int $window = 1): bool
    {
        try {
            return $this->google2fa->verifyKey($secret, $code, $window);
        } catch (\PragmaRX\Google2FA\Exceptions\InsecureKeyException $e) {
            // logger(0, "TOTP_Error", "Insecure key used: " . $e->getMessage());
            return false;
        } catch (\PragmaRX\Google2FA\Exceptions\InvalidCharactersException $e) {
            // logger(0, "TOTP_Error", "Invalid characters in code: " . $e->getMessage());
            return false;
        } catch (\PragmaRX\Google2FA\Exceptions\WrongKeyLengthException $e) {
            // logger(0, "TOTP_Error", "Wrong key length: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            // logger(0, "TOTP_Error", "General verification error: " . $e->getMessage());
            return false;
        }
    }

    public function generateBackupCodes(int $count = 10, int $length = 10): array
    {
        $backupCodes = [];
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Made uppercase for consistency
        $charLength = strlen($characters);

        for ($i = 0; $i < $count; $i++) {
            $randomString = '';
            for ($j = 0; $j < $length; $j++) {
                $randomString .= $characters[random_int(0, $charLength - 1)]; // Use secure random_int instead of rand
            }

            // Format for easier readability
            if ($length == 8) {
                $backupCodes[] = substr($randomString, 0, 4) . '-' . substr($randomString, 4, 4);
            } elseif ($length == 10) {
                $backupCodes[] = substr($randomString, 0, 5) . '-' . substr($randomString, 5, 5);
            } else {
                $backupCodes[] = $randomString;
            }
        }
        return $backupCodes;
    }

    /**
     * Hash backup codes using password_hash with cost 10
     */
    private function hashBackupCodes(array $backupCodes): array
    {
        $hashedCodes = [];
        foreach ($backupCodes as $code) {
            $hashedCodes[] = password_hash($code, PASSWORD_DEFAULT, ['cost' => 10]);
        }
        return $hashedCodes;
    }

    public function storeUserTOTP(int $userId, string $secret, array $backupCodes): bool
    {
        try {
            // Encrypt the secret
            $encryptedSecret = totp_encrypt($secret);
            
            // Hash the backup codes
            $hashedBackupCodes = $this->hashBackupCodes($backupCodes);
            $encodedBackupCodes = json_encode($hashedBackupCodes);

            // Check if a record already exists
            $existing = $this->db->query("SELECT id FROM us_totp_secrets WHERE user_id = ?", [$userId])->first();

            if ($existing) {
                // Update existing record, reset verified status as new secret is being stored
                $fields = [
                    'secret_enc' => $encryptedSecret,
                    'backup_codes_h' => $encodedBackupCodes,
                    'verified' => 0,
                    'updated_at' => date("Y-m-d H:i:s")
                ];
                $result = $this->db->update('us_totp_secrets', $existing->id, $fields);
                if (!$result || $this->db->error()) {
                    // logger($userId, "TOTP_Error", "Failed to update TOTP secret: " . $this->db->errorString());
                    return false;
                }
                // logger($userId, "TOTP_Setup", "TOTP secret updated and awaiting verification.");
            } else {
                // Insert new record
                $fields = [
                    'user_id' => $userId,
                    'secret_enc' => $encryptedSecret,
                    'backup_codes_h' => $encodedBackupCodes,
                    'verified' => 0,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];
                $result = $this->db->insert('us_totp_secrets', $fields);
                if (!$result || $this->db->error()) {
                    // logger($userId, "TOTP_Error", "Failed to store TOTP secret: " . $this->db->errorString());
                    return false;
                }
                // logger($userId, "TOTP_Setup", "TOTP secret stored and awaiting verification.");
            }
            return true;
        } catch (Exception $e) {
            // logger($userId, "TOTP_Error", "Exception in storeUserTOTP: " . $e->getMessage());
            return false;
        }
    }

    public function activateUserTOTP(int $userId): bool
    {
        try {
            $this->db->query("UPDATE us_totp_secrets SET verified = 1, updated_at = ? WHERE user_id = ?", [date("Y-m-d H:i:s"), $userId]);
            if ($this->db->error() || $this->db->count() == 0) {
                // logger($userId, "TOTP_Error", "Failed to activate TOTP or no record found: " . $this->db->errorString());
                return false;
            }

            // Also update the users table
            $result = $this->db->update('users', $userId, ['totp_enabled' => 1]);
            if (!$result || $this->db->error()) {
                // logger($userId, "TOTP_Error", "Failed to update users.totp_enabled flag during activation: " . $this->db->errorString());
                // Don't fail completely, the main TOTP record is activated
            }

            // logger($userId, "TOTP_Setup", "TOTP successfully activated.");
            return true;
        } catch (Exception $e) {
            logger($userId, "TOTP_Error", "Exception in activateUserTOTP: " . $e->getMessage());
            return false;
        }
    }

    public function isTOTPEnabled(int $userId): bool
    {
        try {
            $record = $this->db->query("SELECT verified FROM us_totp_secrets WHERE user_id = ?", [$userId])->first();
            return $record && $record->verified == 1;
        } catch (Exception $e) {
            // logger($userId, "TOTP_Error", "Exception checking TOTP status: " . $e->getMessage());
            return false;
        }
    }

    public function getUserSecret(int $userId): ?string
    {
        try {
            $record = $this->db->query("SELECT secret_enc FROM us_totp_secrets WHERE user_id = ? AND verified = 1", [$userId])->first();
            if ($record && $record->secret_enc) {
                return totp_decrypt($record->secret_enc);
            }
            return null;
        } catch (Exception $e) {
            // logger($userId, "TOTP_Error", "Exception getting user secret: " . $e->getMessage());
            return null;
        }
    }

    public function getUserRecord(int $userId)
    {
        try {
            return $this->db->query("SELECT * FROM us_totp_secrets WHERE user_id = ?", [$userId])->first();
        } catch (Exception $e) {
            // logger($userId, "TOTP_Error", "Exception getting user record: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get backup codes (returns hashed versions from DB - not for display)
     * This is used internally for verification
     */
    private function getHashedBackupCodes(int $userId): array
    {
        try {
            $record = $this->db->query("SELECT backup_codes_h FROM us_totp_secrets WHERE user_id = ? AND verified = 1", [$userId])->first();
            if ($record && $record->backup_codes_h) {
                $decoded = json_decode($record->backup_codes_h, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    return $decoded;
                }
                // logger($userId, "TOTP_Error", "Failed to decode backup codes from DB: " . json_last_error_msg());
            }
            return [];
        } catch (Exception $e) {
            // logger($userId, "TOTP_Error", "Exception getting backup codes: " . $e->getMessage());
            return [];
        }
    }

    public function invalidateBackupCode(int $userId, string $codeToInvalidate): bool
    {
        try {
            $currentHashedCodes = $this->getHashedBackupCodes($userId);
            if (empty($currentHashedCodes)) {
                // logger($userId, "TOTP_Warning", "Attempted to invalidate backup code, but no codes found.");
                return false;
            }

            $updatedCodes = [];
            $foundMatch = false;

            foreach ($currentHashedCodes as $hashedCode) {
                if (!$foundMatch && password_verify($codeToInvalidate, $hashedCode)) {
                    $foundMatch = true;
                    // Skip this code (remove it from the array)
                    continue;
                }
                $updatedCodes[] = $hashedCode;
            }

            if (!$foundMatch) {
                // logger($userId, "TOTP_Warning", "Attempted to invalidate backup code, but code not found.");
                return false;
            }

            $encodedBackupCodes = json_encode($updatedCodes);

            $this->db->query(
                "UPDATE us_totp_secrets SET backup_codes_h = ?, updated_at = ? WHERE user_id = ?",
                [$encodedBackupCodes, date("Y-m-d H:i:s"), $userId]
            );

            if ($this->db->error()) {
                // logger($userId, "TOTP_Error", "Failed to update backup codes in DB: " . $this->db->errorString());
                return false;
            }

            // logger($userId, "TOTP_Security", "Backup code used and invalidated.");
            return true;
        } catch (Exception $e) {
            // logger($userId, "TOTP_Error", "Exception invalidating backup code: " . $e->getMessage());
            return false;
        }
    }

    public function verifyBackupCode(int $userId, string $codeToVerify): bool
    {
        try {
            $currentHashedCodes = $this->getHashedBackupCodes($userId);
            foreach ($currentHashedCodes as $hashedCode) {
                if (password_verify($codeToVerify, $hashedCode)) {
                    return true;
                }
            }
            return false;
        } catch (Exception $e) {
            // logger($userId, "TOTP_Error", "Exception verifying backup code: " . $e->getMessage());
            return false;
        }
    }

    public function disableTOTP(int $userId): bool
    {
        try {
            $this->db->query("DELETE FROM us_totp_secrets WHERE user_id = ?", [$userId]);
            if ($this->db->error()) {
                // logger($userId, "TOTP_Error", "Failed to delete TOTP record: " . $this->db->errorString());
                return false;
            }

            if ($this->db->count() == 0) {
                // logger($userId, "TOTP_Warning", "Attempted to disable TOTP, but no record found for user.");
                // If no record exists, TOTP is already disabled
            }

            // Also update the users table
            $result = $this->db->update('users', $userId, ['totp_enabled' => 0]);
            if (!$result || $this->db->error()) {
                // logger($userId, "TOTP_Error", "Failed to update users.totp_enabled flag during disable: " . $this->db->errorString());
            }

            // logger($userId, "TOTP_Setup", "TOTP disabled for user.");
            return true;
        } catch (Exception $e) {
            // logger($userId, "TOTP_Error", "Exception disabling TOTP: " . $e->getMessage());
            return false;
        }
    }
}