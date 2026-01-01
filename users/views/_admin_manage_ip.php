<?php
$wl = $db->query("SELECT * FROM us_ip_whitelist")->results();
$bl = $db->query("SELECT * FROM us_ip_blacklist")->results();

if (!empty($_POST)) {
  $token = $_POST['csrf'];
  if (!Token::check($token)) {
    include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
  }
  
  if (!empty($_POST['newIP'])) {
    $ip      = Input::get('ip');
    $type    = Input::get('type');
    $descrip = Input::get('descrip');
    $added_by = $user->data()->id;
    $added_on = date("Y-m-d H:i:s");

    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
      usError("Invalid IP address");
      Redirect::to($us_url_root . 'users/admin.php?view=ip');
    }
    
    if ($type == 'whitelist') {
      logger($user->data()->id, "Setting Change", "Whitelisted " . $ip);
      $db->insert('us_ip_whitelist', [
        'ip'        => $ip,
        'descrip'   => $descrip,
        'added_by'  => $added_by,
        'added_on'  => $added_on
      ]);
      usSuccess("New IP whitelisted");
      Redirect::to($us_url_root . 'users/admin.php?view=ip');
    } else if ($type == 'blacklist') {
      if ($ip == ipCheck()){
        usError("You cannot blacklist your own IP");
        Redirect::to($us_url_root . 'users/admin.php?view=ip');
      } else {
        logger($user->data()->id, "Setting Change", "Blacklisted " . $ip);
        $expires_input = Input::get('expires');
        if (!empty($expires_input)) {
          $expires = date('Y-m-d H:i:s', strtotime($expires_input));
        } else {
          $expires = null;
        }
        $db->insert('us_ip_blacklist', [
          'ip'        => $ip,
          'expires'   => $expires,
          'descrip'   => $descrip,
          'added_by'  => $added_by,
          'added_on'  => $added_on
        ]);
        usSuccess("New IP blacklisted");
        Redirect::to($us_url_root . 'users/admin.php?view=ip');
      }
    }
  }

  if (!empty($_POST['saveChecks'])) {
    $deleteWhite = Input::get('deletewhite');
    if (is_array($deleteWhite)) {
      foreach ($deleteWhite as $v) {
        $db->query("DELETE FROM us_ip_whitelist WHERE id = ?", array($v));
      }
    }
    $deleteBlack = Input::get('deleteblack');
    if (is_array($deleteBlack)) {
      foreach ($deleteBlack as $v) {
        $db->query("DELETE FROM us_ip_blacklist WHERE id = ?", array($v));
      }
    }
    usSuccess("IP(s) Deleted");
    Redirect::to($us_url_root . 'users/admin.php?view=ip');
  }
}
?>

<div class="row">
  <div class="col-md-12">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="mb-3">IP Manager</h2>
      <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#expirationModal">
        How Expiration Works
      </button>
    </div>
    <div class="card">
      <div class="card-header">
        Add IP Address
      </div>
      <div class="card-body">
        <p>Note: Whitelist overrides Blacklist</p>
        <form action="" method="post">
          <?= tokenHere(); ?>
          <div class="row">
            <div class="col-12 col-md-4">
              <input type="text" class="form-control" aria-describedby="ip-label" name="ip" placeholder="Enter IP Address" required>
            </div>
            <div class="col-12 col-md-4">
              <select class="form-control" name="type" id="ipType" aria-describedby="type-label" required>
                <option value="" disabled selected>Choose Type</option>
                <option value="whitelist">Whitelist</option>
                <option value="blacklist">Blacklist</option>
              </select>
            </div>
            <div class="col-12 col-md-4">
              <input type="submit" name="newIP" value="Add IP" class="btn btn-primary">
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12 col-md-6">
              <input type="text" class="form-control" name="descrip" placeholder="Description (optional)">
            </div>
            <div class="col-12 col-md-6" id="expiryField" style="display: none;">
              <div class="input-group">
                <span class="pt-2">Expires (optional):</span>
                <input type="datetime-local" class="form-control" name="expires" placeholder="Expiry (for Blacklist only)">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<form action="" method="post">
  <?= tokenHere(); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span>Manage IP Addresses</span>
          <span class="justify-content-end">
            <input type="submit" name="saveChecks" value="Remove Checked IPs" class="btn btn-danger btn-sm">
          </span>
        </div>
        <div class="card-body">
          <div class="row">
            <!-- Whitelist Table -->
            <div class="col-12 col-md-5">
              <h4>Current Whitelist</h4>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">IP Address</th>
                    <th scope="col">Description</th>
                    <th scope="col">Added By</th>
                    <th scope="col">Added On</th>
                    <th scope="col">
                      <input type="checkbox" class="removeWhite"> Delete
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($wl as $b) { ?>
                    <tr>
                      <td><?= $b->ip ?></td>
                      <td><?= !empty($b->descrip) ? $b->descrip : '' ?></td>
                      <td><?= !empty($b->added_by) ? echouser($b->added_by) : '' ?></td>
                      <td><?= !empty($b->added_on) ? $b->added_on : '' ?></td>
                      <td>
                        <label class="switch switch-text switch-success">
                          <input type="checkbox" class="switch-input toggle white" name="deletewhite[<?= $b->id ?>]" value="<?= $b->id ?>">
                          <span data-on="Yes" data-off="No" class="switch-label"></span>
                          <span class="switch-handle"></span>
                        </label>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- Blacklist Table -->
            <div class="col-12 col-md-7">
              <h4>Current Blacklist</h4>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">IP Address</th>
                    <th scope="col">Expiry</th>
                    <th scope="col">Reason/Description</th>
                    <th scope="col">Added By</th>
                    <th scope="col">Added On</th>
                    <th scope="col">
                      <input type="checkbox" class="removeBlack"> Delete
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($bl as $b) { ?>
                    <tr>
                      <td><?= $b->ip ?></td>
                      <td><?= !empty($b->expires) ? $b->expires : '' ?></td>
                      <td><?= !empty($b->descrip) ? $b->descrip : ipReason($b->reason) ?></td>
                      <td><?= !empty($b->added_by) ? echouser($b->added_by) : '' ?></td>
                      <td><?= !empty($b->added_on) ? $b->added_on : '' ?></td>
                      <td>
                        <label class="switch switch-text switch-success">
                          <input type="checkbox" class="switch-input toggle black" name="deleteblack[<?= $b->id ?>]" value="<?= $b->id ?>">
                          <span data-on="Yes" data-off="No" class="switch-label"></span>
                          <span class="switch-handle"></span>
                        </label>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Modal: How Expiration Works -->
<div class="modal modal-lg fade" id="expirationModal" tabindex="-1" role="dialog" aria-labelledby="expirationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="expirationModalLabel">How IP Expiration Works</h5>

      </div>
      <div class="modal-body">
        <p>IP blacklist expiration is handled by a cron job that runs the following query:</p>
        <pre>$now = date("Y-m-d H:i:s");
$db->query("DELETE FROM us_ip_blacklist WHERE expires IS NOT NULL AND expires < ?", [$now]);</pre>
        <p>Set up your cron job to <code>curl</code> your site domain at <code>/users/release_blacklist.php</code>. The query is very lightweight so it can be triggered every minute.</p>
        <p>If you choose to run the cron job less frequently, it will delay how soon an expired IP is removed from the blacklist.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">
  $(document).ready(function() {
    $('.removeWhite').on('click', function(e) {
      $('.white').prop('checked', $(e.target).prop('checked'));
    });

    $('.removeBlack').on('click', function(e) {
      $('.black').prop('checked', $(e.target).prop('checked'));
    });

    // Toggle expiry field based on IP type selection
    $('#ipType').on('change', function() {
      if ($(this).val() === 'blacklist') {
        $('#expiryField').show();
      } else {
        $('#expiryField').hide();
      }
    });
  });
</script>
