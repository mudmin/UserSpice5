<?php
$validation = new Validate();
$permission_exempt = array(1, 2);
$manage = Input::get('manage');


if (!empty($_POST)) {
  $token = $_POST['csrf'];
  if (!Token::check($token)) {
    include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
  }

  //Create new permission level
  if (!empty($_POST['create'])) {
    $permission = Input::get('name');
    if ($permission != "") {
      $fields = array('name' => $permission);
      $db->insert('permissions', $fields);
      usSuccess("Permission level created");
      logger($user->data()->id, "Permissions Manager", "Added Permission Level named $permission.");
    } else {
      usError("Permission name cannot be blank");
    }
    Redirect::to("admin.php?view=permissions");
  }

  if (!empty($_POST['rename'])) {
    $permission = Input::get('name');
    if ($permission != "") {
      $fields = array('name' => $permission);
      $db->update('permissions', $manage, $fields);
      usSuccess("Permission level renamed");
      logger($user->data()->id, "Permissions Manager", "Renamed permission level $manage to $permission");
    } else {
      usError("Permission name cannot be blank");
    }
    Redirect::to("admin.php?view=permissions&manage=$manage");
  }

  if (!empty($_POST['deleteButton'])) {
    $delete = Input::get('delete');
    if ($delete < 3) {
      usError("This Permission cannot be deleted");
    } else {
      $db->query("DELETE FROM permissions WHERE id = ?", [$manage]);
      $db->query("DELETE FROM user_permission_matches WHERE permission_id = ?", [$manage]);
      logger($user->data()->id, "Permissions Manager", "Deleted permission level $manage");
      usSuccess("Permission level deleted");
    }
    Redirect::to("admin.php?view=permissions");
  }

  if (!empty($_POST['updatePerms'])) {
    $add = Input::get('add');
    $remove = Input::get('remove');
    if (is_array($add)) {
      foreach ($add as $a) {
        $fields = [
          'user_id' => $a,
          'permission_id' => $manage,
        ];
        $db->insert("user_permission_matches", $fields);
      }
    }

    if ($manage != 1 && is_array($remove)) {
      foreach ($remove as $r) {
        $db->query("DELETE FROM user_permission_matches WHERE user_id = ? AND permission_id = ?", [$r, $manage]);
      }
    }

    usSuccess("Permissions updated");
    Redirect::to("admin.php?view=permissions&manage=$manage");
  }
}


$perms = $db->query("SELECT * FROM permissions ORDER BY name")->results();
$userCount = $db->query("SELECT id FROM users")->count();
?>

<div class="row">
  <div class="col-12 col-sm-6">
    <h3>Permission Levels</h3>
  </div>
  <div class="col-12 col-sm-6">
    <form class="" action="" method="post" onsubmit="return confirm('Do you really want to do this? It cannot be undone.');">
      <?= tokenHere(); ?>
      <p class=" text-xs-center text-sm-end">
        <input type="hidden" name="delete" value="<?=$manage?>">
        <?php if ($manage == 1 || $manage == 2) { ?>
          <button type="button" name="button" class="btn btn-secondary">Cannot be Deleted</button>
        <?php } else { ?>
          <input type="submit" name="deleteButton" value="Delete Permission Level" class="btn btn-danger">
        <?php } ?>
      </p>
    </form>
  </div>
</div>

<div class="row">
  <div class="col-12 col-md-6">
    <h5>Create Permission Level</h5>
    <form name='adminPermissions' action='' method='post'>
      <?= tokenHere(); ?>

      <div class="input-group">
        <input type='text' name='name' class="form-control" placeholder="Permission Name" />
        <input class='btn btn-primary' type='submit' name='create' value='Create' />
      </div>
    </form>
    <h5 style="margin-top:2rem;">Existing Permissions
      <span style="font-size:.75rem"> (Click to manage)</span>
    </h5>

    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Permission</th>
          <th>Users</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($perms as $p) { ?>
          <tr>
            <td><?= $p->id ?></td>
            <td>
              <a href="?view=permissions&manage=<?= $p->id ?>">
                <?= $p->name ?>
              </a>
            </td>
            <td>
              <?= $db->query("SELECT id FROM user_permission_matches WHERE permission_id = ?", [$p->id])->count(); ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <div class="col-12 col-md-6">
    <h5>Manage the Permission Level</h5>
    <?php
    $q = $db->query("SELECT * FROM permissions WHERE id = ?", [$manage]);
    $c = $q->count();
    if ($c > 0) {
      $perm = $q->first();
      $usersQ = $db->query("SELECT u.id,u.fname, u.lname, u.email,
            CASE WHEN p.permission_id is null THEN 0 ELSE 1 END AS hasPerm
            FROM users AS u
            LEFT JOIN user_permission_matches AS p ON p.user_id = u.id AND p.permission_id = ?
            GROUP BY u.id
            ", [$manage]);

      $usersC = $usersQ->count();
      if ($usersC <= 5000) {
        $users = $usersQ->results();
      }
    ?>

      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-12">
              <form class="" action="" method="post">
                <?= tokenHere(); ?>
                <div class="input-group">
                  <input type="text" name="name" value="<?= $perm->name ?>" class="form-control" required>
                  <input type="submit" name="rename" value="Rename" class="btn btn-primary">
                </div>
              </form>
            </div>

          </div>
          <?php if ($manage == 1 || $manage == 2) { ?>
            <small class="mb-3">Although you can rename the Admin and User permissions, please do not attempt to change their purpose. Permission 1 is the permission every user gets. You cannot remove this permission. Permission 2 should be reserved for Administrators. These permissions cannot be deleted.</small>
          <?php } ?>
        </div>
        <?php if ($usersC <= 5000) { ?>
          <form class="" action="" method="post">
            <?= tokenHere(); ?>
            <p class="text-center mt-3">
              <input type="submit" name="updatePerms" value="Update Permissions" class="btn btn-outline-primary">
            </p>
            <div class="row mt-3">
              <div class="col-12 col-lg-6">
                <h6>Users with this permission
                  <?php if ($manage != 1) { ?><small class="mt-0">(Check to remove)</small>
                  <?php } ?>
                </h6>

                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>
                        <?php if ($manage != 1) { ?>
                          <input type="checkbox" class="removeAll">
                        <?php } ?>
                      </th>
                      <th>Last</th>
                      <th>First</th>
                      <th>Email</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($users as $u) {
                      if ($u->hasPerm != 1) {
                        continue;
                      } ?>
                      <tr>
                        <td>
                          <?php if ($manage != 1) { ?>
                            <input type="checkbox" name="remove[]" class="remove" value="<?= $u->id ?>">
                          <?php } ?>
                        </td>
                        <td><?= $u->lname ?></td>
                        <td><?= $u->fname ?></td>
                        <td><?= $u->email ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="col-12 col-lg-6">
                <h6>Users without this permission <small class="mt-0">(Check to add)</small></h6>

                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>
                        <input type="checkbox" class="addAll">
                      </th>
                      <th>Last</th>
                      <th>First</th>
                      <th>Email</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($users as $u) {
                      if ($u->hasPerm != 0) {
                        continue;
                      } ?>
                      <tr>
                        <td><input type="checkbox" name="add[]" class="add" value="<?= $u->id ?>"></td>
                        <td><?= $u->lname ?></td>
                        <td><?= $u->fname ?></td>
                        <td><?= $u->email ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </form>
      <?php
        } else {
          echo "<b>User management on this page is disabled because you have more than 5000 users</b>";
        }
      }
      ?>

      </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('.addAll').on('click', function(e) {
      $('.add').prop('checked', $(e.target).prop('checked'));
    });

    $('.removeAll').on('click', function(e) {
      $('.remove').prop('checked', $(e.target).prop('checked'));
    });
  }); //End Document Ready Function
</script>
