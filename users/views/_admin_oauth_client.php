<?php

$clientsQ = $db->query("SELECT * FROM us_oauth_client_login_options ORDER BY id ASC");
$clientsC = $clientsQ->count();
$clients = $clientsQ->results();

$client = Input::get('client');
$e = false;
if (is_numeric($client)) {
  $q = $db->query("SELECT * FROM us_oauth_client_login_options WHERE id = ?", [$client]);
  if ($q->count() > 0) {
    $client = $q->first();
    $e = true;
  } else {
    usError("OAuth client not found");
    $client = "";
  }
}

// Scan for available icons and scripts
$icons_path = $abs_us_root . $us_url_root . 'usersc/oauth_client/assets';
$scripts_path = $abs_us_root . $us_url_root . 'usersc/oauth_client/login_scripts';

// Create directories if they don't exist
if (!file_exists($icons_path)) {
    mkdir($icons_path, 0755, true);
    // Copy default icon if it doesn't exist
    $default_icon_source = $abs_us_root . $us_url_root . 'users/auth/oauth_client/assets/_default.png';
    $default_icon_dest = $icons_path . '/_default.png';
    if (file_exists($default_icon_source) && !file_exists($default_icon_dest)) {
        copy($default_icon_source, $default_icon_dest);
    }
}
if (!file_exists($scripts_path)) {
    mkdir($scripts_path, 0755, true);
    // Copy default script if it doesn't exist
    $default_script_source = $abs_us_root . $us_url_root . 'users/auth/oauth_client/login_scripts/default_script.php';
    $default_script_dest = $scripts_path . '/default_script.php';
    if (file_exists($default_script_source) && !file_exists($default_script_dest)) {
        copy($default_script_source, $default_script_dest);
    }
}

$icons = [];
if (is_dir($icons_path)) {
    $icons = scandir($icons_path);
    $icons = array_filter($icons, function ($file) {
        return strpos($file, '.png') !== false || strpos($file, '.jpg') !== false || strpos($file, '.svg') !== false;
    });
}

$login_scripts = [];
if (is_dir($scripts_path)) {
    $login_scripts = scandir($scripts_path);
    $login_scripts = array_filter($login_scripts, function ($file) {
        return strpos($file, '.php') !== false;
    });
}

if (!empty($_POST)) {
  if (!Token::check(Input::get('csrf'))) {
    include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
  }

  if (is_numeric(Input::get('delete_client'))) {
    $clientId = Input::get('delete_client');
    
    // Check if this client is currently enabled
    $clientToDelete = $db->query("SELECT * FROM us_oauth_client_login_options WHERE id = ?", [$clientId])->first();
    
    $db->delete('us_oauth_client_login_options', ['id' => $clientId]);
    if (!$db->error()) {
      // Check if any clients are still active to set global OAuth setting
      $activeClientsCount = $db->query("SELECT id FROM us_oauth_client_login_options WHERE oauth = 1")->count();
      $db->update('settings', 1, ['oauth' => $activeClientsCount > 0 ? 1 : 0]);
      
      usSuccess("OAuth client deleted successfully");
      logger($user->data()->id, "OAuth Client", "Client ID $clientId deleted");
    } else {
      usError("Error deleting OAuth client");
    }
    Redirect::to($us_url_root . 'users/admin.php?view=oauth_client');
  }

  if (isset($_POST['toggle_client'])) {
    $clientId = Input::get('toggle_client');
    $currentStatus = Input::get('current_status');
    
    // Toggle the client status
    $newStatus = $currentStatus == 1 ? 0 : 1;
    $db->update('us_oauth_client_login_options', $clientId, ['oauth' => $newStatus]);
    
    // Check if any clients are now active to set global OAuth setting
    $activeClientsCount = $db->query("SELECT id FROM us_oauth_client_login_options WHERE oauth = 1")->count();
    $db->update('settings', 1, ['oauth' => $activeClientsCount > 0 ? 1 : 0]);
    
    if (!$db->error()) {
      $action = $newStatus == 1 ? "enabled" : "disabled";
      usSuccess("OAuth client $action successfully");
      logger($user->data()->id, "OAuth Client", "Client ID $clientId $action");
    } else {
      usError("Error updating OAuth client");
    }
    Redirect::to($us_url_root . 'users/admin.php?view=oauth_client');
  }

  // Handle client creation/update
  $fields = [
    'client_name' => Input::get('client_name'),
    'server_url' => rtrim(Input::get('server_url'), '/') . '/', // Ensure trailing slash
    'server_target' => Input::get('server_target'),
    'client_id' => Input::get('client_id'),
    'client_secret' => Input::get('client_secret'),
    'redirect_uri' => Input::get('redirect_uri'),
    'login_title' => Input::get('login_title'),
    'client_icon' => Input::get('client_icon'),
    'login_script' => Input::get('login_script'),
  ];

  if ($e) {
    usSuccess("OAuth client updated");
    $db->update('us_oauth_client_login_options', $client->id, $fields);
    $id = $client->id;
  } else {
    usSuccess("OAuth client created");
    $db->insert('us_oauth_client_login_options', $fields);
    $id = $db->lastId();
  }

  if (!$db->error()) {
    logger($user->data()->id, "OAuth Client", $fields['client_name'] . " OAuth client updated/created");
    Redirect::to($us_url_root . 'users/admin.php?view=oauth_client&client=' . $id);
  } else {
    usError("Database error: " . $db->errorString());
    Redirect::to($us_url_root . 'users/admin.php?view=oauth_client');
  }
}

// Get current active clients (plural now)
$activeClientsQ = $db->query("SELECT * FROM us_oauth_client_login_options WHERE oauth = 1");
$activeClients = $activeClientsQ->results();
$activeClientCount = $activeClientsQ->count();
?>

<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">
  function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
      // Success feedback could go here
    }, function(err) {
      console.error('Could not copy text: ', err);
    });
  }
</script>

<style>
  .bg-edit {
    background-color: #d1ecf1 !important;
  }
  
  .bg-active {
    background-color: #d4edda !important;
  }
  
  .client-info {
    position: relative;
  }
  
  .secret-info {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    padding: 10px;
    border: 1px solid #ddd;
    z-index: 1000;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    border-radius: 4px;
    max-width: 100vw;
    word-wrap: break-word;
    bottom: 100%;
    left: 0;
    margin-bottom: 5px;
  }
  
  /* If there's not enough space above, show below */
  .table-responsive {
    overflow: visible;
  }
  
  .client-info {
    position: relative;
  }
  
  /* Alternative: use a modal-style popup that's always visible */
  @media (max-width: 768px) {
    .secret-info {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      max-width: 90vw;
      bottom: auto;
      margin-bottom: 0;
    }
  }

  .client-info:hover .secret-info {
    display: block;
  }

  .copy-btn {
    margin-left: 5px;
    padding: 2px 5px;
    font-size: 12px;
  }

  .table-responsive {
    overflow: visible;
  }

  .table th,
  .table td {
    vertical-align: middle;
  }
</style>

<div class="content mt-3">
  <div class="row">
    <div class="col-12">
      <h1>Configure OAuth Client Login</h1>
      <p class="lead">Connect to external OAuth servers for user authentication</p>

      <?php if ($settings->oauth == 1): ?>
        <div class="alert alert-success">
          <i class="fa fa-check-circle"></i> OAuth login is currently <strong>enabled</strong>
        </div>
      <?php else: ?>
        <div class="alert alert-warning">
          <i class="fa fa-exclamation-triangle"></i> OAuth login is currently <strong>disabled</strong>
        </div>
      <?php endif; ?>

      <div class="row">
        <?php if ($clientsC > 0) { ?>
          <div class="col-12 mb-3">
            <div class="card">
              <div class="card-header">
                <h3>OAuth Client Configurations</h3>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                      <tr>
                        <th>Status</th>
                        <th>Client Name</th>
                        <th>Server URL</th>
                        <th>Client Info</th>
                        <th>Login Title</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($clients as $c) { ?>
                        <tr class="<?= $c->oauth == 1 ? 'table-success' : '' ?>">
                          <td>
                            <form method="post" class="d-inline">
                              <?= tokenHere(); ?>
                              <input type="hidden" name="toggle_client" value="<?= $c->id ?>">
                              <input type="hidden" name="current_status" value="<?= $c->oauth ?>">
                              <?php if ($c->oauth == 1): ?>
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Disable this OAuth client?')">
                                  <i class="fa fa-toggle-on"></i> Enabled
                                </button>
                              <?php else: ?>
                                <button type="submit" class="btn btn-sm btn-outline-secondary" onclick="return confirm('Enable this OAuth client?')">
                                  <i class="fa fa-toggle-off"></i> Disabled
                                </button>
                              <?php endif; ?>
                            </form>
                          </td>
                          <td><?= hed($c->client_name) ?></td>
                          <td class="text-truncate" style="max-width: 200px;"><?= hed($c->server_url) ?></td>
                          <td class="client-info">
                            <button class="btn btn-sm btn-outline-info">View Credentials</button>
                            <div class="secret-info">
                              <b>Client: <?= hed($c->client_name) ?></b><br>
                              <button class="btn btn-sm btn-outline-secondary copy-btn mb-2" onclick="copyToClipboard('<?= hed($c->client_id) ?>')">Copy</button>
                              Client ID: <small><?= hed($c->client_id) ?></small>
                              <br>
                              <button class="btn btn-sm btn-outline-secondary copy-btn mb-2" onclick="copyToClipboard('<?= hed($c->client_secret) ?>')">Copy</button>
                              Client Secret: <small><?= hed(substr($c->client_secret, 0, 20)) ?>...</small>
                              <br>
                              <button class="btn btn-sm btn-outline-secondary copy-btn" onclick="copyToClipboard('<?= hed($c->redirect_uri) ?>')">Copy</button>
                              Redirect URI: <small><?= hed($c->redirect_uri) ?></small>
                            </div>
                          </td>
                          <td><?= hed($c->login_title) ?></td>
                          <td>
                            <div class="btn-group" role="group">
                              <a href="<?= $us_url_root ?>users/admin.php?view=oauth_client&client=<?= $c->id ?>" class="btn btn-sm btn-primary">Edit</a>
                              <form class="d-inline" method="post" onsubmit="return confirm('Are you sure you want to delete this OAuth client? This cannot be undone.');">
                                <?= tokenHere(); ?>
                                <input type="hidden" name="delete_client" value="<?= $c->id ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                              </form>
                            </div>
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

        <div class="col-12 col-lg-6">
          <div class="card">
            <div class="card-header <?php if ($e) { echo 'bg-edit'; } ?>">
              <h3><?= $e ? 'Edit OAuth Client' : 'Add New OAuth Client' ?></h3>
            </div>
            <div class="card-body">
              <form method="post" action="">
                <?= tokenHere(); ?>

                <div class="mb-3">
                  <label for="client_name" class="form-label">Client Name *</label>
                  <small class="form-text text-muted">Internal identifier for this OAuth configuration</small>
                  <input type="text" class="form-control" id="client_name" name="client_name" 
                         value="<?= $e ? hed($client->client_name) : '' ?>" required>
                </div>

                <div class="mb-3">
                  <label for="server_url" class="form-label">OAuth Server URL *</label>
                  <small class="form-text text-muted">Full domain URL with trailing slash (e.g., https://auth.example.com/)</small>
                  <input type="url" class="form-control" id="server_url" name="server_url" 
                         value="<?= $e ? hed($client->server_url) : '' ?>" required>
                </div>

                <div class="mb-3">
                  <label for="server_target" class="form-label">Server Target Path</label>
                  <small class="form-text text-muted">Path to OAuth endpoints (usually users/auth/)</small>
                  <input type="text" class="form-control" id="server_target" name="server_target" 
                         value="<?= $e ? hed($client->server_target) : 'users/auth/' ?>">
                </div>

                <div class="mb-3">
                  <label for="client_id" class="form-label">Client ID *</label>
                  <small class="form-text text-muted">Obtain from the OAuth server</small>
                  <input type="text" class="form-control" id="client_id" name="client_id" 
                         value="<?= $e ? hed($client->client_id) : '' ?>" required>
                </div>

                <div class="mb-3">
                  <label for="client_secret" class="form-label">Client Secret *</label>
                  <small class="form-text text-muted">Obtain from the OAuth server</small>
                  <input type="password" class="form-control" id="client_secret" name="client_secret" 
                         value="<?= $e ? hed($client->client_secret) : '' ?>" required>
                </div>

                <?php
                $baseUrl = Server::getOrigin();
                $exampleRedirectUri = $baseUrl . $us_url_root . "users/auth/parsers/oauth_response.php";
                ?>

                <div class="mb-3">
                  <label for="redirect_uri" class="form-label">Redirect URI *</label>
                  <small class="form-text text-muted">Example: <?= hed($exampleRedirectUri) ?></small>
                  <input type="url" class="form-control" id="redirect_uri" name="redirect_uri" 
                         value="<?= $e ? hed($client->redirect_uri) : $exampleRedirectUri ?>">
                </div>

                <div class="mb-3">
                  <label for="login_title" class="form-label">Login Button Title</label>
                  <small class="form-text text-muted">Text displayed on the login button</small>
                  <input type="text" class="form-control" id="login_title" name="login_title" 
                         value="<?= $e ? hed($client->login_title) : 'UserSpice' ?>">
                </div>

                <div class="mb-3">
                  <label for="client_icon" class="form-label">Login Button Icon</label>
                  <small class="form-text text-muted">Icon for the login button</small>
                  <select class="form-select" id="client_icon" name="client_icon">
                    <option value="">-- No Icon --</option>
                    <?php foreach ($icons as $icon): ?>
                      <option value="<?= hed($icon) ?>" 
                              <?= $e && $client->client_icon == $icon ? 'selected' : '' ?>>
                        <?= hed($icon) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="login_script" class="form-label">Login Script</label>
                  <small class="form-text text-muted">Optional script to run after successful login</small>
                  <select class="form-select" id="login_script" name="login_script">
                    <option value="">-- No Script --</option>
                    <?php foreach ($login_scripts as $script): ?>
                      <option value="<?= hed($script) ?>" 
                              <?= $e && $client->login_script == $script ? 'selected' : '' ?>>
                        <?= hed($script) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <button type="submit" class="btn btn-primary">
                  <?= $e ? 'Update OAuth Client' : 'Create OAuth Client' ?>
                </button>
                
                <?php if ($e): ?>
                  <a href="<?= $us_url_root ?>users/admin.php?view=oauth_client" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
              </form>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-6">
          <div class="card">
            <div class="card-header">
              <h3>Recent OAuth Logins</h3>
            </div>
            <div class="card-body">
              <?php
              $recentLogins = $db->query("SELECT 
                l.*,
                u.username,
                u.fname,
                u.lname,
                u.email
                FROM us_oauth_client_logins l
                LEFT JOIN users u ON l.user_id = u.id
                ORDER BY l.id DESC LIMIT 10")->results();
              ?>
              
              <?php if (count($recentLogins) > 0): ?>
                <div class="table-responsive">
                  <table class="table table-sm">
                    <thead>
                      <tr>
                        <th>User</th>
                        <th>New</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($recentLogins as $login): ?>
                        <tr>
                          <td>
                            <?= hed($login->fname . ' ' . $login->lname) ?><br>
                            <small class="text-muted"><?= hed($login->email) ?></small>
                          </td>
                          <td>
                            <?php if ($login->new_user == 1): ?>
                              <span class="badge bg-success">Yes</span>
                            <?php else: ?>
                              <span class="badge bg-secondary">No</span>
                            <?php endif; ?>
                          </td>
                          <td><small><?= $login->ts ?></small></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              <?php else: ?>
                <p class="text-muted">No OAuth logins recorded yet.</p>
              <?php endif; ?>
            </div>
          </div>

          <div class="card mt-3">
            <div class="card-header">
              <h3>Documentation</h3>
            </div>
            <div class="card-body">
              <p class="mt-2">The purpose of this feature is to allow your UserSpice installation to authenticate users against external OAuth servers. This is the client side of OAuth authentication - it connects to OAuth servers (which could be other UserSpice installations, custom OAuth implementations, or third-party services) to authenticate and potentially synchronize user data.</p>

              <p class="mt-2"><strong>Client Name:</strong> An internal identifier for the OAuth client configuration. This helps you manage multiple OAuth server connections within your system. This is only visible to administrators and is used for organization purposes.</p>

              <p class="mt-2"><strong>OAuth Server URL:</strong> The base URL of the OAuth server you want to connect to. This should be the full domain with protocol (https://example.com/). The system will automatically ensure proper formatting with trailing slashes.</p>

              <p class="mt-2"><strong>Server Target Path:</strong> The specific path on the OAuth server where the authentication endpoints are located. For UserSpice OAuth servers, this is typically 'users/auth/'. For other implementations, consult their documentation.</p>

              <p class="mt-2"><strong>Client ID and Client Secret:</strong> These credentials are provided by the OAuth server administrator when they create a client configuration for your application. These must match exactly what's configured on the server side. Keep the client secret secure and never expose it in client-side code.</p>

              <p class="mt-2"><strong>Redirect URI:</strong> This is the URL on your server where users will be sent after authentication on the OAuth server. This must be configured exactly the same on both the client (here) and the server. The default format is typically <span style="color:red;">https://yourdomain.com/users/auth/parsers/oauth_response.php</span></p>

              <p class="mt-2"><strong>Login Button Title:</strong> The text that appears on the OAuth login button on your login page. This helps users identify which service they're logging in with (e.g., "Login with Main Server", "Corporate Login", etc.).</p>

              <p class="mt-2"><strong>Login Button Icon:</strong> A visual icon that appears alongside the login button. You can add custom icons by placing image files (PNG, JPG, SVG) in the <span style="color:red;">usersc/oauth_client/assets/</span> directory. This helps users visually identify the OAuth option.</p>

              <p class="mt-2"><strong>Login Script:</strong> An optional script that runs after successful OAuth authentication. <b>These scripts provide powerful post-authentication capabilities.</b> You can create custom scripts to handle user data synchronization, role mapping, welcome messages, or any other post-login logic. Place custom scripts in <span style="color:red;">usersc/oauth_client/login_scripts/</span> and examine the default script for implementation examples.</p>

              <h5 class="mt-4">Multi-Server Authentication</h5>
              <p class="mt-2">This system supports multiple OAuth server configurations simultaneously. Users can choose from multiple authentication options on the login page, allowing for scenarios like:</p>
              <ul>
                <li>Corporate authentication server + backup authentication server</li>
                <li>Different authentication servers for different user types</li>
                <li>Testing new OAuth configurations alongside production ones</li>
              </ul>

              <h5 class="mt-4">Security Considerations</h5>
              <p class="mt-2">OAuth authentication is only as secure as the OAuth server you're connecting to. Ensure that:</p>
              <ul>
                <li>The OAuth server uses HTTPS</li>
                <li>Client secrets are kept confidential</li>
                <li>Redirect URIs are exactly configured on both ends</li>
                <li>The OAuth server is maintained and trustworthy</li>
              </ul>

              <h5 class="mt-4">User Data Synchronization</h5>
              <p class="mt-2">When users authenticate via OAuth, the system can synchronize user data from the OAuth server, including names, email addresses, and custom attributes. This synchronization happens automatically and helps keep user information up-to-date across multiple systems.</p>

              <h5 class="mt-4">Troubleshooting</h5>
              <p class="mt-2">Common issues and solutions:</p>
              <ul>
                <li><strong>Redirect URI mismatch:</strong> Ensure the redirect URI is identical on both client and server</li>
                <li><strong>Invalid client credentials:</strong> Verify the client ID and secret match the server configuration</li>
                <li><strong>Server unreachable:</strong> Check the server URL and ensure the OAuth server is running</li>
                <li><strong>SSL/HTTPS issues:</strong> Both client and server should use HTTPS in production</li>
              </ul>

              <p class="mt-2">This feature works in conjunction with the <a target="_blank" href="<?= $us_url_root ?>users/admin.php?view=oauth" style="color:blue;">OAuth Server</a> which allows you to create your own OAuth authentication server. There is also an <a href="https://github.com/mudmin/userspice-oauth-examples" target="_blank" style="color:blue;">extensive repository</a> of tools and examples for implementing OAuth in various languages and applications including WordPress, Rust, Python, React and many others.</p>


            </div>
          </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>