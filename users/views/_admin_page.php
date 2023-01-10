<?php
// PHP Goes Here!
$hooks = getMyHooks(['page' => 'adminPage']);
$pageId = Input::get('id');
$errors = [];
$successes = [];

// Check if selected pages exist
if (!pageIdExists($pageId)) {
  Redirect::to($us_url_root . 'users/admin.php?view=pages');
  exit();
}

$pageDetails = fetchPageDetails($pageId); // Fetch information specific to page

// Forms posted
if (Input::exists()) {
  $token = Input::get('csrf');
  if (!Token::check($token)) {
    include $abs_us_root . $us_url_root . 'usersc/scripts/token_error.php';
  }
  $update = 0;

  if (!empty($_POST['private'])) {
    $private = Input::get('private');
  }

  // Toggle private page setting
  if (isset($private) and $private == 1) {
    if ($pageDetails->private == 0) {
      if (updatePrivate($pageId, 1)) {
        $successes[] = lang('PAGE_PRIVATE_TOGGLED', ['private']);
        logger($user->data()->id, 'Pages Manager', "Changed private from public to private for Page #$pageId.");
      } else {
        usError(lang('SQL_ERROR'));
      }
    }
  }

  if (isset($private) and $private == 0) {
    if ($pageDetails->private == 1) {
      if (updatePrivate($pageId, 0)) {
        $successes[] = lang('PAGE_PRIVATE_TOGGLED', ['private']);
        logger($user->data()->id, 'Pages Manager', "Changed private from private to public for Page #$pageId.");
      } else {
        usError(lang('SQL_ERROR'));
      }
    }
  }



  // Remove permission level(s) access to page
  if (!empty($_POST['removePermission'])) {
    $remove = Input::get('removePermission');
    if ($deletion_count = removePage($pageId, $remove)) {
      $successes[] = lang('PAGE_ACCESS_REMOVED', [$deletion_count]);
      logger($user->data()->id, 'Pages Manager', "Deleted $deletion_count permission(s) from $pageDetails->page.");
    } else {
      usError(lang('SQL_ERROR'));
    }
  }

  // Add permission level(s) access to page
  if (!empty($_POST['addPermission'])) {
    $add = Input::get('addPermission');
    $addition_count = 0;
    foreach ($add as $perm_id) {
      if (addPage($pageId, $perm_id)) {
        ++$addition_count;
      }
    }
    if ($addition_count > 0) {
      $successes[] = lang('PAGE_ACCESS_ADDED', [$addition_count]);
      logger($user->data()->id, 'Pages Manager', "Added $addition_count permission(s) to $pageDetails->page.");
    }
  }

  // Changed title for page
  if ($_POST['changeTitle'] != $pageDetails->title) {
    $newTitle = Input::get('changeTitle');
    if ($db->query('UPDATE pages SET title = ? WHERE id = ?', [$newTitle, $pageDetails->id])) {
      $successes[] = lang('PAGE_RETITLED', [$newTitle]);
      logger($user->data()->id, 'Pages Manager', "Retitled '{$pageDetails->page}' to '$newTitle'.");
    } else {
      usError(lang('SQL_ERROR'));
    }
  }
  includeHook($hooks, 'post');
  $pageDetails = fetchPageDetails($pageId);
  if (isset($_SESSION['redirect_after_save']) && $_SESSION['redirect_after_save'] == true) {
    if (!empty($_SESSION['redirect_after_uri'])) {
      $redirect_uri = $_SESSION['redirect_after_uri'];
      unset($_SESSION['redirect_after_save']);
      unset($_SESSION['redirect_after_uri']);
      Redirect::to(html_entity_decode($redirect_uri));
    }
  }
  if (Input::get('return') != '' && $errors == []) {
    Redirect::to('admin.php?view=pages');
  }
}
$pagePermissions = fetchPagePermissions($pageId);
$permissionData = fetchAllPermissions();
$countQ = $db->query('SELECT id, permission_id FROM permission_page_matches WHERE page_id = ? ', [$pageId]);
$countCountQ = $countQ->count();
?>
<form action='' method='post'>
  <?= tokenHere(); ?>
  <h2>Page Permissions</h2>
  <div class="row">
    <div class="col-12 col-sm-6">
      <h4><span style="color:blue;"><?= $pageDetails->page; ?></span></h4>
      <h5>Page ID: <?= $pageDetails->id ?></h5>
    </div>
    <div class="col-12 col-sm-6">
      <span class="float-end">
        <a class='btn btn-warning' href="<?php echo $us_url_root; ?>users/admin.php?view=pages">Cancel</a>
        <input class='btn btn-secondary' name="return" type='submit' value='Update & Close' class='submit' />
        <input class='btn btn-primary' type='submit' value='Update' class='submit' />
      </span>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-sm-6">
      <div class="form-group">
        <label for="title">Page Title:</label> <span class="small">(This is the text that's displayed on the browser's titlebar or tab)</span>

        <input type="text" class="form-control" name="changeTitle" maxlength="50" value="<?php echo $pageDetails->title; ?>" />
      </div>
      <div class="form-group">
        <label for="">Set this page as private?</label>
        <select class="form-control mb-2" name="private" required>
          <option value="0" <?php if ($pageDetails->private == 0) {
                              echo "selected='selected'";
                            } ?>>This Page is Public</option>
          <option value="1" <?php if ($pageDetails->private == 1) {
                              echo "selected='selected'";
                            } ?>>This Page is Private (Protected)</option>
        </select>
        <p>Marking a page as 'private' will cause UserSpice to protect this page with the securePage function that is at the top of every page. Please also note that the folder this page resides in must also be set on the <a href="admin.php?view=pages">Admin Pages</a> dashboard. Marking it public will allow the page to be visible to all site visitors.</p>
      </div>
      <?php
      includeHook($hooks, 'form');
      ?>

    </div>
    <div class="col-12 col-md-3">
      <label for="">Remove Permission</label>
      <div class="form-group">
        <?php
        // Display list of permission levels with access
        $perm_ids = [];
        foreach ($pagePermissions as $perm) {
          $perm_ids[] = $perm->permission_id;
        }
        foreach ($permissionData as $v1) {
          if (in_array($v1->id, $perm_ids)) { ?>
            <label class="normal"><input type='checkbox' name='removePermission[]' id='removePermission[]' value='<?php echo $v1->id; ?>'> <?php echo $v1->name; ?></label><br />
        <?php }
        } ?>
      </div>
    </div>

    <div class="col-12 col-md-3">
      <label for="">Add Permissions</label>
      <div class="form-group">
        <?php
        // Display list of permission levels without access
        foreach ($permissionData as $v1) {
          if (!in_array($v1->id, $perm_ids)) { ?>
            <?php if ($settings->page_permission_restriction == 0) { ?><label class="normal"><input type='checkbox' name='addPermission[]' id='addPermission[]' value='<?php echo $v1->id; ?>'> <?php echo $v1->name; ?></label><br /><?php } ?>

            <?php if ($settings->page_permission_restriction == 1) { ?><label class="normal"><input type="radio" name="addPermission[]" id="addPermission[]" value="<?php echo $v1->id; ?>" <?php if ($countCountQ > 0 || $pageDetails->private == 0) { ?> disabled <?php } ?>>
                <?php echo $v1->name; ?></label><br />
        <?php }
          }
        }
        ?>
      </div>
    </div>
  </div>
  </div>
</form>