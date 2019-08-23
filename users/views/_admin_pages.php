<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
        <li>Manage</li>
        <li class="active">Pages</li>
      </ol>
    </div>
  </div>
</div>
</div>
</header>

<?php

$errors = [];
$successes = [];

//Get line from z_us_root.php that starts with $path
$file = fopen($abs_us_root.$us_url_root."z_us_root.php","r");
while(!feof($file)){
  $currentLine=str_replace(" ", "", fgets($file));
  if (substr($currentLine,0,5)=='$path'){
    //echo $currentLine;
    //if here, then it found the line starting with $path so break to preserve $currentLine value
    break;
  }
}
fclose($file);

//sample text: $path=('/','/users/','/usersc/');
//Get array of paths, with quotes removed
$lineLength=strlen($currentLine);
$pathString=str_replace("'","",substr($currentLine,7,$lineLength-11));
$paths=explode(',',$pathString);

$pages=[];

//Get list of php files for each $path
foreach ($paths as $path){
  $rows=getPathPhpFiles($abs_us_root,$us_url_root,$path);
  foreach ((array)$rows as $row){
    $pages[]=$row;
  }
}

$dbpages = fetchAllPages(); //Retrieve list of pages in pages table

$count = 0;
$dbcount = count($dbpages);
$creations = array();
$deletions = array();

foreach ($pages as $page) {
  $page_exists = false;
  foreach ($dbpages as $k => $dbpage) {
    if ($dbpage->page === $page) {
      unset($dbpages[$k]);
      $page_exists = true;
      break;
    }
  }
  if (!$page_exists) {
    $creations[] = $page;
  }
}

// /*
//  * Remaining DB pages (not found) are to be deleted.
//  * This function turns the remaining objects in the $dbpages
//  * array into the $deletions array using the 'id' key.
//  */
$deletions = array_column(array_map(function ($o) {return (array)$o;}, $dbpages), 'id');

$deletes = '';
for($i = 0; $i < count($deletions);$i++) {
  $deletes .= $deletions[$i] . ',';
}
$deletes = rtrim($deletes,',');
//Enter new pages in DB if found
if (count($creations) > 0) {
  createPages($creations);
}
// //Delete pages from DB if not found
if (count($deletions) > 0) {
  deletePages($deletes);
}

//Update $dbpages
$dbpages = fetchAllPages();
$file = "../z_us_root.php";
//Edit z_us_root.php

if(!empty($_POST)){
  $token = $_POST['csrf'];
  if(!Token::check($token)){
    include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
  }
  if(!empty($_POST['removeFolder'])){
    if(!in_array($user->data()->id, $master_account)){
      Redirect::to('admin.php?view=pages&err=Permission+denied');
    }
    $folder = Input::get('folder');
    if(in_array($folder,$paths) && $folder != '' && $folder != 'users/' && $folder != 'usersc/'){
      foreach($paths as $k=>$v){
        if($v == $folder){
          unset($paths[$k]);
        }
      }
      $line = "\$path=[";
      $count = 1;
      foreach($paths as $p){
        $line .= "'".$p."'";
        if($count != count($paths)){
          $line .=",";
        }
        $count = $count + 1;
      }
      $line .= "];";
      $lines = file($file);
      $lines[0] = "<?php" . PHP_EOL;
      $lines[1] = $line . PHP_EOL ;
      $new_content = implode('', $lines);
      $h = fopen($file, 'w');
      fwrite($h, $new_content);
      fclose($h);
    }else{
      Redirect::to('admin.php?view=pages&err=Error Deleting Folder');
    }
  }//end of delete folder to monitor.

  if(!empty($_POST['addFolder'])){
    if(!in_array($user->data()->id, $master_account)){
      Redirect::to('admin.php?view=pages&err=Permission+denied');
    }
    $folder = Input::get('newFolder');
    $check = file_exists($abs_us_root.$us_url_root.$folder);
    if($check === true && !in_array($folder,$paths) && (substr($folder, -1) == '/')){
      $paths[] = $folder;
      $line = "\$path=[";
      $count = 1;
      foreach($paths as $p){
        $line .= "'".$p."'";
        if($count != count($paths)){
          $line .=",";
        }
        $count = $count + 1;
      }
      $line .= "];";
      $lines = file($file);
      $lines[0] = "<?php" . PHP_EOL;
      $lines[1] = $line . PHP_EOL ;
      $new_content = implode('', $lines);
      $h = fopen($file, 'w');
      fwrite($h, $new_content);
      fclose($h);
    }else{
      Redirect::to('admin.php?view=pages&err=Error Adding Folder');
    }
  }//end of add folder to monitor
}//end of post
$csrf = Token::generate();
?>

<div class="content mt-3">
  <form class="" action="<?=$us_url_root?>users/admin.php?view=pages" name="" method="post">
    <h1>Manage Page Access</h1>
    UserSpice is currently monitoring the following folders: <strong>


      <?php
      $lines = file('../z_us_root.php');
      $filter = str_replace("\$path=[", "", $lines[1]);
      $filter = str_replace("];", "", $filter);

      $filter=explode(",",$filter);
      if($filter[0] == "''"){
        $filter[0] = '(root)';
      }
      echo oxfordList($filter,['final'=>'and']);
      ?>
    </strong>
    <?php if(in_array($user->data()->id, $master_account)){?>
      <a href="#folder_modal" data-toggle="modal">(Change)</a>
    <?php } ?>
    <hr>
    <table id="paginate" class='table table-hover table-list-search'>
      <thead>
        <th>Id</th><th>Page</th><th>Page Name</th><th>ReAuth</th><th>Access</th>
      </thead>

      <tbody>


        <?php
        //Display list of pages
        $count=0;
        foreach ($dbpages as $page){
          ?>
          <tr><td><?=$dbpages[$count]->id?></td>
            <td><a class="nounderline" href ='admin.php?view=page&id=<?=$dbpages[$count]->id?>'><?=$dbpages[$count]->page?></a></td>
            <td><a class="nounderline" href ='admin.php?view=page&id=<?=$dbpages[$count]->id?>'><?=$dbpages[$count]->title?></a></td>
            <td>
              <?php if($dbpages[$count]->re_auth == 1){
                echo "<i class='fa fa-thumbs-o-up'></i>";
              } ?>
            </td>
            <td>
              <a class="nounderline" href ='admin.php?view=page&id=<?=$dbpages[$count]->id?>'>
                <?php
                //Show public/private setting of page
                if($dbpages[$count]->private == 0){
                  echo "<font color='green'>Public</font>";
                }else {
                  echo "<font color='red'>Private</font>";
                }
                ?>
              </a>
            </td></tr>
            <?php
            $count++;
          }?>
        </tbody>
      </table>
    </div>
    <!-- /.row -->

    <script type="text/javascript" src="js/pagination/datatables.min.js"></script>
    <script>
    $(document).ready(function() {
      $('#paginate').DataTable({"pageLength": 25,"stateSave": true,"aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]], "aaSorting": []});
    } );
  </script>
  <?php
  include($abs_us_root.$us_url_root."users/views/_folder_modal.php");
  ?>
