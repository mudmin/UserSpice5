<?php
// PHP Goes Here!
$hooks = getMyHooks(['page' => 'adminTags']);

$mt = Input::get("manage");
$tagQ = $db->query("SELECT * FROM plg_tags WHERE id = ?", [$mt]);
$tagC = $tagQ->count();
if ($tagC < 1) {
  usError("Tag not found");
  Redirect::to($us_url_root . "users/admin.php?view=permissions");
}
$tag = $tagQ->first();

if (!empty($_POST)) {

  if (!Token::check(Input::get('csrf'))) {
    include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
  }

  if (!empty($_POST['delete'])) {
    $tag = Input::get('tag');
    $db->query("DELETE FROM plg_tags WHERE id = ?", [$tag]);
    $db->query("DELETE FROM plg_tags_matches WHERE tag_id = ?", [$tag]);
    usSuccess("The tag has been deleted");
    Redirect::to($us_url_root . "users/admin.php?view=permissions");

  }

  if(!empty($_POST['rename'])){
    $orig = $tag;
    $tag = Input::get('tag');
    $check = $db->query("SELECT id FROM plg_tags WHERE tag = ? AND id != ?",[$tag,$mt])->count();
    if($check > 0){
      usError("That name is already in use");
      Redirect::to($us_url_root . "users/admin.php?view=user_tags&manage=".$mt);
    }else{
      $db->update("plg_tags",$mt,["tag"=>$tag, "descrip"=>Input::get('descrip')]);
      $db->query("UPDATE plg_tags_matches SET tag_name = ? WHERE tag_name = ?",[$tag,$orig->tag]);
      usSuccess("Tag updated");
        Redirect::to($us_url_root . "users/admin.php?view=user_tags&manage=".$mt);
    }
  }
}


$usersWithQ = $db->query("SELECT 
  m.*, 
  u.fname,u.lname,u.email 
  FROM plg_tags_matches m 
  INNER JOIN users u on m.user_id = u.id
  WHERE m.tag_id = ?", [$mt]);
$usersWithC = $usersWithQ->count();
$usersWith = $usersWithQ->results();

?>
<div class="content mt-3">
  <div class="row">
    <div class="col-12">
      <a href="<?= $us_url_root ?>users/admin.php?view=permissions" class="btn btn-outline-primary btn-sm mb-4">Return to Permissions & Tags</a>
      <h3 class="text-center">Manage the <?= $tag->tag ?> Tag</h3>
    </div>
  </div>

  <div class="row">

    <div class="col-12 col-md-6">
      <h5 class="mt-3">Update the <?= $tag->tag ?> Tag</h5>
      <form class="" action="" method="post">
        <?=tokenHere();?>
        <div class="form-group">
          <label for="tag">Tag Name</label>
          <input type="text" class="form-control" required name="tag" value="<?= $tag->tag ?>">
        </div>

        <div class="form-group">
          <label for="descrip">Description</label>
          <input type="text" class="form-control" name="descrip" value="<?= $tag->descrip ?>">
        </div>
        
     
          
          <input type="submit" name="rename" value="Update Tag" class="btn btn-primary">
   
      </form>
      <br>
      <h5>Delete the <?= $tag->tag ?> Tag</h5>
      <form class="" action="" method="post" onsubmit="return confirm('Are you sure? This will delete the tag and untag all users who had it! It cannot be undone!');">
         <?=tokenHere();?>
        <div class="input-group">
          <select class="form-control" name="tag">
            <option value="<?= $mt ?>"><?= $tag->tag ?></option>
          </select>
          <input type="submit" name="delete" value="Delete Tag" class="btn btn-danger">
        </div>
      </form>


    </div>

    <div class="col-12 col-md-6">

      <h5>Users with the <?= $tag->tag ?> Tag ( <?=$usersWithC?> )</h5>
      Visit the <a href="<?=$us_url_root?>users/admin.php?view=users" style="color:blue;">User Manager</a> to add or remove tags from a user.
      <?php if($usersWithC > 0) { ?>
   

      <table class="table table-striped table-hover paginate">
        <thead>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>View</th>
        </thead>
        <tbody>
          <?php foreach ($usersWith as $u) { ?>
            <tr>
              <td><?=$u->fname?></td>
              <td><?=$u->lname?></td>
              <td><?=$u->email?></td>
              <td>
                <a href="<?=$us_url_root?>users/admin.php?view=user&id=<?= $u->user_id ?>" class="btn btn-primary">View</a>

              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php }else{ ?>
      <h5 class="mt-4">No users have this tag</h5>
      <?php } ?>

    </div>
    <div class="col-12">
      <h3>Documentation</h3>

      <p> The UserSpice tagging system introduces a versatile feature to the individual user management interface, enabling the addition and removal of tags for users. Unlike traditional permissions, tags serve as a flexible method for categorizing users without automatically granting them specific system privileges. This functionality opens up a myriad of possibilities for organizing users. For instance, a user could be labeled as a "troublemaker," alerting the support team to monitor their activities more closely. Alternatively, tags can designate certain users with the capability to edit blog posts among other specific actions.</p>

      <p>
        Crucially, this system allows for the delegation of minor administrative tasks, such as tagging, to users with lower permission levels. This delegation can be achieved either through the interface or programmatically, ensuring that the ability to modify core permissions remains exclusively under the control of full administrators. As a result, the tagging system acts as a secure and controlled means of extending certain operational flexibilities without compromising the integrity of the permission structure.

      </p>

      <p>
        Moreover, when used in conjunction with the badges plugin, tags not only facilitate user management but also enhance the user experience by adding visual elements to profiles. This integration not only streamlines administration but also enriches the community aspect of the platform.
      </p>


      <br>
      <h5>Here are a few functions that will help with using these tags:</h5>
      <b>usersWithTag($tag)</b>: Returns an array of users with a tag. You can pass the id of the tag such as <b><em>usersWithTag(1)</em></b> or the case-sensitive name of the tag <b><em>usersWithTag("Manager")</em></b>.
      <br><br>
      <b>hasTag($tag,$user_id)</b>: Returns true or false depending on whether or not the specified user has that tag. Tag can be an id or the case-sensitive tag name.

      <br><br>
      <b>hasOneTag($tags, $user_id = "")</b>: Returns true if the user has one tag from an array of tags. If you specify the user id as the second parameter, it will use that id, otherwise, it will use the id of the loggded in user.

      <br><br>
      <b>hasAllTags($tags, $user_id = "")</b>: Returns true if the user has all tags in an array of tags. If you specify the user id as the second parameter, it will use that id, otherwise, it will use the id of the loggded in user.

      <br><br>
      <b>usersWithTag($tag)</b>: Returns an array of user ids with a given tag. The tag specified can either be the tag id or the tag name.

    </div>
  </div>