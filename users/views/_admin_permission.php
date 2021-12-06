<?php
$validation = new Validate();
//PHP Goes Here!
$permissionId = Input::get('id');
$query = htmlspecialchars(Input::get('query'));
$permission_exempt = array(1,2);
$errors = [];
$successes = [];
$searchC = 0;

//Check if selected permission level exists
if(!permissionIdExists($permissionId)){
  Redirect::to($us_url_root.'users/admin.php?view=permissions'); die();
}

//Fetch information specific to permission level
$permissionDetails = fetchPermissionDetails($permissionId);
//Forms posted
if(!empty($_POST)){
  $token = $_POST['csrf'];
  if(!Token::check($token)){
    include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
  }
  if(!empty($_POST['permChange'])){
    $permChange = Input::get('permChange');
    $user_id = Input::get('user');
    if($permChange == 'Add'){
      $fields = array(
        'user_id'=>$user_id,
        'permission_id'=>$permissionId
      );
      $db->insert('user_permission_matches',$fields);
    }

    if($permChange == 'Remove'){
      if(!in_array($user_id,$master_account)){
        $checkQ = $db->query("SELECT id FROM user_permission_matches WHERE user_id = ? AND permission_id = ?",array($user_id,$permissionId));
        $checkC = $checkQ->count();
        if($checkC > 0){
          $check = $checkQ->results();
          foreach($check as $c){
            $db->query("DELETE FROM user_permission_matches WHERE id = ?",array($c->id));
          }
        }
      }
    }
  }
  //Delete selected permission level
  if(!empty($_POST['delete'])){
    if(!in_array($permissionId,$permission_exempt)){
      $deletions = $_POST['delete'];
      if ($deletion_count = deletePermission($deletions)){
        $successes[] = lang("PERMISSION_DELETIONS_SUCCESSFUL", array($deletion_count));
        $name = $permissionDetails['name'];
        logger($user->data()->id,"Permissions Manager","Deleted $name.");
        usSuccess("Permission deleted");
        Redirect::to($us_url_root.'users/admin.php?view=permissions');
      }
      else {
        $errors[] = lang("SQL_ERROR");
      }
    }
  }
  if(!empty($_POST['name'])){
    //Update permission level name
    if($permissionDetails['name'] != $_POST['name']) {
      $permission = Input::get('name');
      $fields=array('name'=>$permission);
      //NEW Validations
      $validation->check($_POST,array(
        'name' => array(
          'display' => 'Permission Name',
          'required' => true,
          'unique' => 'permissions',
          'min' => 1,
          'max' => 25
        )
      ));
      if($validation->passed()){
        $db->update('permissions',$permissionId,$fields);
        $successes[] = "Updated Permission Name";
        $name = $permissionDetails['name'];
        logger($user->data()->id,"Permissions Manager","Changed Permission Name from $name to $permission.");
      }else{
      }
    }

    //Remove access to pages
    if(!empty($_POST['removePermission'])){
      $remove = $_POST['removePermission'];
      if ($deletion_count = removePermission($permissionId, $remove)) {
        $successes[] = lang("PERMISSION_REMOVE_USERS", array($deletion_count));
        logger($user->data()->id,"Permission Manager","Deleted $deletion_count users(s) from Permission #$permissionId.");
      }
      else {
        $errors[] = lang("SQL_ERROR");
      }
    }

    //Add access to pages
    if(!empty($_POST['addPermission'])){
      $add = $_POST['addPermission'];
      if ($addition_count = addPermission($permissionId, $add)) {
        $successes[] = lang("PERMISSION_ADD_USERS", array($addition_count));
        logger($user->data()->id,"Permission Manager","Added $addition_count users(s) to Permission #$permissionId.");
      }
      else {
        $errors[] = lang("SQL_ERROR");
      }
    }

    //Remove access to pages
    if(!empty($_POST['removePage'])){
      $remove = $_POST['removePage'];
      if ($deletion_count = removePage($remove, $permissionId)) {
        $successes[] = lang("PERMISSION_REMOVE_PAGES", array($deletion_count));
        logger($user->data()->id,"Permission Manager","Deleted $deletion_count pages(s) from Permission #$permissionId.");
      }
      else {
        $errors[] = lang("SQL_ERROR");
      }
    }

    //Add access to pages
    if(!empty($_POST['addPage'])){
      $add = $_POST['addPage'];
      if ($addition_count = addPage($add, $permissionId)) {
        $successes[] = lang("PERMISSION_ADD_PAGES", array($addition_count));
        logger($user->data()->id,"Permission Manager","Added $addition_count pages(s) to Permission #$permissionId.");
      }
      else {
        $errors[] = lang("SQL_ERROR");
      }
    }
    $permissionDetails = fetchPermissionDetails($permissionId);
  }
}

//Retrieve list of accessible pages
$pagePermissions = fetchPermissionPages($permissionId);




//Retrieve list of users with membership
$permissionUsers = fetchPermissionUsers($permissionId);
// dump($permissionUsers);

//Fetch all users
$userData = fetchAllUsers();


//Fetch all pages
$pageData = fetchAllPages();
if($query != ''){
  if($query == '*'){
    $search = $db->query("SELECT id,username,fname,lname,email FROM users LIMIT 100");
  }else{
    $search = $db->query("SELECT id,username,fname,lname,email FROM users WHERE id LIKE '%$query%' OR username LIKE '%$query%' OR fname LIKE '%$query%' OR lname LIKE '%$query%' OR email LIKE '%$query%' LIMIT 100");
  }
  $searchC = $search->count();
  $results = $search->results();

}
$token = Token::generate();
?>
<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
        <li>Manage</li>
        <li><a href="<?=$us_url_root?>users/admin.php?view=permissions">Permission Levels</a></li>
        <li class="active"><?=$permissionDetails['name']?></li>
      </ol>
    </div>
  </div>
</div>
</div>
</header>
<div class="content mt-3">
  <?php if(!$validation->errors()=='') { display_errors($validation->errors()); } ?>
  <?php echo resultBlock($errors,$successes); ?>

  <h2>Configure Details for Permission Level: <?=$permissionDetails['name']?></h2><br>
  <?php if($permissionId == 1 || $permissionId  == 2){ ?>
    <b>
      <span style="color:red">WARNING:</span>
    </b>
    Although you can rename this permission level, please do not try to change its purpose.  #1 is the default "User" permission for all users and #2 is the "Admin"
    permission. Changing the purpose of these permissions <b>WILL</b> break things.<br><br>
  <?php } ?>
  <form name='adminPermission' action='' method='post'>
    <div class="row">
      <div class="col-sm-12">
        <h3>Permission ID - <?=$permissionDetails['id']?></h3>
        <p>
          <strong>Note:</strong>This permission id is used in functions like <strong>hasPerm</strong> and is how you refer to the permission when coding.
        </p>
      </div>
      </div>
      <div class="row">
      <div class="col-md-6">
        <h3>Delete this Level?</h3>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="<?=$permissionDetails['id']?>" id="delete[<?=$permissionDetails['id']?>]" name='delete[<?=$permissionDetails['id']?>]'>
          <label class="form-check-label" for="delete[<?=$permissionDetails['id']?>]">
            Delete Level <?=$permissionDetails['name']?> (<strong class="text-default">irreversable</strong>)
          </label>
        </div>
      </div>
      <div class="col-md-6">
        <h3>Change Permission Name</h3>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text form-control" id="name-label">Change Name</span>
        </div>
        <input type="text" class="form-control" aria-describedby="name-label" name="name" value='<?=$permissionDetails['name']?>' required>
      </div>


</div>
    </div>
    <hr />
    <div class="row">
      <input type="hidden" name="csrf" value="<?=$token?>" >
      <div class="col-md-12"><h3>Manage</h3></div>

      <div class="col-md-2 mt-2">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <a class="nav-link active" id="ManageUsers" data-toggle="pill" href="#ManageUsersTab" role="tab" aria-controls="ManageUsersTab" aria-selected="true">Manage Users</a>
          <a class="nav-link" id="RemovePages" data-toggle="pill" href="#RemovePagesTab" role="tab" aria-controls="RemovePagesTab" aria-selected="false">Remove Pages</a>
          <a class="nav-link" id="AddPages" data-toggle="pill" href="#AddPagesTab" role="tab" aria-controls="AddPagesTab" aria-selected="false">Add Pages</a>
          <a class="nav-link" id="PublicPages" data-toggle="pill" href="#PublicPagesTab" role="tab" aria-controls="PublicPagesTab" aria-selected="false">Public Pages</a>
        </div>
        <div class="text-center">
          <hr />
          <a class='btn btn-warning' href="../users/admin.php?view=permissions">Cancel</a>
          <button class='btn btn-primary' type='submit' value='Update Permission'>Update</button>
        </div>
      </div>
      <div class="col-md-10 mt-2">
        <div class="tab-content" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="ManageUsersTab" role="tabpanel" aria-labelledby="ManageUsers">
            <h3>Manage Users</h3>
            <form class="" action="" method="get">
              <strong>Find user(s) to manage</strong>
              <div class="input-group">
                <input type="hidden" name="view" value="permission">
                <input type="hidden" name="id" value="<?=$permissionId?>">
                <input type="text" name="query" class="form-control" placeholder="Search by ID, First Name, Last Name, Username, or Email">
                <span class="input-group-btn">
                  <input type="submit" name="Submit" value="Search" class="btn btn-primary">
                </span>
              </div>
              <strong>Note: </strong>You can also enter * to get all users
            </form>
            <?php
            if($query != '' && $searchC == 0){
              echo "The search returned 0 results";
            }
            if($query != '' && $searchC > 0){
              if($searchC == 100){
                echo "Note that the maximum number of results was returned, so you may wish to make your search term more specific.<br>";
              }?>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>ID</th><th>Username</th><th>Name</th><th>Email</th><th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($results as $r){ ?>
                    <tr>
                      <td><?=$r->id?></td>
                      <td><?=$r->username?></td>
                      <td><?=$r->fname?> <?=$r->lname?></td>
                      <td><?=$r->email?></td>
                      <td>
                        <?php
                        if(!in_array($r->id,$master_account)){
                          ?>
                          <form class="" action="" method="post">
                            <input type="hidden" name="user" value="<?=$r->id?>">
                            <input type="hidden" name="csrf" value="<?=$token?>" >
                            <?php
                            $count = $db->query("SELECT id FROM user_permission_matches WHERE user_id = ? AND permission_id = ?",array($r->id,$permissionId))->count();

                            if($count > 0){ ?>
                              <input type="submit" name="permChange" value="Remove" class="btn btn-danger btn-block">
                            <?php }else{ ?>
                              <input type="submit" name="permChange" value="Add" class="btn btn-success btn-block">
                            <?php } ?>
                          </form>
                        <?php }else{ ?>
                          <button type="button" name="button" class="btn btn-default btn-block">Master Acct</button>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            <?php } ?>
          </div>
          <div class="tab-pane fade" id="RemovePagesTab" role="tabpanel" aria-labelledby="RemovePages">
            <h3>Remove Pages <input type="checkbox" value="1" id="removeAll"></h3>
            <strong>Remove these pages from <?php echo ucfirst($permissionDetails['name']);?></strong>
            <?php
            //Display list of pages with this access level
            $page_ids = [];
            foreach($pagePermissions as $pp){
              $page_ids[] = $pp->page_id;
            }
            foreach ($pageData as $v1){
              if(in_array($v1->id,$page_ids)){ ?>
                <br><label class="normal"><input type='checkbox' name='removePage[]' class='removePage' id='removePage[]' value='<?=$v1->id;?>'> <?=$v1->page;?></label>
              <?php }
            }  ?>
          </div>
          <div class="tab-pane fade" id="AddPagesTab" role="tabpanel" aria-labelledby="AddPages">
            <h3>Add Pages <input type="checkbox" value="1" id="addAll"></h3>

            <strong>Add these pages to <?php echo ucfirst($permissionDetails['name']);?></strong>
            <?php
            //Display list of pages with this access level

            foreach ($pageData as $v1){
              if($settings->page_permission_restriction == 1) {
                $countQ = $db->query("SELECT id, permission_id FROM permission_page_matches WHERE page_id = ? ",array($v1->id));
                $countCountQ = $countQ->count();
                if(!in_array($v1->id,$page_ids) && $v1->private == 1 && !$countCountQ >=1){ ?>
                  <br><label class="normal"><input type='checkbox' name='addPage[]' class='addPage' id='addPage[]' value='<?=$v1->id;?>'> <?=$v1->page;?></label>
                <?php } } else {
                  if(!in_array($v1->id,$page_ids) && $v1->private == 1){ ?>
                    <br><label class="normal"><input type='checkbox' name='addPage[]' class='addPage' id='addPage[]' value='<?=$v1->id;?>'> <?=$v1->page;?></label>
                  <?php } }
                }  ?>


              </p>
              <?php if($settings->page_permission_restriction == 1) { ?>
                <p><br><strong>Private - Cannot Be Assigned</strong>
                  <?php
                  //Display list of pages with this access level

                  foreach ($pageData as $v1){
                    $countQ = $db->query("SELECT id, permission_id FROM permission_page_matches WHERE page_id = ? ",array($v1->id));
                    $countCountQ = $countQ->count();
                    if(!in_array($v1->id,$page_ids) && $v1->private == 1 && $countCountQ >=1){ ?><br><?=$v1->page;?> (<?php if($countCountQ > 1) {?>Multiple<?php } else { ?><a href="admin.php?view=page&id=<?=$v1->id?>" style="text-decoration:none;"><?=fetchPermissionDetails($countQ->first()->permission_id)['name']?></a><?php } ?>)
                    <?php } }  ?>


                  <?php } ?>


                </p>
              </div>
              <div class="tab-pane fade" id="PublicPagesTab" role="tabpanel" aria-labelledby="PublicPages">
                <h3>Public Pages</h3>
                <strong>Manage Public Pages</strong>
                <?php
                //List public pages
                foreach ($pageData as $v1) {
                  if($v1->private != 1){
                    ?><br><a href="admin.php?view=page&id=<?=$v1->id?>" style="text-decoration:none;"><?=$v1->page?></a>
                  <?php  }
                }
                ?>
              </div>
            </div>
          </div>



        </div>

        <!-- End of main content section -->
      </form>
    </div>
<script type="text/javascript">
$("#addAll").change(function(){
  $('.addPage').prop('checked', this.checked);
});

$("#removeAll").change(function(){
  $('.removePage').prop('checked', this.checked);
});
</script>
