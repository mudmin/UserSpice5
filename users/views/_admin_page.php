<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
        <li>Manage</li>
        <li><a href="<?=$us_url_root?>users/admin.php?view=pages">Pages</a></li>
        <li class="active">Page</li>
      </ol>
    </div>
  </div>
</div>
</div>
</header>
<?php
//PHP Goes Here!
$pageId = Input::get('id');
$errors = [];
$successes = [];
$new = Input::get('new');
if($new=='yes') {
  $_SESSION['redirect_after_save']=true;
  $_SESSION['redirect_after_uri']=Input::get('dest');
}


//Check if selected pages exist
if(!pageIdExists($pageId)){
  Redirect::to($us_url_root.'users/admin.php?view=pages'); die();
}

$pageDetails = fetchPageDetails($pageId); //Fetch information specific to page


//Forms posted
if(Input::exists()){
  $token = Input::get('csrf');
  if(!Token::check($token)){
    include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
  }
  $update = 0;

  if(!empty($_POST['private'])){
    $private = Input::get('private');
  }

  if(!empty($_POST['re_auth'])){
    $re_auth = Input::get('re_auth');
  }
  //Toggle private page setting
  if (isset($private) AND $private == 'Yes'){
    if ($pageDetails->private == 0){
      if (updatePrivate($pageId, 1)){
        $successes[] = lang("PAGE_PRIVATE_TOGGLED", array("private"));
        logger($user->data()->id,"Pages Manager","Changed private from public to private for Page #$pageId.");
      }else{
        $errors[] = lang("SQL_ERROR");
      }
    }
  }elseif ($pageDetails->private == 1){
    if (updatePrivate($pageId, 0)){
      $successes[] = lang("PAGE_PRIVATE_TOGGLED", array("public"));
      logger($user->data()->id,"Pages Manager","Changed private from private to public for Page #$pageId and stripped re_auth.");
    }else{
      $errors[] = lang("SQL_ERROR");
    }
  }


  //Toggle reauth setting
  if($pageDetails->private==1 && $pageDetails->page != "users/admin_verify.php" && $pageDetails->page != "usersc/admin_verify.php" && $pageDetails->page != "users/admin_pin.php?view=pin" && $pageDetails->page != "usersc/admin_pin.php?view=pin") {
    if (isset($re_auth) AND $re_auth == 'Yes'){
      if ($pageDetails->re_auth == 0){
        if (updateReAuth($pageId, 1)){
          $successes[] = lang("PAGE_REAUTH_TOGGLED", array("requires"));
          logger($user->data()->id,"Pages Manager","Changed re_auth from No to Yes for Page #$pageId.");
        }else{
          $errors[] = lang("SQL_ERROR");
        }
      }
    }elseif ($pageDetails->re_auth == 1){
      if (updateReAuth($pageId, 0)){
        $successes[] = lang("PAGE_REAUTH_TOGGLED", array("does not require"));
        logger($user->data()->id,"Pages Manager","Changed re_auth from Yes to No for Page #$pageId.");
      }else{
        $errors[] = lang("SQL_ERROR");
      }
    } }

    //Remove permission level(s) access to page
    if(!empty($_POST['removePermission'])){
      $remove = Input::get('removePermission');
      if ($deletion_count = removePage($pageId, $remove)){
        $successes[] = lang("PAGE_ACCESS_REMOVED", array($deletion_count));
        logger($user->data()->id,"Pages Manager","Deleted $deletion_count permission(s) from $pageDetails->page.");
      }else{
        $errors[] = lang("SQL_ERROR");
      }
    }

    //Add permission level(s) access to page
    if(!empty($_POST['addPermission'])){
      $add = Input::get('addPermission');
      $addition_count = 0;
      foreach($add as $perm_id){
        if(addPage($pageId, $perm_id)){
          $addition_count++;
        }
      }
      if ($addition_count > 0 ){
        $successes[] = lang("PAGE_ACCESS_ADDED", array($addition_count));
        logger($user->data()->id,"Pages Manager","Added $addition_count permission(s) to $pageDetails->page.");
      }
    }

    //Changed title for page
    if($_POST['changeTitle'] != $pageDetails->title){
      $newTitle = Input::get('changeTitle');
      if ($db->query('UPDATE pages SET title = ? WHERE id = ?', array($newTitle, $pageDetails->id))){
        $successes[] = lang("PAGE_RETITLED", array($newTitle));
        logger($user->data()->id,"Pages Manager","Retitled '{$pageDetails->page}' to '$newTitle'.");
      }else{
        $errors[] = lang("SQL_ERROR");
      }
    }
    $pageDetails = fetchPageDetails($pageId);
    if(isset($_SESSION['redirect_after_save']) && $_SESSION['redirect_after_save']==true) {
      if(!empty($_SESSION['redirect_after_uri'])){
        $redirect_uri=$_SESSION['redirect_after_uri'];
        unset($_SESSION['redirect_after_save']);
        unset($_SESSION['redirect_after_uri']);
        Redirect::to(htmlspecialchars_decode($redirect_uri));
      }
    }
    if(Input::get("return") != "" && $errors == []){ Redirect::to('admin.php?view=pages');}
  }
  $pagePermissions = fetchPagePermissions($pageId);
  $permissionData = fetchAllPermissions();
  $countQ = $db->query("SELECT id, permission_id FROM permission_page_matches WHERE page_id = ? ",array($pageId));
  $countCountQ = $countQ->count();
  ?>

  <div class="content mt-3">
    <h2>Page Permissions </h2>
    <?php resultBlock($errors,$successes); ?>
    <form name='adminPage' action='<?=$us_url_root?>users/admin.php?view=page&id=<?=$pageId;?>' method='post'>
      <input type='hidden' name='process' value='1'>

      <div class="row">
        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading"><strong>Information</strong></div>
            <div class="panel-body">
              <div class="form-group">
                <label>ID:</label>
                <?= $pageDetails->id; ?>
              </div>
              <div class="form-group">
                <label>Name:</label>
                <?= $pageDetails->page; ?>
              </div>
            </div>
          </div><!-- /panel -->
        </div><!-- /.col -->

        <div class="col-md-3">
          <div class="panel panel-default">
            <div class="panel-heading"><strong>Public or Private<a class="nounderline" data-toggle="tooltip" title="Checking 'Private' will cause UserSpice to protect this page"><font color="blue">?</font></a></strong></div>
            <div class="panel-body">
              <div class="form-group">
                <label>Private:
                  <?php
                  $checked = ($pageDetails->private == 1)? ' checked' : ''; ?>
                  <input type='checkbox' name='private' id='private' value='Yes'<?=$checked;?>>
                </label></div>
                <?php if($pageDetails->private==1 && $pageDetails->page != "users/admin_verify.php" && $pageDetails->page != "usersc/admin_verify.php" && $pageDetails->page != "users/admin_pin.php?view=pin" && $pageDetails->page != "usersc/admin_pin.php?view=pin") {?>
                  <label>Require ReAuth:
                    <?php
                    $checked1 = ($pageDetails->re_auth == 1)? ' checked' : ''; ?>
                    <input type='checkbox' name='re_auth' id='re_auth' value='Yes'<?=$checked1;?>></label>
                  <?php } ?>
                </div>
              </div><!-- /panel -->
            </div><!-- /.col -->

            <div class="col-md-3">
              <div class="panel panel-default">
                <div class="panel-heading"><strong>Remove Access</strong></div>
                <div class="panel-body">
                  <div class="form-group">
                    <?php
                    //Display list of permission levels with access
                    $perm_ids = [];
                    foreach($pagePermissions as $perm){
                      $perm_ids[] = $perm->permission_id;
                    }
                    foreach ($permissionData as $v1){
                      if(in_array($v1->id,$perm_ids)){ ?>
                        <label class="normal"><input type='checkbox' name='removePermission[]' id='removePermission[]' value='<?=$v1->id;?>'> <?=$v1->name;?></label><br/>
                      <?php }} ?>
                    </div>
                  </div>
                </div><!-- /panel -->
              </div><!-- /.col -->

              <div class="col-md-3">
                <div class="panel panel-default">
                  <div class="panel-heading"><strong>Add Access</strong></div>
                  <div class="panel-body">
                    <div class="form-group">
                      <?php
                      //Display list of permission levels without access
                      foreach ($permissionData as $v1){
                        if(!in_array($v1->id,$perm_ids)){ ?>
                          <?php if($settings->page_permission_restriction == 0) {?><label class="normal"><input type='checkbox' name='addPermission[]' id='addPermission[]' value='<?=$v1->id;?>'> <?=$v1->name;?></label><br/><?php } ?>
                          <?php if($settings->page_permission_restriction == 1) {?><label class="normal"><input type="radio" name="addPermission[]" id="addPermission[]" value="<?=$v1->id;?>" <?php if($countCountQ > 0 || $pageDetails->private==0) { ?> disabled<?php } ?>> <?=$v1->name;?></label><br/><?php } ?>
                        <?php }} ?>
                      </div>
                    </div>
                  </div><!-- /panel -->
                </div><!-- /.col -->
              </div><!-- /.row -->

              <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                  <div class="form-group">
                    <label for="title">Page Title:</label> <span class="small">(This is the text that's displayed on the browser's titlebar or tab)</span>
                      <input type="text" class="form-control" name="changeTitle" maxlength="50" value="<?= $pageDetails->title; ?>" />
                    </div>
                  </div>
                </div>

                <input type="hidden" name="csrf" value="<?=Token::generate();?>" >
                <a class='btn btn-warning' href="<?=$us_url_root?>users/admin.php?view=pages">Cancel</a>
                <input class='btn btn-secondary' name = "return" type='submit' value='Update & Close' class='submit' />
                <input class='btn btn-primary' type='submit' value='Update' class='submit' />
                </form>
            </div>
