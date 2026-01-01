<?php
$hooks = getMyHooks(['page' => 'admin.php?view=permission']);
includeHook($hooks, 'pre');
$validation = new Validate();
$permission_exempt = array(1, 2);
$manage = Input::get('manage');

if (is_numeric($manage)) {
    if ($db->query("SELECT id FROM permissions WHERE id = ?", [$manage])->count() < 1) {
        usError("Permission not found");
        Redirect::to("admin.php?view=permissions");
    }
}

if (!empty($_POST)) {
    $token = $_POST['csrf'];
    if (!Token::check($token)) {
        include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
    }
     includeHook($hooks, 'post');

    if (!empty($_POST['updatePages'])) {
        $add = Input::get('add');
        $remove = Input::get('remove');
        if ($remove != '') {
            foreach ($remove as $r) {
                $db->query('DELETE FROM permission_page_matches WHERE page_id = ? AND permission_id = ?', [$r, $manage]);
                usSuccess("Page id $r removed from permission level $manage");
                logger($user->data()->id, 'Permissions Manager', "Removed page id $r from permission level $manage");
            }
        }

        if ($add != '') {
            foreach ($add as $r) {
                $fields = [
                    'page_id' => $r,
                    'permission_id' => $manage,
                ];
                $db->insert('permission_page_matches', $fields);

                usSuccess("Page id $r added to permission level $manage");
                logger($user->data()->id, 'Permissions Manager', "Added page id $r to permission level $manage");
            }
        }

        if ($add != '' || $remove != '') {
            Redirect::to('admin.php?view=permission&manage=' . $manage);
        }
    }


    if (!empty($_POST['rename'])) {
        $permission = Input::get('name');
        if ($permission != "") {
            $fields = array('name' => $permission, 'descrip' => Input::get('descrip'));
            $db->update('permissions', $manage, $fields);
            usSuccess("Permission level renamed");
            logger($user->data()->id, "Permissions Manager", "Renamed permission level $manage to $permission");
        } else {
            usError("Permission name cannot be blank");
        }
        Redirect::to("admin.php?view=permission&manage=$manage");
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
        Redirect::to("admin.php?view=permission&manage=$manage");
    }
}


$perms = $db->query("SELECT * FROM permissions ORDER BY id")->results();
$userCount = $db->query("SELECT COUNT(id) as count FROM users")->first()->count;

$maxUsers = 5000;
includeHook($hooks, 'body');
?>


<div class="row">
<div class="col-6">
<a href="<?= $us_url_root ?>users/admin.php?view=permissions" class="btn btn-outline-primary btn-sm mb-4">Return to Permissions & Tags</a>
</div>
<div class="col-6 text-end">
        <?php
            if (isset($manage) && is_numeric($manage)) { ?>
            <form class="" action="" method="post" onsubmit="return confirm('Do you really want to do this? It cannot be undone.');">
                <?= tokenHere(); ?>
                <p class=" text-xs-center text-sm-end">
                    <input type="hidden" name="delete" value="<?= $manage ?>">
                    <?php if ($manage == 1 || $manage == 2) { ?>
                        <button type="button" name="button" class="btn btn-secondary">Cannot be Deleted</button>
                    <?php } else { ?>
                        <input type="submit" name="deleteButton" value="Delete Permission Level" class="btn btn-danger">
                    <?php } ?>
                </p>
            </form>
        <?php } ?>
    </div>
</div>

    <div class="col-12">

      
        <h5>Manage the Permission Level</h5>
        <?php
        $q = $db->query("SELECT * FROM permissions WHERE id = ?", [$manage]);
        $c = $q->count();
        if ($c > 0) {
            $perm = $q->first();
            // Check user count BEFORE running the expensive join query
            if ($userCount <= $maxUsers) {
                $usersQ = $db->query("SELECT u.id,u.fname, u.lname, u.email,
                CASE WHEN p.permission_id is null THEN 0 ELSE 1 END AS hasPerm
                FROM users AS u
                LEFT JOIN user_permission_matches AS p ON p.user_id = u.id AND p.permission_id = ?
                GROUP BY u.id
                ", [$manage]);
                $users = $usersQ->results();
            }
        ?>



            <form class="" action="" method="post">
                <?= tokenHere(); ?>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <label for="name">Permission Name</label>
                        <input type="text" name="name" value="<?= $perm->name ?>" class="form-control" required>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="name">Permission Description</label>
                        <input type="text" name="descrip" value="<?= $perm->descrip ?>" class="form-control">
                    </div>
                    <?php 
                    includeHook($hooks, 'form');
                    ?>
                    <div class="col-12 col-md-4">



                        <label for="" class="mt-5"></label>
                        <input type="submit" name="rename" value="Update Name and Description" class="btn btn-primary">
                        <?php if ($manage == 1 || $manage == 2) { ?>
                            <br>
                            <small class="mb-3">Although you can rename the Admin and User permissions, please do not attempt to change their purpose. Permission 1 is the permission every user gets. You cannot remove this permission. Permission 2 should be reserved for Administrators. These permissions cannot be deleted.</small>
                            <div class="mb-2"></div>
                        <?php } ?>
                    </div>
                </div>
            </form>


    </div>


<?php if ($userCount <= $maxUsers) { ?>

    <h3 class="text-center">User Permissions</h3>
    <form class="" action="" method="post">
        <?= tokenHere(); ?>
        <p class="text-center mt-3">
            <input type="submit" name="updatePerms" value="Update User Permissions" class="btn btn-primary">
        </p>
        <div class="row mt-3">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Users with this permission
                            <?php if ($manage != 1) { ?><small class="mt-0">(Check to remove)</small>
                            <?php } ?>
                        </h5>
                    </div>
                    <div class="card-body">
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
                </div>



            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Users without this permission<small class="mt-0">(Check to add)</small></h5>
                    </div>

                    <div class="card-body">
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

            </div>
        </div>
    </form>
<?php
            } else { ?>
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    <div>
                        <strong>User management disabled</strong><br>
                        This feature is unavailable because you have more than <?= number_format($maxUsers) ?> users (current: <?= number_format($userCount) ?>).
                    </div>
                </div>
            <?php }
        }
?>

</div>
</div>

<?php
if (is_numeric($manage)) {
    //we've already verified that the permission level exists, so we don't need to bind it.
    $pages = $db->query("SELECT p.*, m.id as perm_id
  FROM pages AS p
  LEFT OUTER JOIN permission_page_matches AS m on m.page_id = p.id AND m.permission_id = $manage
  ORDER BY page")->results();

?>
    <form class="" action="" method="post">
        <?= tokenHere(); ?>

        <hr>
        <div class="row">
            <div class="col-12">
                <h3 class="text-center">Page Permissions</h3>
                <h5 class="text-center">
                    <input type="submit" name="updatePages" value="Update Page Permissions" class="btn btn-primary">
                </h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Pages with this permission<small>(Check to remove)</small></h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Page</th>
                                    <th>Description</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pages as $p) {
                                    if ($p->perm_id == "") {
                                        continue;
                                    }
                                ?>
                                    <tr>
                                        <td><?= $p->id ?></td>
                                        <td><?= $p->page ?></td>
                                        <td><?= $p->title ?></td>
                                        <td>
                                            <input type="checkbox" name="remove[<?= $p->id ?>]" value="<?= $p->id ?>">
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>

            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Pages withput this permission<small>(Check to add)</small></h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Page</th>
                                    <th>Description</th>
                                    <th>Add</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pages as $p) {
                                    if ($p->perm_id != "") {
                                        continue;
                                    }
                                ?>
                                    <tr>
                                        <td><?= $p->id ?></td>
                                        <td><?= $p->page ?></td>
                                        <td><?= $p->title ?></td>
                                        <td>
                                            <input type="checkbox" name="add[<?= $p->id ?>]" value="<?= $p->id ?>">
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </form>
<?php 
    includeHook($hooks, 'bottom');
    } 
?>
<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">
    $(document).ready(function() {
        $('.addAll').on('click', function(e) {
            $('.add').prop('checked', $(e.target).prop('checked'));
        });

        $('.removeAll').on('click', function(e) {
            $('.remove').prop('checked', $(e.target).prop('checked'));
        });
    }); //End Document Ready Function
</script>