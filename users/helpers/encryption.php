<?php
/**
 * TOTP encryption helpers for UserSpice
 * ------------------------------------
 *  • Crypto back-end probe  (sodium → sodium_compat → OpenSSL AES-256-GCM)
 *  • Key-file generation & init
 *  • Encrypt / decrypt helpers
 *  • Git-ignore helper
 */

declare(strict_types=1);

/* ------------------------------------------------------------------ *
 |  1.  ENGINE DETECTION                                              |
 * ------------------------------------------------------------------ */

/**
 * Returns the crypto engine to use: 'sodium', 'openssl', or null (none).
 */
function totp_crypto_engine(): ?string
{
    // Native libsodium
    if (function_exists('sodium_crypto_secretbox')) {
        return 'sodium';
    }

    // sodium_compat polyfill (global class ParagonIE_Sodium_Compat)
    if (class_exists('ParagonIE_Sodium_Compat')) {
        return 'sodium';
    }

    // PHP’s OpenSSL extension with AES-256-GCM
    if (
        defined('OPENSSL_VERSION_TEXT')
        && in_array(
            'aes-256-gcm',
            array_map('strtolower', openssl_get_cipher_methods()),
            true
        )
    ) {
        return 'openssl';
    }

    return null;
}

/** Whether TOTP can be enabled on this host. */
function totp_is_crypto_available(): bool
{
    return totp_crypto_engine() !== null;
}


/* ------------------------------------------------------------------ *
 |  2.  KEY-FILE INIT                                                 |
 * ------------------------------------------------------------------ */

/**
 * Initialise encryption; generate/load key file; validate engine.
 *
 * @param string $totpKeyFile  Absolute path to usersc/includes/totp_key.php
 * @param bool   $migration    True during core migrations (non-fatal mode)
 */
function totp_init_encryption(string $totpKeyFile, bool $migration = false): void
{
    if (!defined('TOTP_ENC_KEY')) {

        if (file_exists($totpKeyFile)) {
            // ► Load existing key
            require_once $totpKeyFile;

            // ► Warn if engine changed
            if (
                defined('TOTP_CRYPTO_ENGINE')
                && TOTP_CRYPTO_ENGINE !== totp_crypto_engine()
            ) {
                $old = TOTP_CRYPTO_ENGINE;
                $new = totp_crypto_engine();

                if ($new === null) {
                    throw new RuntimeException(
                        "TOTP crypto engine '$old' no longer available; install missing extension."
                    );
                }

                error_log(
                    "TOTP NOTICE: crypto engine changed from '$old' to '$new'. " .
                    "Old secrets will be re-encrypted on first use."
                );
            }

        } else {
            // ► Autogenerate key file
            totp_generate_key_file($totpKeyFile);
        }
    }

    /* Final validation (skip during non-interactive migrations) */
    if (!$migration) {
        if (!defined('TOTP_ENC_KEY')) {
            throw new RuntimeException('TOTP_ENC_KEY not defined after init');
        }
        if (!totp_is_crypto_available()) {
            throw new RuntimeException('No crypto backend available for TOTP');
        }
    }
}



/**
 * Generate a new usersc/includes/totp_key.php (read-only, git-ignored)
 *
 * PREFERRED APPROACH: Use a .env file with TOTP_ENC_KEY and TOTP_CRYPTO_ENGINE
 * constants loaded via your environment configuration. This method is used as
 * a fallback when no .env configuration is detected.
 */
function totp_generate_key_file(string $totpKeyFile): void
{
    global $never_generate_totp_key_file;
    $never_generate_totp_key_file = $never_generate_totp_key_file ?? false;

    if (!totp_is_crypto_available()) {
        die('Cannot generate TOTP key: no crypto backend available.');
    }
    if ($never_generate_totp_key_file) {
        return; // developer override
    }

    /* Generate 32-byte master key */
    $rawKey       = random_bytes(32);
    $b64Key       = base64_encode($rawKey);
    $cryptoEngine = totp_crypto_engine();
    $dt           = date('Y-m-d\TH:i:sP');

    $php = <<<PHP
<?php
/**
 * TOTP Encryption Configuration
 *
 * SECURITY WARNING: DO NOT COMMIT THIS FILE.
 * Recommended permissions: 0400
 *
 * PREFERRED APPROACH: Store these values in your .env file instead:
 * TOTP_ENC_KEY=XXXXXXXXXXXXXXXXXXXXXXXX
 * TOTP_CRYPTO_ENGINE={$cryptoEngine}
 *
 * This file is designed to be used when an env file is not possible.
 * If you have an env file, you should delete this file and load your
 * constants from your .env file instead.
 * We've automatically added this file to your .gitignore (if one exists).
 *
 * --------------------------------------------------------------------
 * EXAMPLE: Loading constants from a .env file
 * --------------------------------------------------------------------
 * If you are using a library like 'vlucas/phpdotenv', you can load
 * the constants in your application's bootstrap file like this:
 *
 * require_once '/path/to/vendor/autoload.php';
 * \$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
 * \$dotenv->load();
 *
 * // Define constants from environment variables
 * define('TOTP_ENC_KEY', \$_ENV['TOTP_ENC_KEY']);
 * define('TOTP_CRYPTO_ENGINE', \$_ENV['TOTP_CRYPTO_ENGINE']);
 * 
 * // Then delete the constants from this file
 * --------------------------------------------------------------------
 *
 * Generated: {$dt}
 */
const TOTP_ENC_KEY = '{$b64Key}';
const TOTP_CRYPTO_ENGINE = '{$cryptoEngine}';

// To migrate servers, you may define TOTP_FORCE_CRYPTO_ENGINE
// const TOTP_FORCE_CRYPTO_ENGINE = 'sodium'; // or 'openssl'
PHP;

    if (file_put_contents($totpKeyFile, $php, LOCK_EX) === false) {
        die('Failed to write totp_key.php – check permissions.');
    }
    chmod($totpKeyFile, 0400);

    /* Make sure Git ignores it (automatically added if .gitignore exists) */
    totp_add_to_gitignore($totpKeyFile);

    /* Define for immediate use in current request */
    define('TOTP_ENC_KEY', $b64Key);
    define('TOTP_CRYPTO_ENGINE', $cryptoEngine);
}
/**
 * Append the key file to .gitignore (idempotent)
 */
function totp_add_to_gitignore(string $totpKeyFile): void
{
    global $abs_us_root, $us_url_root;

    $gitignore = $abs_us_root . $us_url_root . '.gitignore';
    if (!file_exists($gitignore)) {
        return;
    }

    $relative = str_replace($abs_us_root . $us_url_root, '', $totpKeyFile);
    $contents = file_get_contents($gitignore);
    if (strpos($contents, $relative) === false) {
        file_put_contents($gitignore, PHP_EOL . $relative . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}


/* ------------------------------------------------------------------ *
 |  3.  ACTIVE ENGINE (respect forced override)                       |
 * ------------------------------------------------------------------ */

function totp_get_active_crypto_engine(): ?string
{
    if (defined('TOTP_FORCE_CRYPTO_ENGINE')) {
        $forced = TOTP_FORCE_CRYPTO_ENGINE;

        switch ($forced) {
            case 'sodium':
                if (
                    function_exists('sodium_crypto_secretbox')
                    || class_exists('ParagonIE_Sodium_Compat')
                ) {
                    return 'sodium';
                }
                break;

            case 'openssl':
                if (
                    defined('OPENSSL_VERSION_TEXT')
                    && in_array(
                        'aes-256-gcm',
                        array_map('strtolower', openssl_get_cipher_methods()),
                        true
                    )
                ) {
                    return 'openssl';
                }
                break;
        }
        throw new RuntimeException("Forced crypto engine '$forced' not available");
    }

    return totp_crypto_engine();
}


/* ------------------------------------------------------------------ *
 |  4.  ENCRYPT / DECRYPT                                             |
 * ------------------------------------------------------------------ */

/** Encrypt plaintext with the site master key */
function totp_encrypt(string $plaintext): string
{
    if (!defined('TOTP_ENC_KEY')) {
        throw new RuntimeException('TOTP_ENC_KEY not defined; call totp_init_encryption() first.');
    }

    $key = base64_decode(TOTP_ENC_KEY, true);
    if ($key === false || strlen($key) !== 32) {
        throw new RuntimeException('Invalid TOTP_ENC_KEY');
    }

    switch (totp_get_active_crypto_engine()) {
        case 'sodium':
            $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
            $ct    = sodium_crypto_secretbox($plaintext, $nonce, $key);
            return base64_encode($nonce . $ct);

        case 'openssl':
            $iv  = random_bytes(12);  // 96-bit IV for GCM
            $tag = '';
            $ct  = openssl_encrypt(
                $plaintext,
                'aes-256-gcm',
                $key,
                OPENSSL_RAW_DATA,
                $iv,
                $tag
            );
            if ($ct === false) {
                throw new RuntimeException('OpenSSL encryption failed');
            }
            return base64_encode($iv . $tag . $ct);

        default:
            throw new RuntimeException('No crypto backend available');
    }
}

/** Decrypt cipher-blob */
function totp_decrypt(string $blob): string
{
    if (!defined('TOTP_ENC_KEY')) {
        throw new RuntimeException('TOTP_ENC_KEY not defined; call totp_init_encryption() first.');
    }

    $key = base64_decode(TOTP_ENC_KEY, true);
    if ($key === false || strlen($key) !== 32) {
        throw new RuntimeException('Invalid TOTP_ENC_KEY');
    }

    $bin = base64_decode($blob, true);
    if ($bin === false) {
        throw new RuntimeException('Invalid encrypted blob (base64 decode failed)');
    }

    /* 1️⃣ Try current engine */
    $pt = totp_decrypt_with_engine($bin, $key, totp_get_active_crypto_engine());

    /* 2️⃣ If that fails, try legacy engine stored in key file */
    if (
        $pt === false
        && defined('TOTP_CRYPTO_ENGINE')
        && TOTP_CRYPTO_ENGINE !== totp_get_active_crypto_engine()
    ) {
        $pt = totp_decrypt_with_engine($bin, $key, TOTP_CRYPTO_ENGINE);
    }

    if ($pt === false) {
        throw new RuntimeException('TOTP secret decryption failed');
    }

    return $pt;
}

/**
 * Internal helper – decrypt using a specified engine
 *
 * @return string|false  plaintext or false on failure
 */
function totp_decrypt_with_engine(string $bin, string $key, ?string $engine)
{
    switch ($engine) {
        case 'sodium':
            if (
                !function_exists('sodium_crypto_secretbox_open')
                && !class_exists('ParagonIE_Sodium_Compat')
            ) {
                return false;
            }
            $nonce = substr($bin, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
            $ct    = substr($bin, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
            return sodium_crypto_secretbox_open($ct, $nonce, $key);

        case 'openssl':
            if (
                !defined('OPENSSL_VERSION_TEXT')
                || !in_array(
                    'aes-256-gcm',
                    array_map('strtolower', openssl_get_cipher_methods()),
                    true
                )
            ) {
                return false;
            }
            if (strlen($bin) < 28) {
                return false; // too short for IV+TAG+CT
            }
            $iv  = substr($bin, 0, 12);
            $tag = substr($bin, 12, 16);
            $ct  = substr($bin, 28);
            return openssl_decrypt($ct, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);

        default:
            return false;
    }
}
