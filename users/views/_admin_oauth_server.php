<?php
require_once $abs_us_root . $us_url_root . 'users/auth/userspice_oauth_provider.php';

// client_ver, public_client and ip_restrict_on arrive with update 2026-11-10a
$hasClientVer = $db->query("SHOW COLUMNS FROM us_oauth_server_clients LIKE 'client_ver'")->count() > 0;
// cors_origins arrives with update 2026-11-10b
$hasCors = $db->query("SHOW COLUMNS FROM us_oauth_server_clients LIKE 'cors_origins'")->count() > 0;

$clientsQ = $db->query("SELECT * FROM us_oauth_server_clients");
$clientsC = $clientsQ->count();
$clients = $clientsQ->results();

$client = Input::get('client');
$e = false;
if (is_numeric($client)) {
  $q = $db->query("SELECT * FROM us_oauth_server_clients WHERE id = ?", [$client]);
  if ($q->count() > 0) {
    $client = $q->first();
    $e = true;
  } else {
    usError("Client not found");
    $client = "";
  }
}

$login_scripts = scandir($abs_us_root . $us_url_root . 'usersc/oauth_server/login_scripts');
$login_scripts = array_diff($login_scripts, array('.', '..'));

if ($settings->oauth_server == 1) {
  $statusBadge = '<span class="badge bg-success">Enabled</span>';
  $toggleServer = 0;
  $toggleServerText = 'Disable';
  $toggleServerClass = 'btn-danger';
  $toggleSubmitWarning = 'Are you sure? Disabling the OAuth server will prevent any clients from authenticating.';
} else {
  $statusBadge = '<span class="badge bg-danger">Disabled</span>';
  $toggleServer = 1;
  $toggleServerText = 'Enable';
  $toggleServerClass = 'btn-success';
  $toggleSubmitWarning = 'Are you sure? Enabling the OAuth server will allow clients to authenticate. Please make sure that your clients are properly configured.';
}



if (!empty($_POST)) {
  if (!Token::check(Input::get('csrf'))) {
    include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
  }

  if (isset($_POST['toggleServer'])) {

    $newVal = (int)Input::get('toggleServer');

    $db->update('settings', 1, ['oauth_server' => $newVal]);


    usSuccess("OAuth Server setting updated");
    Redirect::to($us_url_root . 'users/admin.php?view=oauth');
  }

  if (is_numeric(Input::get('delete_client'))) {
    $clientId = Input::get('delete_client');

    $db->delete('us_oauth_server_clients', ['id' => $clientId]);
    if (!$db->error()) {
      usSuccess("Client deleted successfully");
      logger($user->data()->id, "OAuth Server", "Client ID $clientId deleted");
    } else {
      usError("Error deleting client");
    }
    Redirect::to($us_url_root . 'users/admin.php?view=oauth');
  }

  // Regenerate client secret (for migrating plaintext to hashed)
  if (is_numeric(Input::get('regenerate_secret'))) {
    $clientDbId = (int)Input::get('regenerate_secret');
    $clientQ = $db->query("SELECT client_id, client_name FROM us_oauth_server_clients WHERE id = ?", [$clientDbId]);
    if ($clientQ->count() > 0) {
      $clientData = $clientQ->first();
      $newSecretPlain = bin2hex(random_bytes(32));
      $newSecretHashed = password_hash($newSecretPlain, PASSWORD_BCRYPT, ['cost' => 12]);

      $db->update('us_oauth_server_clients', $clientDbId, ['client_secret' => $newSecretHashed]);

      if (!$db->error()) {
        // Store in session to display once
        $_SESSION['oauth_new_client_secret'] = $newSecretPlain;
        $_SESSION['oauth_new_client_id'] = $clientData->client_id;

        usSuccess("Client secret regenerated. <strong>IMPORTANT: Copy the new Client Secret now - it will only be shown once!</strong>");
        logger($user->data()->id, "OAuth Server", "Client secret regenerated for: " . $clientData->client_name);
      } else {
        usError("Error regenerating client secret");
      }
    } else {
      usError("Client not found");
    }
    Redirect::to($us_url_root . 'users/admin.php?view=oauth&client=' . $clientDbId);
  }


  $fields = [
    'client_name' => Input::get('client_name'),
    'client_description' => Input::get('client_description'),
    // Stored as plain text: Input::get() escapes & to &amp;, and the URI is compared exactly.
    'redirect_uri' => hed(Input::get('redirect_uri')),
    'ip_restrict' => Input::get('ip_restrict'),
    'login_title' => Input::get('login_title'),
    'login_script' => Input::get('login_script'),
    'response_secret' => Input::get('response_secret'),
  ];

  if ($hasClientVer) {
    $fields['client_ver'] = Input::get('client_ver') === '1' ? 1 : 0;
    $fields['public_client'] = ($fields['client_ver'] === 1 && Input::get('public_client') === '1') ? 1 : 0;
    $fields['ip_restrict_on'] = (!$fields['public_client'] && Input::get('ip_restrict_on') === '1') ? 1 : 0;

    if ($fields['ip_restrict_on']) {
      $ipEntries = UserSpiceOAuthProvider::parseIpList($fields['ip_restrict']);
      $ipList = is_array($ipEntries) ? implode(', ', $ipEntries) : '';
      if ($ipList === '' || strlen($ipList) > 200) {
        usError("Client not saved. To enforce the IP restriction, enter one or more IP addresses or CIDR ranges (up to 200 characters), separated by commas, spaces or new lines.");
        Redirect::to($us_url_root . 'users/admin.php?view=oauth' . ($e ? '&client=' . (int)$client->id : ''));
      }
      $fields['ip_restrict'] = $ipList;
    }

    if ($hasCors) {
      $origins = UserSpiceOAuthProvider::parseOriginList(Input::get('cors_origins'));
      $originList = is_array($origins) ? implode(', ', $origins) : '';
      if ($origins === false || strlen($originList) > 1000) {
        usError("Client not saved. Allowed browser origins must look like https://app.example.com or http://localhost:3000 (no path), separated by commas, spaces or new lines.");
        Redirect::to($us_url_root . 'users/admin.php?view=oauth' . ($e ? '&client=' . (int)$client->id : ''));
      }
      $fields['cors_origins'] = $originList;
    }

    if ($e && (int)($client->client_ver ?? 0) !== $fields['client_ver']) {
      logger($user->data()->id, "OAuth Server", "Client {$client->client_id} switched to v{$fields['client_ver']}");
    }
  }

  if ($e) {
    usSuccess("Client updated");
    $db->update('us_oauth_server_clients', $client->id, $fields);
    $id = $client->id;
  } else {
    $clientId = bin2hex(random_bytes(16));  // 32 character string
    $clientSecretPlain = bin2hex(random_bytes(32));  // 64 character string - shown once to user
    $clientSecretHashed = password_hash($clientSecretPlain, PASSWORD_BCRYPT, ['cost' => 12]);
    $fields['client_id'] = $clientId;
    $fields['client_secret'] = $clientSecretHashed;

    // Store plaintext secret temporarily in session to display once
    $_SESSION['oauth_new_client_secret'] = $clientSecretPlain;
    $_SESSION['oauth_new_client_id'] = $clientId;

    usSuccess("Client created. <strong>IMPORTANT: Copy the Client Secret now - it will only be shown once!</strong>");
    $db->insert('us_oauth_server_clients', $fields);
    $id = $db->lastId();
  }

  if (!$db->error()) {
    logger($user->data()->id, "OAuth Server", $fields['client_name'] . " client updated/created");
    Redirect::to($us_url_root . 'users/admin.php?view=oauth&client=' . $id);
  } else {
    Redirect::to($us_url_root . 'users/admin.php?view=oauth');
  }
}
?>
<script nonce="<?=htmlspecialchars($userspice_nonce ?? '')?>">
  function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
      // alert('Copied to clipboard!');
    }, function(err) {
      console.error('Could not copy text: ', err);
    });
  }

  function generateSecret() {
    const array = new Uint8Array(32);
    crypto.getRandomValues(array);
    return Array.from(array, byte => byte.toString(16).padStart(2, '0')).join('');
  }

  // CSP-friendly bindings (replace inline on* attributes)
  document.addEventListener('click', function (e) {
    var el = e.target.closest && e.target.closest('[data-us-copy]');
    if (el) { copyToClipboard(el.getAttribute('data-us-copy')); }
  });
  var genSecretBtn = document.getElementById('generateSecretBtn');
  if (genSecretBtn) {
    genSecretBtn.addEventListener('click', function () {
      document.getElementById('response_secret').value = generateSecret();
    });
  }
</script>

<style nonce="<?=htmlspecialchars($userspice_nonce ?? '')?>">
  /* light blue bg for bg edit */
  .bg-edit {
    background-color: #d1ecf1 !important;
  }

  .secret-info {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    padding: 10px;
    border: 1px solid #ddd;
    z-index: 1;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    border-radius: 4px;

  }

  .client-info:hover .secret-info {
    display: block;
    z-index: 9999 !important;
  }

  .copy-btn {
    margin-left: 5px;
    padding: 2px 5px;
    font-size: 12px;
  }

  .table-responsive {
    overflow-x: auto;
  }

  .table th,
  .table td {
    vertical-align: middle;
  }

  .btn-group-sm>.btn,
  .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
  }
</style>

<div class="content mt-3">
  <div class="row">
    <div class="col-12">
      <h1>Configure the UserSpice OAuth Server
        <?= $statusBadge ?>
        <form method="post" action="" class="d-inline"
          data-us-confirm="<?= safeReturn($toggleSubmitWarning) ?>">
          <?= tokenHere(); ?>
          <input type="hidden" name="toggleServer" value="<?= $toggleServer ?>">
          <input type="submit" class="btn <?= $toggleServerClass ?> btn-sm" value="<?= $toggleServerText ?>">
        </form>

      </h1>

      <div class="row">
        <?php
        // Check if we have a one-time secret to display
        $oneTimeSecret = $_SESSION['oauth_new_client_secret'] ?? null;
        $oneTimeClientId = $_SESSION['oauth_new_client_id'] ?? null;
        if ($oneTimeSecret && $oneTimeClientId) {
          // Clear from session immediately after retrieval
          unset($_SESSION['oauth_new_client_secret']);
          unset($_SESSION['oauth_new_client_id']);
        ?>
          <div class="col-12 mb-3">
            <div class="alert alert-danger fade show" role="alert">
              <h4 class="alert-heading"><strong>IMPORTANT: Copy Your Client Secret Now!</strong></h4>
              <p class="mb-2">
                <strong>This secret will NEVER be shown again.</strong> Once you leave or refresh this page, it cannot be retrieved.
                If you lose it, you will need to regenerate a new secret and update your client application.
              </p>
              <hr>
              <div class="row">
                <div class="col-md-6">
                  <p class="mb-1"><strong>Client ID:</strong></p>
                  <div class="input-group mb-2">
                    <input type="text" class="form-control font-monospace" value="<?= safeReturn($oneTimeClientId) ?>" readonly>
                    <button type="button" class="btn btn-outline-dark" data-us-copy="<?= safeReturn($oneTimeClientId) ?>">Copy</button>
                  </div>
                </div>
                <div class="col-md-6">
                  <p class="mb-1"><strong>Client Secret:</strong></p>
                  <div class="input-group mb-2">
                    <input type="text" class="form-control font-monospace" value="<?= safeReturn($oneTimeSecret) ?>" readonly>
                    <button type="button" class="btn btn-outline-dark" data-us-copy="<?= safeReturn($oneTimeSecret) ?>">Copy</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>

        <?php if ($clientsC > 0) { ?>
          <div class="col-12 mb-3">
            <div class="card">
              <div class="card-header">
                <h3>Clients</h3>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                      <tr>
                        <th>Client Name</th>
                        <th>Client Info</th>
                        <th>Security</th>
                        <th>Redirect URI</th>
                        <th>Version / IP</th>
                        <th>Login Title</th>
                        <th>Login Script</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($clients as $c) {
                        // Check if secret is hashed (bcrypt starts with $2)
                        $isSecretHashed = strpos($c->client_secret, '$2') === 0;
                      ?>
                        <tr>
                          <td><?= safeReturn($c->client_name) ?></td>
                          <td class="client-info">
                            <span class="btn btn-sm btn-outline-info">View Info</span>
                            <div class="secret-info">
                              <b>Client: <?= safeReturn($c->client_name) ?></b><br>
                              <button type="button" class="btn btn-sm btn-outline-secondary copy-btn mb-2" data-us-copy="<?= safeReturn($c->client_id) ?>">Copy</button>
                              Client Id: <?= safeReturn($c->client_id) ?>
                              <br>
                              <?php if ($isSecretHashed) { ?>
                                <span class="text-success">Client Secret: [Securely Hashed]</span>
                              <?php } else { ?>
                                <span class="text-danger">Client Secret: [Plaintext - Insecure!]</span>
                              <?php } ?>
                              <?php if (!empty($c->response_secret)) { ?>
                              <br>
                              <button type="button" class="btn btn-sm btn-outline-secondary copy-btn" data-us-copy="<?= safeReturn($c->response_secret) ?>">Copy</button>
                              Response Secret: <?= safeReturn($c->response_secret) ?>
                              <?php } ?>
                            </div>
                          </td>
                          <td>
                            <?php if ($isSecretHashed) { ?>
                              <span class="badge bg-success" title="Secret is securely hashed">Secure</span>
                            <?php } else { ?>
                              <span class="badge bg-danger" title="Secret is stored in plaintext - regenerate to fix">Insecure</span>
                            <?php } ?>
                            <form method="post" action="" class="d-inline" data-us-confirm="WARNING: This will generate a new client secret.\n\nThe old secret will stop working IMMEDIATELY.\n\nYou will need to update your client application with the new secret.\n\nAre you sure you want to continue?">
                              <?= tokenHere(); ?>
                              <input type="hidden" name="regenerate_secret" value="<?= $c->id ?>">
                              <button type="submit" class="btn btn-sm <?= $isSecretHashed ? 'btn-outline-secondary' : 'btn-warning' ?>" title="Generate a new client secret">
                                <?= $isSecretHashed ? 'Regenerate' : 'Migrate' ?>
                              </button>
                            </form>
                          </td>
                          <td><?= safeReturn($c->redirect_uri) ?></td>
                          <td>
                            <?php if ($hasClientVer) { ?>
                              <span class="badge bg-secondary">v<?= UserSpiceOAuthProvider::clientVersion($c) ?></span>
                              <?php if (UserSpiceOAuthProvider::isPublicClient($c)) { ?><span class="badge bg-info">Public</span><?php } ?>
                              <?php if (UserSpiceOAuthProvider::isPublicClient($c) && trim((string)($c->cors_origins ?? '')) !== '') { ?>
                                <br><small>Origins: <?= safeReturn($c->cors_origins, true) ?></small>
                              <?php } ?>
                            <?php } ?>
                            <?php if (!empty($c->ip_restrict_on)) { ?>
                              <br><small>IP: <?= safeReturn($c->ip_restrict, true) ?></small>
                            <?php } elseif (trim((string)$c->ip_restrict) !== '') { ?>
                              <br><small class="text-body-secondary">IP (not enforced): <?= safeReturn($c->ip_restrict, true) ?></small>
                            <?php } ?>
                          </td>
                          <td><?= safeReturn($c->login_title) ?></td>
                          <td><?= safeReturn($c->login_script) ?></td>
                          <td><a href="<?= $us_url_root ?>users/admin.php?view=oauth&client=<?= $c->id ?>" class="btn btn-primary">Edit</a></td>
                          <td>
                            <form class="delete-form" method="post" action="" data-us-confirm="Are you sure that you want to delete this client? This cannot be undone.">
                              <?= tokenHere(); ?>
                              <input type="hidden" name="delete_client" value="<?= $c->id ?>">
                              <input type="submit" class="btn btn-danger" value="Delete">
                            </form>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>

        <div class="col-12 col-md-6">
          <div class="card">
            <div class="card-header 
            <?php if ($e) {
              echo 'bg-edit text-white';
            } ?>
            ">
              <h3><?= $e ? 'Edit Client' : 'Create New Client' ?></h3>
            </div>
            <div class="card-body">
              <form method="post" action="">
                <?= tokenHere(); ?>
                <?php if ($e) { ?>
                  <input type="hidden" name="client_id" value="<?= $client->id ?>">
                <?php } ?>

                <label for="client_name">Client Name:</label><br>
                <small>For Internal Use</small>
                <input type="text" class="form-control mb-3" id="client_name" name="client_name" value="<?= $e ? safeReturn($client->client_name, true) : '' ?>" required>


                <label for="client_description">Client Description:</label><br>
                <small>For Internal Use</small>

                <textarea class="form-control mb-3" id="client_description" name="client_description"><?= $e ? safeReturn($client->client_description, true) : '' ?></textarea>

                <label for="login_title">Login Title:</label><br>
                <small>This is the page title and title of the login form that the end user will see</small>
                <input type="text" class="form-control mb-3" id="login_title" name="login_title" value="<?= $e ? safeReturn($client->login_title, true) : '' ?>" required>


                <label for="redirect_uri">Redirect URI:</label><br>
                <small>This is the URI that the user will be redirected to after logging in and should be similar to<br>
                  <span class="text-danger-emphasis">https://yourdomain.com/users/auth/parsers/oauth_response.php</span></small>

                <input type="url" class="form-control mb-3" id="redirect_uri" name="redirect_uri" value="<?= $e ? safeReturn($client->redirect_uri, true) : '' ?>" required>

                <?php if ($hasClientVer) {
                  $formVer = $e ? UserSpiceOAuthProvider::clientVersion($client) : 1;
                ?>
                  <label for="client_ver">Client Version:</label><br>
                  <small>Version 1 requires PKCE (<code>code_challenge</code> with S256 at authorization, <code>code_verifier</code> and <code>redirect_uri</code> when exchanging the code). Version 0 is the original behavior and is kept for clients created before 6.2.0; the logs note whether each sign-in would pass version 1.</small>
                  <select class="form-select mb-3" id="client_ver" name="client_ver">
                    <option value="1" <?= $formVer === 1 ? 'selected' : '' ?>>Version 1 (PKCE required)</option>
                    <option value="0" <?= $formVer === 0 ? 'selected' : '' ?>>Version 0 (original, no PKCE)</option>
                  </select>

                  <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="public_client" name="public_client" value="1" <?= $e && !empty($client->public_client) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="public_client">Public client (mobile, desktop or single-page app)</label><br>
                    <small>Version 1 only. For apps that can't keep a secret: the client secret isn't checked, and PKCE plus <code>redirect_uri</code> prove the exchange instead.</small>
                  </div>

                  <?php if ($hasCors) { ?>
                    <label for="cors_origins">Allowed Browser Origins (public clients only):</label><br>
                    <small>For single-page apps that call the token and userinfo endpoints from the browser, e.g. <code>https://app.example.com</code> or <code>http://localhost:3000</code> (no path), separated by commas. Leave empty to send no CORS headers.</small>
                    <textarea class="form-control mb-3" id="cors_origins" name="cors_origins" rows="2"><?= $e ? safeReturn($client->cors_origins ?? '', true) : '' ?></textarea>
                  <?php } ?>
                <?php } else { ?>
                  <p class="mb-3"><small class="text-danger-emphasis">Run the updater to create version 1 (PKCE) clients. Until then, clients use the original behavior.</small></p>
                <?php } ?>

                <label for="ip_restrict">IP Restriction (optional):</label><br>
                <small>IP addresses or CIDR ranges allowed to call the token and userinfo endpoints (your client app's server), separated by commas. Behind a proxy or CDN, this matches the client address resolved on the Proxy &amp; CDN page.</small>
                <textarea class="form-control mb-2" id="ip_restrict" name="ip_restrict" rows="2"><?= $e ? safeReturn($client->ip_restrict, true) : '' ?></textarea>
                <?php if ($hasClientVer) { ?>
                  <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="ip_restrict_on" name="ip_restrict_on" value="1" <?= $e && !empty($client->ip_restrict_on) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="ip_restrict_on">Enforce IP restriction</label><br>
                    <small>Off unless checked. Not used for public clients.</small>
                  </div>
                <?php } else { ?>
                  <p class="mb-3"><small>Not enforced until the updater has run.</small></p>
                <?php } ?>

                <label for="login_script">Login Script:</label><br>
                <small>This is the optional script that will run after the user logs in. You can use the default or make a custom one and place it in the login_scripts folder. If you want to send additional information or instructions to the client, you can do that through this script.</small>
                <select class="form-select mb-3" id="login_script" name="login_script">
                  <option value="">--No Script--</option>
                  <?php foreach ($login_scripts as $ls) { ?>
                    <option value="<?= safeReturn($ls) ?>" <?= $e && $client->login_script == $ls ? "selected" : "" ?>><?= safeReturn($ls) ?></option>
                  <?php } ?>
                </select>

                <label for="response_secret">Response Secret (HMAC Signing):</label><br>
                <small>Optional. If set, the response data sent to the client will be signed with HMAC-SHA256 using this secret. The client must have the same secret configured to verify the signature. This prevents response tampering during redirect. Use a strong random string (32+ characters recommended).</small>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="response_secret" name="response_secret" value="<?= $e ? safeReturn($client->response_secret ?? '') : '' ?>" placeholder="Leave empty to disable signing">
                  <button class="btn btn-outline-secondary" type="button" id="generateSecretBtn">Generate</button>
                </div>

                <input type="submit" value="<?= $e ? 'Update Client' : 'Create Client' ?>" class="btn btn-outline-primary">
              </form>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6">
          <div class="card">
            <div class="card-header">
              <h3>Documentation</h3>
            </div>
            <div class="card-body">
              <p class="mt-2">The purpose of this feature is to allow you to use one server to authenticate multiple other projects. In addition to simply authenticating, this allows you to sync data from the server down to the clients, including changes in names and user tags. These clients can be UserSpice, WordPress, or nearly any of the most common programming languages.</p>

              <p class="mt-2"><strong>Client Name:</strong> An internal identifier for the OAuth client. This helps you manage multiple clients within your system.</p>

              <p class="mt-2"><strong>Client Description:</strong> Additional details about the client for internal reference. This can include the purpose of the client or any other relevant information.</p>

              <p class="mt-2"><strong>Login Title:</strong> The title displayed on the login page when users attempt to authenticate through this OAuth client.</p>

              <p class="mt-2"><strong>Redirect URI:</strong> The URL where users will be sent after successful authentication. This should match the URL configured in the client application.</p>

              <p class="mt-2"><strong>Endpoints:</strong> Authorization: <code><?= safeReturn($us_url_root) ?>users/auth/</code> (GET). Token: <code><?= safeReturn($us_url_root) ?>users/auth/</code> (POST, <code>grant_type=authorization_code</code>). Userinfo: <code><?= safeReturn($us_url_root) ?>users/auth/userinfo.php</code> (GET or POST with <code>Authorization: Bearer &lt;access token&gt;</code>; returns OpenID Connect claims). Under PHP-FPM, Apache may need <code>SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1</code> to pass the header to PHP.</p>

              <p class="mt-2"><strong>Client Version:</strong> Version 1 clients must use PKCE (RFC 7636, S256) and send <code>redirect_uri</code> when exchanging the code. New clients start at version 1. Clients created before 6.2.0 stay at version 0 until you switch them; after each sign-in the logs say whether a version 0 client would pass version 1, so you can check before switching.</p>

              <p class="mt-2"><strong>Public Client:</strong> For mobile, desktop and single-page apps, which can't keep a client secret. Version 1 only. A single-page app also needs its origin under Allowed Browser Origins, so the browser may read the token and userinfo responses.</p>

              <p class="mt-2"><strong>IP Restriction:</strong> An optional allowlist of the addresses your client app's server calls the token and userinfo endpoints from. It is only enforced when "Enforce IP restriction" is checked. The client secret is still required. Refused requests are logged with the address that was seen.</p>

              <p class="mt-2"><strong>Client ID and Secret:</strong> These are automatically generated when creating a new client. The client application uses these credentials to authenticate with your OAuth server. Keep these secure and only share them with trusted parties.</p>

              <p class="mt-2"><strong>Security Status:</strong> Client secrets are now stored using bcrypt hashing for security. Older clients with plaintext secrets will show an "Insecure" badge and a "Migrate" button. Clicking "Migrate" will generate a new hashed secret - you will need to update the client application with the new secret. <b>New secrets are only displayed once upon creation</b> - make sure to copy them immediately.</p>


              <p class="mt-2"><strong>Login Script:</strong> An optional script that runs after successful authentication. <b>These login scripts can provide all sorts of magical capabilities.</b> Please view the script in <span class="text-danger-emphasis">usersc/oauth_server/login_scripts/</span> for a more detailed example of how this works.</p>

              <p class="mt-2"><strong>Response Secret:</strong> An optional security feature that signs the response data with HMAC-SHA256. When configured, the server signs the user data before redirecting to the client. The client must have the same secret configured to verify the signature. This prevents man-in-the-middle attacks from tampering with user data during the OAuth redirect. <b>Both the server and client must have the same secret for this to work.</b></p>

              <p class="mt-2">This feature works in conjunction with the <a target="_blank" href="<?= $us_url_root ?>users/admin.php?view=spice&search=oauth_login">OAuth Client</a> which allows you to authenticate users on your client applications using this server. There is also an <a href="https://github.com/mudmin/userspice-oauth-examples" target="_blank">extensive repository</a> of tools to authenticate to this server in many other languages and applications including Wordpress, Rust, Python, React and many others.

              </p>
            </div>

          </div>
          <small class="pt-2 ms-2">
            <p> Server icons created by Freepik at https://www.flaticon.com/free-icons/server<br>
              Widget icon created by HJ Studio at https://www.flaticon.com/authors/hj-studio<br></p>
          </small>
        </div>

      </div>

    </div>
  </div>