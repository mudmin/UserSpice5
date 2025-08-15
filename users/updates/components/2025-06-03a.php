<?php
//This is the upgrade file for version 2025-06-03a
//Passkeys schema update

$db = DB::getInstance();
$countE = $count = 0;
try {
    $query = $db->query("SHOW TABLES LIKE 'us_passkeys'");
    $count = $query->count();
} catch (Exception $e) {
    // Table does not exist or other error
    logger(1, "System Updates", "Error checking for us_passkeys table: " . $e->getMessage());
}

if ($count == 0) {
    logger(1, "System Updates", "us_passkeys table not found, creating it.");
    try {
        $db->query("CREATE TABLE `us_passkeys` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` INT(11) DEFAULT 0,
            `credential_id` VARBINARY(255) DEFAULT NULL,
            `credential_public_key` BLOB DEFAULT NULL,
            `passkey_note` VARCHAR(255) DEFAULT NULL,
            `created` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
            `last_used` TIMESTAMP NULL DEFAULT NULL,
            `times_used` INT(11) DEFAULT 0,
            `last_ip` VARCHAR(255) DEFAULT NULL,
            `user_handle` VARBINARY(64) DEFAULT NULL,
            `transports` TEXT DEFAULT NULL,
            `attestation_type` VARCHAR(32) DEFAULT NULL,
            `trust_path` TEXT DEFAULT NULL,
            `aaguid` VARCHAR(36) DEFAULT NULL,
            `signature_counter` BIGINT UNSIGNED DEFAULT 0,
            `other_ui_data` TEXT DEFAULT NULL,
            INDEX `idx_user_id` (`user_id`),
            UNIQUE INDEX `uidx_credential_id` (`credential_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        if (!$db->error()) {
            logger(1, "System Updates", "Successfully created us_passkeys table.");
        } else {
            $errorMsg = $db->errorString() ?: "Unknown error creating us_passkeys table.";
            logger(1, "System Updates", "Failed to create us_passkeys table: " . $errorMsg);
            usError("Failed to create us_passkeys table: " . $errorMsg);
        }
    } catch (Exception $e) {
        logger(1, "System Updates", "Exception creating us_passkeys table: " . $e->getMessage());
        usError("Exception creating us_passkeys table: " . $e->getMessage());
    }
} else {
    logger(1, "System Updates", "us_passkeys table found, attempting to alter it.");
    // Alter existing table
    // Drop existing primary key if it's not on auto_increment id (older versions might have it on credentialId)
    // This is risky if structure is unknown; for now, assume `id` is PK or will be made so.
    // Best practice would be to check each column/index before adding/modifying.
    
    // Modify credentialId and publicKey first
    if ($db->columnExists('us_passkeys', 'credentialId')) {
        try {
            $db->query("ALTER TABLE `us_passkeys` CHANGE `credentialId` `credential_id` VARBINARY(255) DEFAULT NULL");
            logger(1, "System Updates", "Changed credentialId to credential_id VARBINARY(255).");
        } catch (Exception $e) {
            logger(1, "System Updates", "Failed to change credentialId: " . $e->getMessage());
        }
    } elseif (!$db->columnExists('us_passkeys', 'credential_id')) {
         try {
            $db->query("ALTER TABLE `us_passkeys` ADD COLUMN `credential_id` VARBINARY(255) DEFAULT NULL");
            logger(1, "System Updates", "Added column credential_id.");
        } catch (Exception $e) {
            logger(1, "System Updates", "Failed to add credential_id: " . $e->getMessage());
        }
    }

    if ($db->columnExists('us_passkeys', 'publicKey')) {
        try {
            $db->query("ALTER TABLE `us_passkeys` CHANGE `publicKey` `credential_public_key` BLOB DEFAULT NULL");
            logger(1, "System Updates", "Changed publicKey to credential_public_key BLOB.");
        } catch (Exception $e) {
            logger(1, "System Updates", "Failed to change publicKey: " . $e->getMessage());
        }
    } elseif (!$db->columnExists('us_passkeys', 'credential_public_key')) {
        try {
            $db->query("ALTER TABLE `us_passkeys` ADD COLUMN `credential_public_key` BLOB DEFAULT NULL");
            logger(1, "System Updates", "Added column credential_public_key.");
        } catch (Exception $e) {
            logger(1, "System Updates", "Failed to add credential_public_key: " . $e->getMessage());
        }
    }

    // Add new columns if they don't exist
    $columns_to_add = [
        'user_handle' => 'VARBINARY(64) DEFAULT NULL',
        'transports' => 'TEXT DEFAULT NULL',
        'attestation_type' => "VARCHAR(32) DEFAULT NULL",
        'trust_path' => 'TEXT DEFAULT NULL',
        'aaguid' => "VARCHAR(36) DEFAULT NULL",
        'signature_counter' => 'BIGINT UNSIGNED DEFAULT 0',
        'other_ui_data' => 'TEXT DEFAULT NULL'
    ];

    foreach ($columns_to_add as $column => $definition) {
        if (!$db->columnExists('us_passkeys', $column)) {
            try {
                $db->query("ALTER TABLE `us_passkeys` ADD COLUMN `{$column}` {$definition}");
                logger(1, "System Updates", "Added column {$column} to us_passkeys.");
            } catch (Exception $e) {
                logger(1, "System Updates", "Failed to add column {$column}: " . $e->getMessage());
            }
        } else {
            // Optionally, modify if definition changed, but for now, just ensure it exists.
            logger(1, "System Updates", "Column {$column} already exists in us_passkeys.");
        }
    }

    // Ensure indexes
    if (!$db->indexExists("us_passkeys", "idx_user_id")) {
        try {
            $db->query("ALTER TABLE `us_passkeys` ADD INDEX `idx_user_id` (`user_id`)");
            logger(1, "System Updates", "Added index idx_user_id to us_passkeys.");
        } catch (Exception $e) {
            logger(1, "System Updates", "Failed to add index idx_user_id: " . $e->getMessage());
        }
    }
    if (!$db->indexExists("us_passkeys", "uidx_credential_id")) {
         // Need to drop old index if it was not varbinary
        if ($db->indexExists("us_passkeys", "credentialId")) { // Assuming old index name was credentialId
            try {
                $db->query("ALTER TABLE `us_passkeys` DROP INDEX `credentialId`");
                logger(1, "System Updates", "Dropped old index credentialId.");
            } catch (Exception $e) {
                 logger(1, "System Updates", "Failed to drop old index credentialId: " . $e->getMessage());
            }
        }
        try {
            $db->query("ALTER TABLE `us_passkeys` ADD UNIQUE INDEX `uidx_credential_id` (`credential_id`)");
            logger(1, "System Updates", "Added unique index uidx_credential_id to us_passkeys.");
        } catch (Exception $e) {
            logger(1, "System Updates", "Failed to add unique index uidx_credential_id: " . $e->getMessage());
        }
    }
    logger(1, "System Updates", "Finished attempting to alter us_passkeys table.");
}

// You can add additional queries here if needed.
// Example: $db->update('settings', 1, ['version' => '2025-06-03a']);
// if(!$db->error()) {
//   logger(1, "System Updates", "Applied version update for 2025-06-03a in settings table.");
// } else {
//   logger(1, "System Updates", "Failed to apply version update for 2025-06-03a in settings table.");
// }

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
