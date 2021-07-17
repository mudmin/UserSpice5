<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
        <li>Manage</li>
        <li class="active">Permission Levels</li>
      </ol>
    </div>
  </div>
</div>
</div>
</header>
<?php
$validation = new Validate();
//PHP Goes Here!
$permission_exempt = array(1,2);
$errors = [];
$successes = [];

//Forms posted
if(!empty($_POST))
{
  $token = $_POST['csrf'];
  if(!Token::check($token)){
    include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
  }

  //Create new permission level
  if(!empty($_POST['name'])) {
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
      $db->insert('permissions',$fields);
      $successes[] = "Permission Updated";
      logger($user->data()->id,"Permissions Manager","Added Permission Level named $permission.");
    }else{

    }
  }
}


$permissionData = fetchAllPermissions(); //Retrieve list of all permission levels
$count = 0;
// dump($permissionData);
// echo $permissionData[0]->name;
?>
<div class="content mt-3">
  <?php if(!$validation->errors()=='') { display_errors($validation->errors()); } ?>
  <?php echo resultBlock($errors,$successes); ?>
  <!-- Main Center Column -->
  <div class="class col-md-6 offset-md-3 col-sm-12">
    <!-- Content Goes Here. Class width can be adjusted -->
    <form name='adminPermissions' action='' method='post'>
      <h2>Create a new permission level</h2><br>
      <p>
        <label>Permission Name:</label>
        <input type='text' name='name' />  <input type="hidden" name="csrf" value="<?=Token::generate();?>" >

        <input class='btn btn-primary' type='submit' name='Submit' value='Create New Permission Level' /><br><br>
      </p>
      </form>


    <br>
    <table class='table table-hover table-list-search'>
      <tr>
        <?php /*<th>Delete</th> //LEGACY BA 9162017 */?><th>Permission Name (Click a Permission Name to Manage It)</th>
      </tr>

      <?php
      //List each permission level
      foreach ($permissionData as $v1) {
        ?>
        <tr>
          <?php /*  <td><?php if(!in_array($permissionData[$count]->id,$permission_exempt)){?><input type='checkbox' name='delete[<?=$permissionData[$count]->id?>]' id='delete[<?=$permissionData[$count]->id?>]' value='<?=$permissionData[$count]->id?>'><?php } ?></td>//LEGACY BA 9162017 */?>

          <td><a href='admin.php?view=permission&id=<?=$permissionData[$count]->id?>'><?php echo ucfirst($permissionData[$count]->name);?></a></td>
        </tr>
        <?php
        $count++;
      }
      ?>

    </table>

    <!-- End of main content section -->
  </div>


</div>
