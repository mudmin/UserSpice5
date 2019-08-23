<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <ol class="breadcrumb text-right">
          <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
          <li>Manage</li>
          <li class="active">Dashboard Access</li>
        </ol>
      </ol>
    </div>
  </div>
</div>
</div>
</header>
<style media="screen">

input[type=checkbox]
{
/* Double-sized Checkboxes */
-ms-transform: scale(2); /* IE */
-moz-transform: scale(2); /* FF */
-webkit-transform: scale(2); /* Safari and Chrome */
-o-transform: scale(2); /* Opera */
padding: 10px;
}
</style>
<div class="content mt-3">
<?php
if(!in_array($user->data()->id, $master_account)){Redirect::to('admin.php');}
$features = $db->query("SELECT DISTINCT feature, access FROM us_management ORDER BY feature")->results();
$adminID = $db->query("SELECT id FROM pages WHERE page = ?",["users/admin.php"])->first();
$matches = $db->query("SELECT * FROM permission_page_matches WHERE page_id = ? AND (permission_id != 1 AND permission_id != 2)",[$adminID->id])->results();
$perms = [];
foreach($matches as $m){
  $name = $db->query("SELECT name from permissions WHERE id = ?",[$m->permission_id])->first();
  $perms[$m->permission_id] = $name->name;
}

if(!empty($_POST)){
  $token = $_POST['csrf'];
  if(!Token::check($token)){
    include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
  }
foreach($features as $f){
  $pages = $db->query("SELECT * FROM us_management WHERE feature = ?",[$f->feature])->results();
  $str = str_replace(" ","_",$f->feature);
  foreach($pages as $p){
    if(isset($_POST[$str])){
    $implode = implode(",",$_POST[$str]);
    $db->update('us_management',$p->id,['access'=>$implode]);
  }else{
    $db->update('us_management',$p->id,['access'=>""]);
  }
  }
}
Redirect::to('admin.php?view=access&err=Updated');
}
$token = Token::generate();
?>

<h2>Grant Dashboard Access</h2>
<p>Please Note:  Allowing users other than trusted admins should not be taken lightly. You are giving these users the opportunity to do some very
powerful things to your site.</p>
<p>This is a TWO step process.  You must go into Page Management and allow the other access level(s) that you want to give access to, permission
to access the admin.php page.  Then you can come in here and grant that access level permission to a particular section of the dashboard.
Please note, some actions are limited by default to users of the master account or admins (permission level 2) and cannot be overriden on this
page. You have been warned!</p>
<form class="" action="" method="post">
<input type="hidden" name="csrf" value="<?=$token?>" />
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Feature</th><th class="text-right">
        <input type="submit" name="submit" value="Update Permissions" class="btn btn-primary">
      </th>
    </tr>
    <tbody>
      <?php foreach($features as $f){
        $row = explode(",",$f->access);
        ?>
        <tr>
          <td><?=$f->feature?></td>
            <?php foreach($perms as $key=>$value){?>
              <td class="text-center">
              <input class="" type="checkbox" name="<?=$f->feature?>[]" value="<?=$key?>" <?php if(in_array($key,$row)){echo "checked";}?>><br><?=$value?>
              </td>
            <?php } ?>

        </tr>
      <?php } ?>
    </tbody>
  </thead>
</table>
<p class="text-right">  <input type="submit" name="submit" value="Update Permissions" class="btn btn-primary"></p>
</form>
</div>
