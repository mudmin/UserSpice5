<?php
$wl = $db->query("SELECT * FROM us_ip_whitelist")->results();
$bl = $db->query("SELECT * FROM us_ip_blacklist")->results();
if (!empty($_POST)) {
  $token = $_POST['csrf'];
  if (!Token::check($token)) {
    include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
  }
  if (!empty($_POST['newIP'])) {
    $ip = Input::get('ip');
    $wl = Input::get('type');
    if (filter_var($ip, FILTER_VALIDATE_IP)) {
      if ($wl == 'whitelist') {
        logger($user->data()->id, "Setting Change", "Whitelisted " . $ip);
        $db->insert('us_ip_whitelist', ['ip' => $ip]);
        usSuccess("New IP whitelisted");
        Redirect::to($us_url_root . 'users/admin.php?view=ip');
      } else {
        logger($user->data()->id, "Setting Change", "Blacklisted " . $ip);
        $db->insert('us_ip_blacklist', ['ip' => $ip]);
        usSuccess("New IP blacklisted");
        Redirect::to($us_url_root . 'users/admin.php?view=ip');
      }
    } else {
      usError("Invalid IP address");
      Redirect::to($us_url_root . 'users/admin.php?view=ip');
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
    <h2 class="mb-3">IP Manager</h2>
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
              <select class="form-control" name="type" aria-describedby="type-label" required>
                <option value="" disabled selected>Choose Type</option>
                <option value="whitelist">Whitelist</option>
                <option value="blacklist">Blacklist</option>
              </select>
            </div>
            <div class="col-12 col-md-4">
              <input type="submit" name="newIP" value="Add IP" class="btn btn-primary">
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<form class="" action="" method="post">
  <?= tokenHere(); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span>Manage IP Addresses</span>

          <span class="justify-content-end">
            <input type="submit" name="saveChecks" value="Remove Checked  IPs" class="btn btn-danger btn-sm">
          </span>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-5">
              <h4>Current Whitelist</h4>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">IP Address</th>
                    <th scope="col">
                      <input type="checkbox" class="removeWhite">
                      Delete
                    </th>
                  </tr>
                </thead>

                <tbody>
                  <?php foreach ($wl as $b) { ?>
                    <tr>
                      <td><?= $b->ip ?></td>
                      <td>
                        <label class="switch switch-text switch-success">
                          <input type="checkbox" class="switch-input toggle white" data-desc="Remove from Blacklist" name="deletewhite[<?= $b->id ?>]" value="<?= $b->id ?>">
                          <span data-on="Yes" data-off="No" class="switch-label"></span>
                          <span class="switch-handle"></span>
                        </label>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>

            <div class="col-12 col-md-7">
              <h4>Current Blacklist</h4>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">IP Address</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Last User</th>
                    <th scope="col">
                      <input type="checkbox" class="removeBlack">
                      Delete
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($bl as $b) { ?>
                    <tr>
                      <td><?= $b->ip ?></td>
                      <td><?php ipReason($b->reason); ?></td>
                      <td><?php echouser($b->last_user); ?></td>
                      <td>
                        <label class="switch switch-text switch-success">
                          <input type="checkbox" class="switch-input toggle black" data-desc="Remove from Blacklist" name="deleteblack[<?= $b->id ?>]" value="<?= $b->id ?>">
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
  </div>
</form>


<script>
  $(document).ready(function() {
    $('.removeWhite').on('click', function(e) {
      $('.white').prop('checked', $(e.target).prop('checked'));
    });

    $('.removeBlack').on('click', function(e) {
      $('.black').prop('checked', $(e.target).prop('checked'));
    });
  }); //End Document Ready Function
</script>