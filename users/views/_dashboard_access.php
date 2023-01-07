<style media="screen">
  input[type=checkbox] {
    /* Double-sized Checkboxes */
    -ms-transform: scale(2);
    /* IE */
    -moz-transform: scale(2);
    /* FF */
    -webkit-transform: scale(2);
    /* Safari and Chrome */
    -o-transform: scale(2);
    /* Opera */
    padding: 10px;
  }
</style>

<?php
if (!in_array($user->data()->id, $master_account)) {
  Redirect::to('admin.php');
}
$features = $db->query("SELECT DISTINCT id, feature, access FROM us_management ORDER BY feature")->results();

$adminID = $db->query("SELECT id FROM pages WHERE page = ?", ["users/admin.php"])->first();


$matches = $db->query("SELECT * FROM permission_page_matches WHERE page_id = ? AND permission_id > 2", [$adminID->id])->results();


$perms = [];
foreach ($matches as $m) {
  $name = $db->query("SELECT name from permissions WHERE id = ?", [$m->permission_id])->first();
  $perms[$m->permission_id] = $name->name;
}


if (!empty($_POST)) {
  // dnd($_POST);
  $token = $_POST['csrf'];
  if (!Token::check($token)) {
    include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
  }
  foreach ($features as $f) {
    $pages = $db->query("SELECT * FROM us_management WHERE feature = ?", [$f->feature])->results();
    $str = str_replace(" ", "_", $f->feature);
    foreach ($pages as $p) {
      if (isset($_POST[$str])) {
        $implode = implode(",", $_POST[$str]);
        $db->update('us_management', $p->id, ['access' => $implode]);
      } else {
        $db->update('us_management', $p->id, ['access' => ""]);
      }
    }
  }
  usSuccess("Access updated");
  Redirect::to('admin.php?view=access');
}
$token = Token::generate();
?>

<h2>Grant Dashboard Access</h2>
<p class="text-dark mt-2">Please Note: Allowing users other than trusted admins should not be taken lightly. You are giving these users the opportunity to do some very powerful things to your site.</p>

<p class="text-dark mt-2">This is a TWO step process. You must go into Page Management and allow the other access level(s) that you want to give access to access the admin.php page. Then you can come in here and grant that access level permission to a particular section of the dashboard.
</p>

<p class="text-dark mt-2">
  Please note, some actions are limited by default to users of the master account or admins (permission level 2) and cannot be overriden on this
  page.</p>

<p class="text-danger mt-2">You have been warned!</p>

<?php if ($perms == []) { ?>
  <p class="text-danger mt-2">You do not have any permission levels other than Admin assigned to admin.php. so there's nothing to do here.
    <a href="admin.php?view=page&id=<?= $adminID->id ?>">Manage</a> your admin.php here.
  </p>
<?php } ?>

<div class="card">
  <div class="card-body">
    <form class="" action="" method="post">
      <div class="d-block text-end pb-3">
        <input type="submit" name="submit" value="Update Permissions" class="btn btn-primary">
      </div>
      <input type="hidden" name="csrf" value="<?= $token ?>" />
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Feature</th>
            <?php for ($i = 1; $i <= count($perms); $i++) {
              echo '<th></th>';
            } ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($features as $f) {
            $row = explode(",", $f->access);
          ?>
            <tr>
              <td><?= $f->feature ?></td>
              <?php foreach ($perms as $key => $value) {
                $isChecked = in_array($key, $row) ? "checked" : "";
                $elId = $f->id . '-' . $key;
              ?>
                <td>
                  <div class="form-check">
                    <input class="me-2" type="checkbox" name="<?= $f->feature ?>[]" value="<?= $key ?>" <?= $isChecked ?> id="<?= $elId ?>">
                    <label class="form-check-label" for="<?= $elId ?>"><?= $value ?></label>
                  </div>
                </td>
              <?php } ?>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="d-block text-end pt-1">
        <input type="submit" name="submit" value="Update Permissions" class="btn btn-primary">
      </div>
    </form>
  </div>
</div>