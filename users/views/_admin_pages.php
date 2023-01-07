<?php
$hide = Input::get('hide');
if ($hide == 'core') {
  $c = true;
} else {
  $c = false;
}

$errors = [];
$successes = [];

//Get line from z_us_root.php that starts with $path
$file = fopen($abs_us_root . $us_url_root . 'z_us_root.php', 'r');
while (!feof($file)) {
  $currentLine = str_replace(' ', '', fgets($file));
  if (substr($currentLine, 0, 5) == '$path') {
    //echo $currentLine;
    //if here, then it found the line starting with $path so break to preserve $currentLine value
    break;
  }
}
fclose($file);

//sample text: $path=('/','/users/','/usersc/');
//Get array of paths, with quotes removed
$lineLength = strlen($currentLine);
$pathString = str_replace("'", '', substr($currentLine, 7, $lineLength - 11));
$paths = explode(',', $pathString);

$pages = [];

//Get list of php files for each $path
foreach ($paths as $path) {
  $rows = getPathPhpFiles($abs_us_root, $us_url_root, $path);
  foreach ((array) $rows as $row) {
    $pages[] = $row;
  }
}

$dbpages = fetchAllPages(); //Retrieve list of pages in pages table
$delMsgs = '';
$count = 0;
$dbcount = count($dbpages);
$creations = [];
$deletions = [];

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
$deletions = array_column(array_map(function ($o) {
  return (array) $o;
}, $dbpages), 'id');

$deletes = [];
for ($i = 0; $i < count($deletions); ++$i) {
  $deletes[] = $deletions[$i];
}

//Enter new pages in DB if found
if (count($creations) > 0) {
  createPages($creations);
}
// //Delete pages from DB if not found
if (count($deletions) > 0) {
  foreach ($deletions as $key => $d) {
    //if a plugin added this, there's no need for the entire folder to be managed.
    $delName = $db->query('SELECT page FROM pages WHERE id = ?', [$d])->first();
    if (substr($delName->page, 0, 14) == 'usersc/plugins' && file_exists($abs_us_root . $us_url_root . $delName->page)) {
      unset($deletions[$key]);
      foreach ($deletes as $delkey => $delvalue) {
        if ($delvalue === $d) {
          unset($deletes[$delkey]);
        }
      }
      continue;
    } else {
    }
    $delMsgs .= $delName->page . '\\n';
  }
  deletePages(implode(',', $deletes));
}

//Update $dbpages
$dbpages = fetchAllPages();
$file = '../z_us_root.php';
//Edit z_us_root.php

if (!empty($_POST)) {
  $token = $_POST['csrf'];
  if (!Token::check($token)) {
    include $abs_us_root . $us_url_root . 'usersc/scripts/token_error.php';
  }
  if (!empty($_POST['removeFolder'])) {
    if (!in_array($user->data()->id, $master_account)) {
      usError("Permission denied");
      Redirect::to('admin.php?view=pages');
    }
    $folder = Input::get('folder');
    if (in_array($folder, $paths) && $folder != '' && $folder != 'users/' && $folder != 'usersc/') {
      foreach ($paths as $k => $v) {
        if ($v == $folder) {
          unset($paths[$k]);
        }
      }
      $line = '$path=[';
      $count = 1;
      foreach ($paths as $p) {
        $line .= "'" . $p . "'";
        if ($count != count($paths)) {
          $line .= ',';
        }
        $count = $count + 1;
      }
      $line .= '];';
      $lines = file($file);
      $lines[0] = '<?php' . PHP_EOL;
      $lines[1] = $line . PHP_EOL;
      $new_content = implode('', $lines);
      $h = fopen($file, 'w');
      fwrite($h, $new_content);
      fclose($h);
      usSuccess("Deleted folder");
      Redirect::to('admin.php?view=pages');
    } else {
      usError("Error deleting folder");
      Redirect::to('admin.php?view=pages');
    }
  } //end of delete folder to monitor.

  if (!empty($_POST['addFolder'])) {
    if (!in_array($user->data()->id, $master_account)) {
      usError("Permission denied");
      Redirect::to('admin.php?view=pages');
    }
    $folder = Input::get('newFolder');
    $check = file_exists($abs_us_root . $us_url_root . $folder);
    if ($check === true && !in_array($folder, $paths) && (substr($folder, -1) == '/')) {
      $paths[] = $folder;
      $line = '$path=[';
      $count = 1;
      foreach ($paths as $p) {
        $line .= "'" . $p . "'";
        if ($count != count($paths)) {
          $line .= ',';
        }
        $count = $count + 1;
      }
      $line .= '];';
      $lines = file($file);
      $lines[0] = '<?php' . PHP_EOL;
      $lines[1] = $line . PHP_EOL;
      $new_content = implode('', $lines);
      $h = fopen($file, 'w');
      fwrite($h, $new_content);
      fclose($h);
      usSuccess("Added folder");
      Redirect::to('admin.php?view=pages');
    } else {
      usError("Error adding folder");
      Redirect::to('admin.php?view=pages');
    }
  } //end of add folder to monitor
} //end of post
$csrf = Token::generate();
?>

<h2>Manage Page Access
  <?php if ($c) { ?>
    <button type="button" onclick="window.location.href = 'admin.php?view=pages';" name="button" class="btn btn-primary">Show All Pages</button>
  <?php } else { ?>
    <button type="button" onclick="window.location.href = 'admin.php?view=pages&hide=core';" name="button" class="btn btn-primary">Hide Default Pages</button>
  <?php } ?>
</h2>
<p class="text-dark pt-2">UserSpice is currently monitoring the following folders: <strong>


    <?php
    $lines = file('../z_us_root.php');
    $filter = str_replace('$path=[', '', $lines[1]);
    $filter = str_replace('];', '', $filter);

    $filter = explode(',', $filter);
    if ($filter[0] == "''") {
      $filter[0] = '(root)';
    }
    echo oxfordList($filter, ['final' => 'and']);
    ?>
  </strong>
  <?php if (in_array($user->data()->id, $master_account)) { ?>
    <a href="#folder_modal" data-toggle="modal" data-bs-toggle="modal" class="btn btn-outline-primary btn-sm mb-2">Change</a>
  <?php } ?>
</p>
<div class="card">
  <div class="card-body">
    <table id="pagestable" class='table table-hover paginate'>
      <thead>
        <tr>
          <th>ID</th>
          <th>Page</th>
          <th>Page Name</th>
          <th>Access</th>
        </tr>
      </thead>
      <tbody>
        <?php
        //Display list of pages
        $count = 0;
        foreach ($dbpages as $page) {
          if ($c && $page->core == 1) {
            continue;
          } ?>
          <tr>
            <td><span class="hideMe"><?= sprintf('%08d', $dbpages[$count]->id) ?></span>
              <?= $dbpages[$count]->id; ?></td>
            <td><a class="nounderline text-dark" href='admin.php?view=page&id=<?= $dbpages[$count]->id; ?>'><?= $dbpages[$count]->page; ?></a></td>
            <td><a class="nounderline text-dark" href='admin.php?view=page&id=<?= $dbpages[$count]->id; ?>'><?= $dbpages[$count]->title; ?></a></td>
            <td>
              <a class="nounderline" href='admin.php?view=page&id=<?= $dbpages[$count]->id; ?>'>
                <?php
                //Show public/private setting of page
                if ($dbpages[$count]->private == 0) {
                  echo "<span style='color:green'>Public</span>";
                } else {
                  echo "<span style='color:red'>Private</span>";
                } ?>
              </a>
            </td>
          </tr>
        <?php
          ++$count;
        } ?>
      </tbody>
    </table>
  </div>
</div>

<?php
if ($delMsgs != '') {
?>
  <script type="text/javascript">
    alert("The following pages have been deleted from your database because they are either no longer present or because you used securePage on a file that was not monitored by UserSpice. You can add additional folders at the top of this page.\n \n<?= $delMsgs; ?>");
  </script>

<?php
}
include $abs_us_root . $us_url_root . 'users/views/_folder_modal.php';
?>