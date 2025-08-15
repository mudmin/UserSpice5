<?php
$validation = new Validate();

if (!empty($_POST)) {
  $token = $_POST['csrf'];
  if (!Token::check($token)) {
    include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
  }

  if (!empty($_POST['createTag'])) {
    $tag = Input::get('tag');
    $check = $db->query("SELECT * FROM plg_tags WHERE tag = ?", [$tag])->count();
    if ($check > 0) {
      usError("A tag with that name already exists");
      Redirect::to("admin.php?view=permissions");
    } elseif (is_numeric($tag) || $tag == "") {
      usError("Tag name cannot be blank or a number");
      Redirect::to("admin.php?view=permissions");
    } else {
      $db->insert("plg_tags", ['tag' => $tag, 'descrip' => Input::get('descrip')]);
    
      $id = $db->lastId();  
   
      usSuccess("Tag created");
      Redirect::to("admin.php?view=permissions");
    }
  }



  //Create new permission level
  if (!empty($_POST['create'])) {
    $permission = Input::get('name');
    if ($permission != "") {
      $fields = array('name' => $permission, 'descrip' => Input::get('descrip'));
      $db->insert('permissions', $fields);
      usSuccess("Permission level created");
      logger($user->data()->id, "Permissions Manager", "Added Permission Level named $permission.");
    } else {
      usError("Permission name cannot be blank");
    }
    Redirect::to("admin.php?view=permissions");
  }


    usSuccess("Permissions updated");
    Redirect::to("admin.php?view=permission&manage=$manage");
  }



  $perms = $db->query("SELECT 
  permissions.id, 
  permissions.name, 
  permissions.descrip, 
  COUNT(user_permission_matches.permission_id) AS users
FROM 
  permissions
LEFT OUTER JOIN 
  user_permission_matches ON permissions.id = user_permission_matches.permission_id
GROUP BY 
  permissions.id, permissions.name
ORDER BY 
  permissions.id
")->results();


$tags = $db->query("SELECT 
    plg_tags.id, 
    plg_tags.tag, 
    plg_tags.descrip,
    COUNT(plg_tags_matches.tag_id) AS users
FROM 
    plg_tags
LEFT OUTER JOIN 
    plg_tags_matches ON plg_tags.id = plg_tags_matches.tag_id
GROUP BY 
    plg_tags.id, plg_tags.tag
ORDER BY 
    plg_tags.id
")->results();


?>

<div class="row">
  <div class="col-12 col-md-6">
  <h3 class="mb-2">Permission Levels</h3>
    <h5>Create Permission Level</h5>
    <form name='adminPermissions' action='' method='post'>
      <?= tokenHere(); ?>

      <div class="input-group">
        <input type='text' name='name' class="form-control" placeholder="Permission Name" / required>
        <input type="text" name="descrip" value="" class="form-control" placeholder="PermDescription">
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
          <th>Description</th>
          <th>Users</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($perms as $p) { ?>
          <tr>
            <td><?= $p->id ?></td>
            <td>
              <a href="?view=permission&manage=<?= $p->id ?>">
                <?= $p->name ?>
              </a>
            </td>
            <td>
              <?= $p->descrip ?>
            </td>
            <td>
              <?=$p->users?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <div class="col-12 col-md-6">
  <h3 class="mb-2">User Tags</h3>
  <h5>Create User Tag</h5>
        <form class="" action="" method="post">
          <?= tokenHere(); ?>
          <div class="input-group">
            <input type="text" name="tag" value="" class="form-control" placeholder="Tag Name" required>
            <input type="text" name="descrip" value="" class="form-control" placeholder="Tag Description">
            <input type="submit" name="createTag" value="Create" class="btn btn-primary">
          </div>
        </form>
       
    <h5 style="margin-top:2rem;">Existing User Tags
      <span style="font-size:.75rem"> (Click to manage)</span>
    </h5>
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tag</th>
          <th>Description</th>
          <th>Users</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tags as $p) { ?>
          <tr>
            <td><?= $p->id ?></td>
            <td>
              <a href="<?=$us_url_root?>users/admin.php?view=user_tags&manage=<?= $p->id ?>">
                <?= $p->tag ?>
              </a>
            </td>
            <td>
              <?= $p->descrip ?>
            </td>
            <td>
              <?= $p->users ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
      </div>
  </div>
  </div>
  