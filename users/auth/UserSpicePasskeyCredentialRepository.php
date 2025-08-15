<?php
declare(strict_types=1);
/**
 * @see UserSpicePasskeyCredentialRepository
 */
use Webauthn\PublicKeyCredentialSource;
use Webauthn\PublicKeyCredentialUserEntity;
use Webauthn\TrustPath\TrustPathLoader; 
use Webauthn\PublicKeyCredentialSourceRepository; // Correct interface for v5.x
use Webauthn\TrustPath\TrustPath; 
use Webauthn\TrustPath\EmptyTrustPath; 
use Symfony\Component\Uid\Uuid;


class UserSpicePasskeyCredentialRepository implements PublicKeyCredentialSourceRepository 
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function saveCredentialSource(PublicKeyCredentialSource $credentialSource): void
    {
        // Accessing public properties instead of getters
        $transportsJson = json_encode($credentialSource->transports);
        $trustPathData = $this->serializeTrustPath($credentialSource->trustPath);

        $fields = [
            'user_handle' => $credentialSource->userHandle,
            'credential_id' => $credentialSource->publicKeyCredentialId,
            'credential_public_key' => $credentialSource->credentialPublicKey,
            'attestation_type' => $credentialSource->attestationType,
            'aaguid' => $credentialSource->aaguid->toString(),
            'signature_counter' => $credentialSource->counter,
            'transports' => $transportsJson,
            'trust_path' => $trustPathData,
        ];

        $userId = $credentialSource->userHandle;

        $existing = $this->db->query(
            "SELECT id FROM us_passkeys WHERE credential_id = ?", 
            [$credentialSource->publicKeyCredentialId]
        )->first();

        if ($existing) {
            $this->db->update('us_passkeys', $existing->id, $fields);
            if ($this->db->error()) {
                 logger(0, "PasskeyRepo", "Error updating passkey: " . $this->db->errorString() . " for credential ID: " . bin2hex($credentialSource->publicKeyCredentialId));
            }
        } else {
            $fields['user_id'] = $userId; 
            $this->db->insert('us_passkeys', $fields);
             if ($this->db->error()) {
                 logger(0, "PasskeyRepo", "Error inserting passkey: " . $this->db->errorString() . " for credential ID: " . bin2hex($credentialSource->publicKeyCredentialId));
            }
        }
    }

    public function findOneByCredentialId(string $publicKeyCredentialId): ?PublicKeyCredentialSource
    {
        $row = $this->db->query(
            "SELECT * FROM us_passkeys WHERE credential_id = ?",
            [$publicKeyCredentialId]
        )->first();

        if (!$row) {
            return null;
        }
        return $this->rowToCredentialSource($row);
    }

    public function findAllForUserEntity(PublicKeyCredentialUserEntity $userEntity): array
    {
        // Access public property 'id' instead of getId()
        $userHandle = $userEntity->id;
        $rows = $this->db->query(
            "SELECT * FROM us_passkeys WHERE user_handle = ?",
            [$userHandle]
        )->results();

        $credentials = [];
        foreach ($rows as $row) {
            $credentials[] = $this->rowToCredentialSource($row);
        }
        return $credentials;
    }

    private function rowToCredentialSource(object $row): PublicKeyCredentialSource
    {
        $transports = json_decode($row->transports ?? '[]', true);
        $aaguidString = is_string($row->aaguid) ? $row->aaguid : '';
        
        // Fixed: Use Symfony\Component\Uid\Uuid instead of AAGUID
        $aaguid = Uuid::fromString($aaguidString); 
        $trustPath = $this->deserializeTrustPath($row->trust_path ?? '');

        return new PublicKeyCredentialSource(
            $row->credential_id,          // publicKeyCredentialId
            'public-key',                 // type
            $transports,                  // transports
            $row->attestation_type,       // attestationType
            $trustPath,                   // trustPath
            $aaguid,                      // aaguid object (now Uuid)
            $row->credential_public_key,  // credentialPublicKey
            $row->user_handle,            // userHandle
            (int)$row->signature_counter  // counter
        );
    }

    private function serializeTrustPath(TrustPath $trustPath): string
    {
        if (method_exists($trustPath, 'jsonSerialize')) {
            return json_encode($trustPath);
        }
        if ($trustPath instanceof EmptyTrustPath) { 
             return 'EmptyTrustPath'; 
        }
        return get_class($trustPath); 
    }

    private function deserializeTrustPath(string $data): TrustPath
    {
        $decoded = json_decode((string)$data, true);
        if (is_array($decoded) && isset($decoded['type']) && class_exists($decoded['type']) && is_subclass_of($decoded['type'], TrustPath::class)) {
            $type = $decoded['type'];
            if ($type === EmptyTrustPath::class) {
                return new EmptyTrustPath();
            }
            // Potentially add more specific deserialization for other trust path types if needed
        } elseif ($data === 'EmptyTrustPath' || (class_exists($data) && is_subclass_of($data, TrustPath::class))) {
             $type = ($data === 'EmptyTrustPath') ? EmptyTrustPath::class : $data;
             if ($type === EmptyTrustPath::class) {
                return new EmptyTrustPath();
            }
        }
        return new EmptyTrustPath();
    }
}