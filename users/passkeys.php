<?php
$noMaintenanceRedirect = true; 
require_once '../users/init.php';

require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
if(isset($user) && $user->isLoggedIn() && Input::get('passkeySuccess') == 'true'){
    if(file_exists($abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php')){
        require_once $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';
    }
    //if you're still here, redirect somewhere
    $final_location = $settings->redirect_uri_after_login;
    if($final_location == ""){
        $final_location = $us_url_root . 'users/account.php';
    }
     Redirect::to($final_location);
}
require_once $abs_us_root.$us_url_root.'users/auth/PasskeyHandler.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['deletePasskey']) && isset($_POST['passkey_id'])) {
        if (!Token::check($_POST['csrf'])) {
            usError(lang("CSRF_ERROR"));
            Redirect::to('passkeys.php');
        }
        
        $passkey_id = Input::get('passkey_id');
        $pkCheck = $db->query("SELECT id FROM us_passkeys WHERE id = ? AND user_id = ?", [$passkey_id, $userId])->count();
        
        if($pkCheck > 0){
            if ($db->query("DELETE FROM us_passkeys WHERE id = ? AND user_id = ?", [$passkey_id, $userId])) {
                logger($userId, 'Passkey Deleted', 'Deleted passkey id: ' . $passkey_id);
                usSuccess(lang("PASSKEY_DELETE_SUCCESS"));

                $remainingPasskeys = $db->query("SELECT COUNT(*) as count FROM us_passkeys WHERE user_id = ?", [$userId])->first()->count;
                if ($remainingPasskeys == 0) {
                    $db->update('users', $userId, ['passkey_enabled' => 0]);
                    logger($userId, 'Passkey', 'Last passkey deleted, passkey_enabled set to 0.');
                }
            } else {
                usError(lang("PASSKEY_DELETE_FAIL_DB"));
                logger($userId, 'Passkey Error', 'Failed to delete passkey id: ' . $passkey_id . ' DB Error: ' . $db->errorString());
            }
        } else {
            usError(lang("PASSKEY_DELETE_NOT_FOUND"));
            logger($userId, 'Passkey Error', 'Attempt to delete non-existent or unauthorized passkey id: ' . $passkey_id);
        }
        Redirect::to('passkeys.php');
    }
    
    if (isset($_POST['editPasskeyNote']) && isset($_POST['passkey_id'])) {
        if (!Token::check($_POST['csrf'])) {
            usError(lang("CSRF_ERROR"));
            Redirect::to('passkeys.php');
        }
        
        $passkey_id = Input::get('passkey_id');
        $passkey_note = Input::get('passkey_note');
        
        if ($db->query("UPDATE us_passkeys SET passkey_note = ? WHERE id = ? AND user_id = ?", 
            [$passkey_note, $passkey_id, $userId])) {
            logger($userId, 'Passkey Updated', 'Updated passkey note for id: ' . $passkey_id);
            usSuccess(lang("PASSKEY_NOTE_UPDATE_SUCCESS"));
        } else {
            usError(lang("PASSKEY_NOTE_UPDATE_FAIL"));
        }
        Redirect::to('passkeys.php');
    }
}
?>

<div class="row">
    <div id="status-note" class="col-12 w-100 alert alert-info" style="display: none;"></div>
    
    <div class="col-sm-12 pt-3 mb-2">
        <!-- Informational Box about Passkeys -->
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="mb-0"><i class="fa fa-info-circle"></i> <?php echo lang("PASSKEY_INFO_TITLE"); ?></h4>
            </div>
            <div class="card-body">
                <p class="mb-0"><?php echo lang("PASSKEY_INFO_DESC"); ?></p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3><?php echo isset($user) && $user->isLoggedIn() ? lang("PASSKEYS_MANAGE_TITLE") : lang("PASSKEYS_LOGIN_TITLE"); ?></h3>
            </div>
            <div class="card-body">
                <?php if(isset($user) && $user->isLoggedIn()): ?>
                    <?php 
                        $passkeys = $db->query("SELECT * FROM us_passkeys WHERE user_id = ? ORDER BY created DESC", [$userId])->results(); 
                    ?>
                    <?php if(count($passkeys) < 10): ?>
                        <button class="btn btn-primary mb-3" onclick="registerPasskey()"><?=lang("PASSKEY_REGISTER_NEW")?></button>
                    <?php else: ?>
                        <div class="alert alert-info"><?=lang("PASSKEY_ERR_LIMIT_REACHED")?></div>
                    <?php endif; ?>
                   
                    <?php if(count($passkeys) > 0): ?>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><?=lang("PASSKEY_NOTE_TH")?></th>
                                    <th><?=lang("PASSKEY_TIMES_USED_TH")?></th>
                                    <th><?=lang("PASSKEY_LAST_USED_TH")?></th>
                                    <th><?=lang("PASSKEY_LAST_IP_TH")?></th>
                                    <th><?=lang("GEN_ACTIONS")?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($passkeys as $pk): ?>
                                <tr>
                                    <td class="text-truncate" style="max-width: 150px;"><?= hed($pk->passkey_note) ?></td>
                                    <td><?= $pk->times_used ?></td>
                                    <td><?= $pk->last_used ?></td>
                                    <td><?= $pk->last_ip ?></td>
                                    <td>
                                        <form method="post" onsubmit="return confirm('<?=lang('PASSKEY_CONFIRM_DELETE_JS')?>');" class="d-inline">
                                            <?=tokenHere();?>
                                            <input type="hidden" name="passkey_id" value="<?= $pk->id ?>">
                                            <button type="submit" name="deletePasskey" class="btn btn-danger btn-sm"><?=lang("GEN_DEL")?></button>
                                        </form>
                                        <button type="button" class="btn btn-info btn-sm" onclick="showEditForm(<?= $pk->id ?>, '<?= hed($pk->passkey_note, ENT_QUOTES) ?>')"><?=lang("PASSKEY_EDIT_NOTE_BTN")?></button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                        <div class="modal fade" id="editPasskeyNoteModal" tabindex="-1" aria-labelledby="editPasskeyNoteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editPasskeyNoteModalLabel"><?=lang("PASSKEY_EDIT_MODAL_TITLE")?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?=lang("GEN_CLOSE")?>"></button>
                                    </div>
                                    <form method="post">
                                        <div class="modal-body">
                                            <?=tokenHere();?>
                                            <input type="hidden" name="passkey_id" id="edit_passkey_id">
                                            <div class="mb-3">
                                                <label for="passkey_note" class="form-label"><?=lang("PASSKEY_EDIT_MODAL_LABEL")?></label>
                                                <input type="text" class="form-control" id="passkey_note" name="passkey_note" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=lang("GEN_CANCEL")?></button>
                                            <button type="submit" name="editPasskeyNote" class="btn btn-primary"><?=lang("PASSKEY_SAVE_CHANGES_BTN")?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info"><?=lang("PASSKEY_NONE_REGISTERED")?></div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center">
                        <button class="btn btn-lg btn-primary mb-3" onclick="authenticatePasskey()"><?=lang("PASSKEYS_LOGIN_TITLE")?></button>
                        <hr>
                        <p><?=lang("PASSKEY_MUST_REGISTER_FIRST")?></p>
                        <a href="<?=$us_url_root?>users/login.php" class="btn btn-secondary"><?=lang("PASSKEY_BACK_TO_LOGIN"); ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
</div>

<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">

var us_url_root = '<?php echo $us_url_root; ?>';
var passkeyCSRF = '<?= Token::generate(); ?>'; 

// Detect device capabilities more accurately
function getDeviceCapabilities() {
    const isMobile = /Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    const hasTouch = 'ontouchstart' in window;
    const isDesktopWithTouch = !isMobile && hasTouch;
    const supportsConditionalUI = 'PublicKeyCredential' in window && 
        'isConditionalMediationAvailable' in PublicKeyCredential;
    
    return {
        isMobile,
        hasTouch,
        isDesktopWithTouch,
        supportsConditionalUI,
        isLikelyNeedsCrossDevice: !isMobile && !hasTouch
    };
}

function showStatus(message, type = 'info') {
    const status = document.getElementById('status-note');
    if (!status) return;
    
    status.textContent = message;
    status.style.display = 'block';
    
    status.classList.remove('alert-info', 'alert-success', 'alert-danger', 'alert-warning');
    
    switch(type) {
        case 'success':
            status.classList.add('alert-success');
            break;
        case 'error':
            status.classList.add('alert-danger');
            break;
        case 'warning':
            status.classList.add('alert-warning');
            break;
        default:
            status.classList.add('alert-info');
    }
    
    // Clear any existing timeout to prevent multiple timers
    if (window.statusTimeout) {
        clearTimeout(window.statusTimeout);
    }
    
    // Auto-hide success messages after 3 seconds, error messages after 10 seconds
    if (type === 'success') {
        window.statusTimeout = setTimeout(() => {
            status.style.display = 'none';
        }, 3000);
    } else if (type === 'error') {
        window.statusTimeout = setTimeout(() => {
            status.style.display = 'none';
        }, 10000);
    }
}

// Base64 URL-safe encoding/decoding functions
function base64UrlEncode(arrayBuffer) {
    const bytes = new Uint8Array(arrayBuffer);
    let binary = '';
    for (let i = 0; i < bytes.byteLength; i++) {
        binary += String.fromCharCode(bytes[i]);
    }
    return btoa(binary).replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '');
}

function base64UrlDecode(base64url) {
    try {
        // Convert base64url to base64
        let base64 = base64url.replace(/-/g, '+').replace(/_/g, '/');
        
        // Add padding if needed
        const padLength = 4 - (base64.length % 4);
        if (padLength !== 4) {
            base64 += '='.repeat(padLength);
        }
        
        const binary = atob(base64);
        const bytes = new Uint8Array(binary.length);
        for (let i = 0; i < binary.length; i++) {
            bytes[i] = binary.charCodeAt(i);
        }
        return bytes.buffer;
    } catch (e) {
        console.error('Base64 decode error:', e);
        throw new Error('<?=lang("PASSKEY_BASE64_ERROR")?>' + e.message);
    }
}

// Enhanced authentication options request with device hints
async function getAuthenticationOptions() {
    const capabilities = getDeviceCapabilities();
    
    const authData = {
        action: 'auth',
        device_type: JSON.stringify(capabilities),
        csrf: passkeyCSRF
    };
    
    const response = await fetch(us_url_root + 'users/auth/parsers/passkey_parser.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(authData)
    });
    
    if (!response.ok) {
        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    }
    
    return await response.json();
}
// Enhanced registration function with better cross-device handling and Bitwarden compatibility
async function registerPasskey() {
    const capabilities = getDeviceCapabilities();
    
    // Show device-specific guidance
    if (capabilities.isLikelyNeedsCrossDevice) {
        showStatus('<?=lang("PASSKEY_CROSS_DEVICE_PREP")?>', 'info');
    } else if (capabilities.isMobile) {
        showStatus('<?=lang("PASSKEY_DEVICE_REGISTRATION")?>', 'info');
    } else {
        showStatus('<?=lang("PASSKEY_STARTING_REGISTRATION")?>', 'info');
    }
    
    try {
        showStatus('<?=lang("PASSKEY_REQUEST_OPTIONS")?>', 'info');
        
        // Fetch registration options from server using POST
        const registrationData = {
            action: 'register',
            csrf: passkeyCSRF
        };
        
        const response = await fetch(us_url_root + 'users/auth/parsers/passkey_parser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(registrationData)
        });
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        const options = await response.json();
        console.log('Registration options received:', options);
        
        if (options.error) {
            throw new Error(options.error);
        }

        // Convert base64url strings back to ArrayBuffers for WebAuthn API
        const publicKeyCredentialCreationOptions = {
            rp: options.rp,
            user: {
                ...options.user,
                id: base64UrlDecode(options.user.id)
            },
            challenge: base64UrlDecode(options.challenge),
            pubKeyCredParams: options.pubKeyCredParams,
            timeout: options.timeout,
            attestation: options.attestation,
            // FIX FOR BITWARDEN: Ensure proper authenticatorSelection
            authenticatorSelection: {
                // Don't specify authenticatorAttachment - let browser/password manager decide
                requireResidentKey: true,  // Critical for Bitwarden
                residentKey: "required",   // Critical for Bitwarden  
                userVerification: options.authenticatorSelection?.userVerification || "preferred"
            },
            excludeCredentials: options.excludeCredentials?.map(cred => ({
                ...cred,
                id: base64UrlDecode(cred.id)
            })) || []
        };

        console.log('Processed options for WebAuthn (Bitwarden-compatible):', publicKeyCredentialCreationOptions);

        // Show appropriate waiting message
        if (capabilities.isLikelyNeedsCrossDevice) {
            showStatus('<?=lang("PASSKEY_FOLLOW_PROMPTS")?>', 'info');
        } else {
            showStatus('<?=lang("PASSKEY_FOLLOW_PROMPTS_SIMPLE")?>', 'info');
        }

        // Create the credential with enhanced timeout handling
        const timeoutMs = options.timeout || (capabilities.isLikelyNeedsCrossDevice ? 120000 : 60000);
        
        const credentialPromise = navigator.credentials.create({ 
            publicKey: publicKeyCredentialCreationOptions 
        });
        
        const timeoutPromise = new Promise((_, reject) => {
            setTimeout(() => {
                const timeoutMsg = capabilities.isLikelyNeedsCrossDevice ?
                    '<?=lang("PASSKEY_TIMEOUT_CROSS_DEVICE")?>' :
                    '<?=lang("PASSKEY_TIMEOUT_SIMPLE")?>';
                reject(new Error(timeoutMsg));
            }, timeoutMs + 10000); // Add 10s buffer
        });
        
        const credential = await Promise.race([credentialPromise, timeoutPromise]);
        
        if (!credential) {
            throw new Error('<?=lang("PASSKEY_CREATION_FAILED")?>');
        }

        // Send credential to server for storage
        const credentialData = {
            action: 'store',
            csrf: passkeyCSRF, 
            credentialId: base64UrlEncode(credential.rawId),
            clientDataJSON: base64UrlEncode(credential.response.clientDataJSON),
            attestationObject: base64UrlEncode(credential.response.attestationObject)
        };

        showStatus('<?=lang("PASSKEY_STORING_SERVER")?>', 'info');
        const storeResponse = await fetch(us_url_root + 'users/auth/parsers/passkey_parser.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(credentialData)
        });
        
        if (!storeResponse.ok) {
            throw new Error(`HTTP ${storeResponse.status}: ${storeResponse.statusText}`);
        }
        
        const storeResult = await storeResponse.json();
        
        if (storeResult.error) {
            throw new Error(storeResult.error);
        }

        showStatus('<?=lang("PASSKEY_CREATED_SUCCESS")?>', 'success');
        
        // Auto-prompt for passkey note after successful registration
        setTimeout(() => {
            promptForPasskeyNote();
        }, 1000);
        
    } catch (error) {
        console.error('Registration error:', error);
        handleRegistrationError(error, capabilities);
    }
}

// Function to prompt for passkey note after registration
async function promptForPasskeyNote() {
    try {
        // Get the most recently created passkey for this user using POST
        const pageData = {
            action: 'get_page_data',
            csrf: passkeyCSRF
        };
        
        const response = await fetch(window.location.href, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(pageData)
        });
        
        const parser = new DOMParser();
        const doc = parser.parseFromString(await response.text(), 'text/html');
        
        // Find the first (most recent) passkey row
        const firstRow = doc.querySelector('tbody tr');
        if (firstRow) {
            const passkeyId = firstRow.querySelector('input[name="passkey_id"]')?.value;
            if (passkeyId) {
                showEditForm(passkeyId, '', true); // true flag for new passkey
            }
        }
        
        // Only reload if no modals are open
        setTimeout(() => {
            if (!isAnyModalOpen()) {
                location.reload();
            }
        }, 2000);
        
    } catch (error) {
        console.error('Error prompting for passkey note:', error);
        // Just reload the page if we can't prompt for note (and no modals open)
        setTimeout(() => {
            if (!isAnyModalOpen()) {
                location.reload();
            }
        }, 1500);
    }
}


// Helper function to check if any Bootstrap modals are open
function isAnyModalOpen() {
    // Check for Bootstrap 5 modals
    const openModals = document.querySelectorAll('.modal.show');
    return openModals.length > 0;
}

// Enhanced authentication function with better cross-device handling
async function authenticatePasskey() {
    const capabilities = getDeviceCapabilities();
    
    // Show device-specific guidance
    if (capabilities.isLikelyNeedsCrossDevice) {
        showStatus('<?=lang("PASSKEY_CROSS_DEVICE_AUTH_PREP")?>', 'info');
    } else if (capabilities.isMobile) {
        showStatus('<?=lang("PASSKEY_DEVICE_AUTH")?>', 'info');
    } else {
        showStatus('<?=lang("PASSKEY_STARTING_AUTH")?>', 'info');
    }
    
    try {
        // Get options with device capabilities using POST
        const options = await getAuthenticationOptions();
        
        if (options.error) {
            throw new Error(options.error);
        }
        
        // Enhanced timeout based on device type and cross-device needs
        let timeoutMs = options.timeout || 60000;
        if (capabilities.isLikelyNeedsCrossDevice) {
            timeoutMs = Math.max(timeoutMs, 120000); // At least 2 minutes for cross-device
        }
        
        // Convert options for WebAuthn
        const publicKeyCredentialRequestOptions = {
            challenge: base64UrlDecode(options.challenge),
            rpId: options.rpId,
            userVerification: options.userVerification,
            timeout: timeoutMs,
            allowCredentials: options.allowCredentials?.map(cred => ({
                ...cred,
                id: base64UrlDecode(cred.id),
                // Enhanced transport hints for cross-device
                transports: capabilities.isLikelyNeedsCrossDevice ? 
                    ['hybrid', 'internal', 'usb', 'nfc', 'ble'] : 
                    cred.transports
            })) || []
        };
        
        // Show appropriate waiting message
        if (capabilities.isLikelyNeedsCrossDevice && publicKeyCredentialRequestOptions.allowCredentials.length === 0) {
            showStatus('<?=lang("PASSKEY_QR_CODE_INSTRUCTION")?>', 'info');
        } else if (capabilities.isLikelyNeedsCrossDevice) {
            showStatus('<?=lang("PASSKEY_PHONE_TABLET_INSTRUCTION")?>', 'info');
        } else {
            showStatus('<?=lang("PASSKEY_AUTHENTICATING")?>', 'info');
        }
        
        // Add retry mechanism for cross-device
        let attempts = 0;
        const maxAttempts = capabilities.isLikelyNeedsCrossDevice ? 2 : 1;
        
        while (attempts < maxAttempts) {
            try {
                attempts++;
                
                // Create authentication promise with timeout
                const authPromise = navigator.credentials.get({ 
                    publicKey: publicKeyCredentialRequestOptions 
                });
                
                const timeoutPromise = new Promise((_, reject) => {
                    setTimeout(() => {
                        const timeoutMsg = capabilities.isLikelyNeedsCrossDevice ?
                            '<?=lang("PASSKEY_AUTH_TIMEOUT_CROSS_DEVICE")?>' :
                            '<?=lang("PASSKEY_AUTH_TIMEOUT_SIMPLE")?>';
                        reject(new Error(timeoutMsg));
                    }, timeoutMs + 5000);
                });
                
                const credential = await Promise.race([authPromise, timeoutPromise]);
                
                if (!credential) {
                    if (attempts < maxAttempts) {
                        showStatus('<?=lang("PASSKEY_NO_CREDENTIAL")?>', 'warning');
                        await new Promise(resolve => setTimeout(resolve, 2000));
                        continue;
                    }
                    throw new Error('<?=lang("PASSKEY_AUTH_FAILED_NO_CREDENTIAL")?>');
                }
                
                // Success - proceed with verification
                return await verifyCredential(credential);
                
            } catch (error) {
                if (attempts < maxAttempts && error.name === 'NotAllowedError') {
                    showStatus('<?=lang("PASSKEY_ATTEMPT_RETRY")?>'.replace('%d', maxAttempts - attempts), 'warning');
                    await new Promise(resolve => setTimeout(resolve, 3000));
                    continue;
                }
                throw error;
            }
        }
        
    } catch (error) {
        console.error('Enhanced authentication error:', error);
        handleAuthenticationError(error, capabilities);
    }
}

// Helper function to verify credential
async function verifyCredential(credential) {
    const authData = {
        action: 'verify',
        csrf: passkeyCSRF, 
        credentialId: base64UrlEncode(credential.rawId),
        clientDataJSON: base64UrlEncode(credential.response.clientDataJSON),
        authenticatorData: base64UrlEncode(credential.response.authenticatorData),
        signature: base64UrlEncode(credential.response.signature),
        userHandle: credential.response.userHandle ? base64UrlEncode(credential.response.userHandle) : null
    };

    const verifyResponse = await fetch(us_url_root + 'users/auth/parsers/passkey_parser.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(authData)
    });
    
    if (!verifyResponse.ok) {
        throw new Error(`HTTP ${verifyResponse.status}: ${verifyResponse.statusText}`);
    }
    
    const result = await verifyResponse.json();
    
    if (result.success) {
        showStatus('<?=lang("PASSKEY_SUCCESS_REDIRECTING")?>', 'success');
       const url = new URL(window.location.href);
        url.searchParams.set('passkeySuccess', 'true');
        window.location.href = url.toString();
    } else {
        throw new Error(result.error || '<?=lang("PASSKEY_CREDENTIAL_NOT_FOUND")?>');
    }
}

// showEditForm function
function showEditForm(passkeyId, currentNote, isNewPasskey = false) {
    // Set the values in the modal
    document.getElementById('edit_passkey_id').value = passkeyId;
    document.getElementById('passkey_note').value = currentNote;
    
    // Update modal title if it's a new passkey
    const modalTitle = document.getElementById('editPasskeyNoteModalLabel');
    if (isNewPasskey && modalTitle) {
        modalTitle.textContent = '<?=lang("PASSKEY_ADD_NOTE_NEW")?>';
    } else if (modalTitle) {
        modalTitle.textContent = '<?=lang("PASSKEY_EDIT_MODAL_TITLE")?>';
    }
    
    // Show the modal - Bootstrap 5 syntax
    const modal = new bootstrap.Modal(document.getElementById('editPasskeyNoteModal'));
    modal.show();
    
    // Focus on the input field
    setTimeout(() => {
        document.getElementById('passkey_note').focus();
        document.getElementById('passkey_note').select();
    }, 500);
    
    // Add event listener to reload page when modal is closed (for new passkeys)
    if (isNewPasskey) {
        const modalElement = document.getElementById('editPasskeyNoteModal');
        modalElement.addEventListener('hidden.bs.modal', function reloadAfterNewPasskey() {
            // Remove this listener so it doesn't fire for regular edits
            modalElement.removeEventListener('hidden.bs.modal', reloadAfterNewPasskey);
            // Reload to show updated passkey list
            location.reload();
        });
    }
}

// Enhanced error handling with device-specific messages
function handleAuthenticationError(error, capabilities) {
    let errorMessage = '<?=lang("SIGNIN_FAIL")?>'.replace('** ', '').replace(' **', '');
    
    if (error.name === 'NotAllowedError') {
        if (capabilities.isLikelyNeedsCrossDevice) {
            errorMessage = '<?=lang("PASSKEY_CROSS_DEVICE_AUTH_FAILED")?>';
        } else {
            errorMessage = '<?=lang("PASSKEY_AUTH_CANCELLED")?>';
        }
    } else if (error.name === 'NotSupportedError') {
        errorMessage = '<?=lang("PASSKEY_NOT_SUPPORTED")?>';
    } else if (error.name === 'SecurityError') {
        errorMessage = '<?=lang("PASSKEY_SECURITY_ERROR")?>';
    } else if (error.name === 'NetworkError' || error.message.includes('network')) {
        errorMessage = '<?=lang("PASSKEY_NETWORK_ERROR")?>';
    } else if (error.message.includes('timed out')) {
        errorMessage = error.message; // Use our enhanced timeout message
    } else if (error.message) {
        errorMessage += ' ' + error.message;
    }
    
    showStatus(errorMessage, 'error');
    showTroubleshootingAfterFailure();
}

// Enhanced registration error handling
function handleRegistrationError(error, capabilities) {
    let errorMessage = '<?=lang("SIGNUP_TEXT")?> <?=lang("SIGNIN_FAIL")?>'.replace('** ', '').replace(' **', '');
    
    if (error.name === 'NotAllowedError') {
        if (capabilities.isLikelyNeedsCrossDevice) {
            errorMessage = '<?=lang("PASSKEY_CROSS_DEVICE_FAILED")?>';
        } else {
            errorMessage = '<?=lang("PASSKEY_REGISTRATION_CANCELLED")?>';
        }
    } else if (error.name === 'NotSupportedError') {
        errorMessage = '<?=lang("PASSKEY_NOT_SUPPORTED")?>';
    } else if (error.name === 'SecurityError') {
        errorMessage = '<?=lang("PASSKEY_SECURITY_ERROR")?>';
    } else if (error.name === 'InvalidStateError') {
        errorMessage = '<?=lang("PASSKEY_ALREADY_EXISTS")?>';
    } else if (error.message.includes('timed out')) {
        errorMessage = error.message; // Use our enhanced timeout message
    } else if (error.message) {
        errorMessage += ' ' + error.message;
    }
    
    showStatus(errorMessage, 'error');
    showTroubleshootingAfterFailure();
}

// Show troubleshooting section after failures
let authFailureCount = 0;
function showTroubleshootingAfterFailure() {
    authFailureCount++;
    if (authFailureCount >= 2) {
        const section = document.getElementById('troubleshooting-section');
        if (section) {
            section.style.display = 'block';
        }
        
        // Add a button to the main UI if it doesn't exist
        const mainCard = document.querySelector('.card-body');
        if (mainCard && !document.getElementById('show-troubleshooting-btn')) {
            const troubleshootingBtn = document.createElement('button');
            troubleshootingBtn.id = 'show-troubleshooting-btn';
            troubleshootingBtn.className = 'btn btn-outline-info btn-sm mt-2';
            troubleshootingBtn.textContent = '<?=lang("PASSKEY_HIDE_TROUBLESHOOTING")?>';
            troubleshootingBtn.onclick = toggleTroubleshooting;
            mainCard.appendChild(troubleshootingBtn);
        }
    }
}

// Troubleshooting toggle function
function toggleTroubleshooting() {
    const section = document.getElementById('troubleshooting-section');
    if (!section) return;
    
    const isVisible = section.style.display !== 'none';
    section.style.display = isVisible ? 'none' : 'block';
    
    // Update button text
    const toggleBtn = document.getElementById('show-troubleshooting-btn');
    if (toggleBtn) {
        toggleBtn.textContent = isVisible ? '<?=lang("PASSKEY_SHOW_TROUBLESHOOTING")?>' : '<?=lang("PASSKEY_HIDE_TROUBLESHOOTING")?>';
    }
}

// Show cross-device guidance on page load
function showCrossDeviceGuidance() {
    const capabilities = getDeviceCapabilities();
    
    if (capabilities.isLikelyNeedsCrossDevice) {
        const guidanceHtml = `
            <div class="alert alert-info mt-2" id="cross-device-guidance">
                <h6><?=lang("PASSKEY_CROSS_DEVICE_GUIDANCE_TITLE")?></h6>
                <ul class="mb-0">
                    <li><?=lang("PASSKEY_GUIDANCE_INTERNET")?></li>
                    <li><?=lang("PASSKEY_GUIDANCE_WIFI")?></li>
                    <li><?=lang("PASSKEY_GUIDANCE_SELECT_DEVICE")?></li>
                    <li><?=lang("PASSKEY_GUIDANCE_SCAN_QUICKLY")?></li>
                    <li><?=lang("PASSKEY_GUIDANCE_TRY_DIRECT")?></li>
                </ul>
            </div>
        `;
        
        const existingGuidance = document.getElementById('cross-device-guidance');
        if (!existingGuidance) {
            // Find the last element in the main row container and append after it
            const mainRow = document.querySelector('.row');
            if (mainRow) {
                mainRow.insertAdjacentHTML('afterend', guidanceHtml);
            } else {
                // Fallback: append to the body if row not found
                document.body.insertAdjacentHTML('beforeend', guidanceHtml);
            }
        }
    }
}

// Diagnostic function for troubleshooting
async function runDiagnostics() {
    try {
        showStatus('<?=lang("PASSKEY_DIAGNOSTICS_RUNNING")?>', 'info');
        
        const diagnosticsData = {
            action: 'diagnostics',
            csrf: passkeyCSRF
        };
        
        const response = await fetch(us_url_root + 'users/auth/parsers/passkey_parser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(diagnosticsData)
        });
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        const diagnostics = await response.json();
        console.log('Diagnostics:', diagnostics);
        
        // Display key diagnostic information
        let message = '<?=lang("PASSKEY_DIAGNOSTICS_COMPLETE")?> ';
        if (diagnostics.validation && !diagnostics.validation.is_suitable) {
            message += '<?=lang("PASSKEY_ISSUES_DETECTED")?> ' + diagnostics.validation.errors.join(', ');
        } else {
            message += '<?=lang("PASSKEY_ENVIRONMENT_SUITABLE")?>';
        }
        
        showStatus(message, diagnostics.validation?.is_suitable ? 'success' : 'warning');
        
    } catch (error) {
        console.error('Diagnostics error:', error);
        showStatus('<?=lang("PASSKEY_DIAGNOSTICS_FAILED")?> ' + error.message, 'error');
    }
}
// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    showCrossDeviceGuidance();
    
    // Auto-login on page load if URL parameter is set
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('login') && urlParams.get('login') === '1') {
        // Only auto-login if not already logged in (check for register button)
        if (!document.querySelector('button[onclick="registerPasskey()"]')) {
            authenticatePasskey();
        }
    }
});

// Expose functions globally for onclick handlers
window.registerPasskey = registerPasskey;
window.authenticatePasskey = authenticatePasskey;
window.runDiagnostics = runDiagnostics;
window.toggleTroubleshooting = toggleTroubleshooting;
window.showEditForm = showEditForm;
</script>

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>