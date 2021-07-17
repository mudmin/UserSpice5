<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
        <ol class="breadcrumb text-right">
          <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
          <li>Tools</li>
          <li class="active">Backup</li>
        </ol>
    </div>
  </div>
</div>
</div>
</header>
<?php
if(!in_array($user->data()->id,$master_account)){
  Redirect::to($us_url_root.'users/admin.php?err=You+do+not+have+master+account+privelages');
}
$table_view = $db->query("SHOW TABLES");
$tablev = $table_view->results();

$errors = $successes = [];
//:: Admin Backup
$lang = array_merge($lang,array(
  "AB_CREATE_BACKUP"      => "Create Backup",
  "AB_SETSAVED"      => "Settings Successfully Saved",
  "AB_PATHCREATE"    => "Destination path created.",
  "AB_PATHERROR"     => "Destination path could not be created due to unknown error.",
  "AB_PATHEXISTED"   => "Destination path already existed. Using the existing folder.",
  "AB_BACKUPSUCCESS" => "Backup was successful.",
  "AB_BACKUPFAIL"    => "Backup failed.",
  "AB_DB_FILES_ZIP"  => "DB &amp; Files Zipped",
  "AB_FILE_RENAMED"  => "File renamed to:&nbsp;",
  "AB_NOT_RENAME"    => "Could not rename backup zip file to contain hash value.",
  "AB_ERROR_CREATE"  => "Error creating zip file",
  "AB_DB_ZIPPED"     => "Database Zipped",
  "AB_PATHEXIST"     => "Backup path already exists or could not be created.",
  "AB_T_FILE_ZIP"    => "Userspice Files Zipped",
  "AB_TABLES_ZIP"    => "Tables Zipped",
  "AB_BACKUP_DELETE" => "Backup(s) Deleted !",
  "AB_PAGENAME"      => "System Backup",
  "AB_BACKUP_SET"    => "Backup Settings",
  "AB_BACKUP_DEST"   => "Backup Destination",
  "AB_BACKUP_DEST_INFO" => "Relative to the z_us_root.php file. Put a / for root.",
  "AB_BACKUP_SOURCE" => "Backup Source",
  "AB_DB_TM_FILES"   => "Database &amp; Userspice Files",
  "AB_DB_FILES"      => "Database Only",
  "AB_TM_FILES"      => "Userspice Files Only",
  "AB_SINGLE_TBL"    => "Single Table",
  "AB_SELECT_TBL"    => "Please select table to backup",
  "AB_DB_TBLS"       => "DB Tables",
  "AB_SAVE_SETTINGS" => "&nbsp;Save Settings&nbsp;",
  "AB_BACKUP_BTN"    => " Backup Now!",
  "AB_EXIST_BACKUP"  => "Existing Backups&nbsp;",
  "AB_DATE"          => "Date",
  "AB_BACKUP_FILE"   => "Backup File",
  "AB_FILE_SIZE"     => "File Size",
  "AB_ACTIONS"       => "Actions",
  "AB_DELETE_B"      => "&nbsp;Delete Backup&nbsp;",
  "AB_BACKUP_NOT"    => "Backup(s) not deleted !",
  "WENT_WRONG" 	   	 => "Something went wrong",
  "AB_DB_ALL_FILES"  => "Database &amp; ALL Files",
  "AB_SAVE_WARNING"  => "Please click Save Settings BEFORE clicking Backup.",
  "AB_ZIP"     	   	 => "Your PHP does not have the zip extension loaded. This means your backups will be in folders instead of zip files and will be about 10x the size they should be. They will also not appear in the list below. You should install the php zip extension if possible.",
));

if(isset($_GET['sc1'])){
  $successes[] = lang('AB_SETSAVED');
}
if(isset($_GET['del'])){
  $successes[] = "deleted backup";
}
//Forms posted
if(!empty($_POST)) {

  if(!empty($_POST['backup'])){

    //Create backup destination folder: $settings->backup_dest
    //$backup_dest = $settings->backup_dest;
    $backup_dest = "@".$settings->backup_dest;//::from us v4.2.9a
    $backupTable = $settings->backup_table;

    if($settings->backup_source != "db_table") {
      $backupSource = $settings->backup_source;
    }
    elseif($settings->backup_source == "db_table") {
      $backupSource = $settings->backup_source.'_'.$backupTable;
    }

    $destPath = $abs_us_root.$us_url_root.$backup_dest;

    if(!file_exists($destPath)){

      if (mkdir($destPath)){

        $destPathSuccess = true;
        $successes[] = lang('AB_PATHCREATE');

      }else{

        $destPathSuccess = false;
        $errors[] = lang('AB_PATHERROR');

      }

    }else{
      $successes[] = lang('AB_PATHEXISTED');
    }


    // Generate backup path
    $backupDateTimeString = date("Y-m-d\TH-i-s");
    $backupPath = $abs_us_root.$us_url_root.$backup_dest.'backup_'.$backupSource.'_'.$backupDateTimeString.'/';

    if(!file_exists($backupPath)){

      if (mkdir($backupPath)){

        $backupPathSuccess = true;

      }else{

        $backupPathSuccess = false;

      }
    }

    if($backupPathSuccess) {

      // Since the backup path is just created with a timestamp,
      // no need to check if these subfolders exist or if they are writable
      mkdir($backupPath.'files');
      mkdir($backupPath.'sql');
    }

    // Backup All Files & Directories In Root and DB
    if($backupPathSuccess && $settings->backup_source == 'everything'){

      // Generate list of files in ABS_TR_ROOT.TR_URL_ROOT including files starting with .

      $backupItems = [];
      $backupItems[] = $abs_us_root.$us_url_root;
      $backupItems[] = $abs_us_root.$us_url_root.'users';
      $backupItems[] = $abs_us_root.$us_url_root.'usersc';

      if(backupObjects($backupItems,$backupPath.'files/')){

        $successes[] = lang('AB_BACKUPSUCCESS');

      }else{

        $errors[] = lang('AB_BACKUPFAIL');

      }

      backupUsTables($backupPath);

      $targetZipFile = backupZip($backupPath,true);

      if($targetZipFile){

        $successes[] = lang('AB_DB_FILES_ZIP');
        $backupZipHash = hash_file('sha1', $targetZipFile);
        $backupZipHashFilename = substr($targetZipFile,0,strlen($targetZipFile)-4).'_SHA1_'.$backupZipHash.'.zip';

        if(rename($targetZipFile,$backupZipHashFilename)){

          $successes[] = lang('AB_FILE_RENAMED').$backupZipHashFilename;
          logger($user->data()->id,"Admin Backup","Completed backup for everything.");

        }else{

          $errors[] = lang('AB_NOT_RENAME');

        }

      }else{

        $errors[] = lang('AB_ERROR_CREATE');

      }

    }


    // Backup Terminus files & all db tables
    if($backupPathSuccess && $settings->backup_source == 'db_us_files'){

      // Generate list of files in ABS_TR_ROOT.TR_URL_ROOT including files starting with .
      $backupItems = [];
      $backupItems[] = $abs_us_root.$us_url_root.'users';
      $backupItems[] = $abs_us_root.$us_url_root.'usersc';

      if(backupObjects($backupItems,$backupPath.'files/')){

        $successes[] = lang('AB_BACKUPSUCCESS');

      }else{

        $errors[] = lang('AB_BACKUPFAIL');

      }

      backupUsTables($backupPath);

      $targetZipFile = backupZip($backupPath,true);

      if($targetZipFile){

        $successes[] = lang('AB_DB_FILES_ZIP');
        $backupZipHash = hash_file('sha1', $targetZipFile);
        $backupZipHashFilename = substr($targetZipFile,0,strlen($targetZipFile)-4).'_SHA1_'.$backupZipHash.'.zip';

        if(rename($targetZipFile,$backupZipHashFilename)){

          $successes[] = lang('AB_FILE_RENAMED').$backupZipHashFilename;
          logger($user->data()->id,"Admin Backup","Completed backup for UserSpice Files & DB.");

        }else{

          $errors[] = lang('AB_NOT_RENAME');

        }

      }else{

        $errors[] = lang('AB_ERROR_CREATE');

      }

    }

    // Backup all db tables only
    if($backupPathSuccess && $settings->backup_source == 'db_only'){

      backupUsTables($backupPath);

      $targetZipFile = backupZip($backupPath,true);

      if($targetZipFile){

        $successes[] = lang('AB_DB_ZIPPED');
        $backupZipHash = hash_file('sha1', $targetZipFile);
        $backupZipHashFilename = substr($targetZipFile,0,strlen($targetZipFile)-4).'_SHA1_'.$backupZipHash.'.zip';

        if(rename($targetZipFile,$backupZipHashFilename)){

          $successes[] = lang('AB_FILE_RENAMED').$backupZipHashFilename;
          logger($user->data()->id,"Admin Backup","Completed backup for Database.");

        }else{

          $errors[] = lang('AB_NOT_RENAME');

        }

      }else{

        $errors[] = lang('AB_ERROR_CREATE');

      }

    }elseif(!$backupPathSuccess){

      $errors[] = lang('AB_PATHEXIST');

    }else{

      // Unknown state? Do nothing.

    }

    // Backup terminus files only
    if($backupPathSuccess && $settings->backup_source == 'us_files'){

      // Generate list of files in ABS_TR_ROOT.TR_URL_ROOT including files starting with .
      $backupItems = [];
      $backupItems[] = $abs_us_root.$us_url_root.'users';
      $backupItems[] = $abs_us_root.$us_url_root.'usersc';

      if(backupObjects($backupItems,$backupPath.'files/')){

        $successes[] = lang('AB_BACKUPSUCCESS');

      }else{

        $errors[] = lang('AB_BACKUPFAIL');

      }

      $targetZipFile = backupZip($backupPath,true);

      if($targetZipFile){

        $successes[] = lang('AB_T_FILE_ZIP');
        $backupZipHash = hash_file('sha1', $targetZipFile);
        $backupZipHashFilename = substr($targetZipFile,0,strlen($targetZipFile)-4).'_SHA1_'.$backupZipHash.'.zip';

        if(rename($targetZipFile,$backupZipHashFilename)){

          $successes[] = lang('AB_FILE_RENAMED').$backupZipHashFilename;
          logger($user->data()->id,"Admin Backup","Completed backup for UserSpice Files.");

        }else{

          $errors[] = lang('AB_NOT_RENAME');

        }

      }else{

        $errors[] = lang('AB_ERROR_CREATE');

      }


    }

    // Backup single db table only
    if($backupPathSuccess && $settings->backup_source == 'db_table'){

      backupUsTable($backupPath);

      $targetZipFile = backupZip($backupPath,true);

      if($targetZipFile){

        $successes[] = lang('AB_TABLES_ZIP');
        $backupZipHash = hash_file('sha1', $targetZipFile);
        $backupZipHashFilename = substr($targetZipFile,0,strlen($targetZipFile)-4).'_SHA1_'.$backupZipHash.'.zip';

        if(rename($targetZipFile,$backupZipHashFilename)){

          $successes[] = lang('AB_FILE_RENAMED').$backupZipHashFilename;
          logger($user->data()->id,"Admin Backup","Completed backup for $settings->backup_table table.");

        }else{

          $errors[] = lang('AB_NOT_RENAME');

        }

      }else{

        $errors[] = lang('AB_ERROR_CREATE');

      }

    }


  }

  //Delete backup
  if(!empty($_POST['delete'])){

    $deletions = $_POST['delete'];
    $backup_dest = "@".$settings->backup_dest;//::from 4.2.9a
    $count = 0;
    foreach($deletions as $delete) {
      if(!unlink($abs_us_root.$us_url_root.$backup_dest.$delete)) {
        $errors[] = lang('AB_BACKUP_NOT');
      }else{
        // $successes[] = lang('AB_BACKUP_DELETE'); //This makes a note for every deletion, uncomment this if you want that
        logger($user->data()->id,"Admin Backup","Deleted backup $delete.");

      }
      $count++;
    }
    if($count==1) $successes[] = "$count Backup Deleted";
    if($count > 1) $successes[] = "$count Backups Deleted";
  }
}
$backup_dest = "@".$settings->backup_dest;//::from 4.2.9a
// Get array of existing backup zip files
$allBackupFiles = glob($abs_us_root.$us_url_root.$backup_dest.'backup*.zip');
$allBackupFilesSize = [];
foreach($allBackupFiles as $backupFile){
  $allBackupFilesSize[] = size($backupFile);
}
$pagename = lang('AB_PAGENAME');

?>
<div class="content mt-3">
  <h2 class="mb-3"><?=$pagename?><small><span class="text-success float-right" id="ajax"></span></small></h2>
  <?php resultBlock($errors,$successes); ?>
  <div class="row">

    <div class="col-sm-12">
      <?php if(extension_loaded('zip') == false){
        echo "<p class='text-dark'><strong>".lang('AB_ZIP')."</strong></p>";}?>
        <div class="card">
          <div class="card-header"><h4><?=lang('AB_CREATE_BACKUP')?></h4></div>
          <div class="card-body">
      <form action="" name="backup" method="POST">
      <div class="row">

        <!-- backup_dest Option -->
        <div class="col">
        <div class="form-group">
          <label for="backup_dest">
            <?=lang('AB_BACKUP_DEST');?>
          </label>

            <input class="form-control" type="text" name="backup_dest" id="backup_dest" placeholder="Backup Destination" value="<?=$settings->backup_dest?>">
            <span class="text-danger"><?=lang('AB_BACKUP_DEST_INFO');?></span>
        </div>
        </div>

        <!-- backup_source Option -->
        <div class="col">
        <div class="form-group">

          <label for="backup_source" class="control-label col-sm-12">
            <?=lang('AB_BACKUP_SOURCE');?>
          </label>

            <select id="backup_source" class="form-control" name="backup_source">

              <option value="everything" <?php if($settings->backup_source =='everything') ;?>><?=lang('AB_DB_ALL_FILES');?></option>

              <option value="db_us_files" <?php if($settings->backup_source =='db_us_files') echo 'selected="selected"';?>><?=lang('AB_DB_TM_FILES');?></option>

              <option value="db_only" <?php if($settings->backup_source =='db_only') echo 'selected="selected"';?>><?=lang('AB_DB_FILES');?></option>

              <option value="us_files" <?php if($settings->backup_source =='us_files') echo 'selected="selected"';?>><?=lang('AB_TM_FILES');?></option>

              <option value="db_table" <?php if($settings->backup_source =='db_table') echo 'selected="selected"';?>><?=lang('AB_SINGLE_TBL');?></option>

            </select>

        </div>
        </div>

        <?php // if($settings->backup_source =='db_table') { ?>

          <div class="col" id="tableOnly">
          <div class="form-group">
          <label for="backup_table" class="text-primary">
            <?=lang('AB_SELECT_TBL');?>
          </label>
              <select id="backup_table" class="form-control" name="backup_table">

                <?php foreach($tablev as $v) { ?>
                  <option value="<?=end($v);?>" <?php if($settings->backup_table == end($v)) echo 'selected="selected"';?>><?=end($v);?></option>
                <?php } ?>

              </select>
          </div>
          </div>


          <?php // } ?>

          </div>
          <div class="row">
            <div class="col-md-12">
            <button class='btn btn-success' type='submit' name="backup" value='Backup' onclick="window.location='<?=$_SERVER['PHP_SELF']; ?>';"><i class="fa fa-database"></i><?=lang('AB_BACKUP_BTN');?></button>
            </div>
          </div>
        </form>
        </div>
        </div>


        <!-- Existing Backups -->
        <div class="card">
          <div class="card-header">
            <h4><?=lang('AB_EXIST_BACKUP');?><span class="badge badge-success"><?=sizeof($allBackupFiles)?></span></h4>
          </div>
          <div class="card-body">

        <form name="delete" action="" method="post">

          <table id="backups" class='table table-striped' cellspacing="0" width="100%" >

            <thead>
              <tr class="headings">
                <th class="column-title" style="width: 20px;">
                  <?php if(sizeof($allBackupFiles) > 1) {?><input type="checkbox" class="checkAllBackups" /><?php } ?>
                </th><!-- select all boxes -->
                <th class="column-title" style="width: 150px;"><?=lang('AB_DATE');?></th>
                <th class="column-title" style="width: 600px;"><?=lang('AB_BACKUP_FILE');?></th>
                <th class="column-title" style="width: 100px;"><?=lang('AB_FILE_SIZE');?></th>
                <th class="column-title text-center" style="width: 10%;"><?=lang('AB_ACTIONS');?></th>

              </tr>
            </thead>

            <tbody>
              <?php
              $i=0;
              foreach($allBackupFiles as $backupFile){
                $objectName=explode('/',$backupFile);
                $filename=end($objectName);
                $fileDate=date("F d Y H:i:s.",filemtime($backupFile));
                ?>
                <tr>
                  <td class="a-center ">
                    <input type='checkbox' class="flat" name='delete[<?=$filename?>]' value='<?=$filename?>' style="width: 10px!important;"/>
                  </td>
                  <td class=" " style="width: 150px;"><?=$fileDate?></td>
                  <td class=" " style="width: 600px;"><?=$filename?></td>
                  <td class=" " style="width: 100px;"><?=$allBackupFilesSize[$i]?></td>

                  <td class="text-center last" style="width: 10%;">
                    <a class="label label-success bg-green" href="<?=$us_url_root.$backup_dest.$filename?>"><i class="fa fa-download"></i></a>
                  </td>

                </tr>

                <?php $i++;} ?>
              </tbody>

            </table>

            <button class="btn btn-danger" onclick="window.location='<?=$us_url_root?>users/admin.php?view=backup';" type="submit" name="deleteFile" value="delete"><i class="fa fa-trash"></i><?=lang('AB_DELETE_B');?></button>

          </form>
          </div>
        </div>

        </div>


      </div><!--/.col-*-->

    </div><!--/.row-->
  <script>
  $(document).ready(function(){
    $('.checkAllBackups').on('click', function(e) {
      $('.flat').prop('checked', $(e.target).prop('checked'));
    });
    var source = $("#backup_source").val();
    if(source == 'db_table'){
      $("#tableOnly").show();
    }else{
      $("#tableOnly").hide();
    }

    $("#backup_source").change(function(){
      var value = $(this).val();

      if(value == "db_table"){
        $("#tableOnly").show();
      }else{
        $("#tableOnly").hide();
      }
      var formData = {
        'backup_source'					: value
      };
      $.ajax({
        type 		: 'POST',
        url 		: '<?=$us_url_root?>users/parsers/quick_settings.php',
        data 		: formData,
        dataType 	: 'json',
        encode 		: true
      })

      .done(function(msg) {
        $("#ajax").text();
        $("#ajax").text(msg.success);
      });
    });

    $("#backup_dest").change(function(){
      var value = $(this).val();
      var formData = {
        'backup_dest'					: value
      };
      $.ajax({
        type 		: 'POST',
        url 		: '<?=$us_url_root?>users/parsers/quick_settings.php',
        data 		: formData,
        dataType 	: 'json',
        encode 		: true
      })

      .done(function(msg) {
        $("#ajax").text();
        $("#ajax").text(msg.success);
      });
    });

    $("#backup_table").change(function(){
      var value = $(this).val();
      var formData = {
        'backup_table'					: value
      };
      $.ajax({
        type 		: 'POST',
        url 		: '<?=$us_url_root?>users/parsers/quick_settings.php',
        data 		: formData,
        dataType 	: 'json',
        encode 		: true
      })

      .done(function(msg) {
        $("#ajax").text();
        $("#ajax").text(msg.success);
      });
    });


  });	//End Document Ready Function
</script>
