<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?=$us_url_root; ?>users/admin.php">Dashboard</a></li>
        <li>Tools</li>
        <li class="active">Check for Updates</li>
      </ol>
    </div>
  </div>
</div>
</div>
</header>

<div class="content mt-3">
  <h2>Checking for updates...</h2>
  <?php
      if(!extension_loaded("curl")){
        usError("You must have the PHP CURL extension installed and loaded to use Spice Shaker");
      }

      if(!extension_loaded("zip")){
        usError("You must have the PHP zip extension installed and loaded to use Spice Shaker");
      }
      if ($settings->bleeding_edge == 1) {
          echo '<p>You are on the BLEEDING EDGE update cycle (Thank You!).  This means you will get updates a few days to a few weeks before everyone else.
        There may be bugs. Please backup and report bugs as you find them.</p>';
      } else {
          echo '<p>You are on the STABLE update cycle.  You will receive updates after they have been passed to our Bleeding Edge users. To become a BE user, go into your
        settings table and flip bleeding_edge from 0 to 1.</p>';
      }
  ?>

  <h4 align="center">
    <?php
    require_once $abs_us_root.$us_url_root.'users/includes/user_spice_ver.php';

    $rc = @fsockopen('www.userspice.com', 443, $errno, $errstr, 1);
    if(!is_resource($rc) ){
      //try port 80
      $rc = @fsockopen('www.userspice.com', 80, $errno, $errstr, 1);
    }
    if (is_resource($rc)) {
        if ($settings->bleeding_edge == 1) {
            define('REMOTE_VERSION', 'https://userspice.com/version/beversion.txt');
        } else {
            define('REMOTE_VERSION', 'https://userspice.com/version/version.txt');
        }
        $remoteVersion = trim(file_get_contents(REMOTE_VERSION));
        $remoteVersion = preg_replace('/[^\\d.]+/', '', $remoteVersion);
        echo 'You are running version '.$user_spice_ver.'<br><br>';
        echo 'The latest version is '.$remoteVersion.'<br><br>';
        if (version_compare($remoteVersion, $user_spice_ver) == 1) {
            echo "Updates are available at <a href='https://www.userspice.com/updates'>UserSpice.com/updates</a><br>";
        } else {
            echo 'You are running the latest version!';
        }
    } else {
        echo 'We are sorry. UserSpice.com is not reachable by this server. Please try back later.';
    }
?>
<br><br>
<?php
//New API Stuff
$type = Input::get('type');
$api = "https://api.userspice.com/api/v2/";
// $api = "http://localhost/bugs/api.php";
if ($settings->spice_api != '') {
    $sysup = Input::get('sysup');
    if (!empty($sysup)) {
        //create a new cURL resource
        $ch = curl_init($api);
        //setup request to send json via POST
        $data = [
      'key' => $settings->spice_api,
      'sysver' => $user_spice_ver,
      'call' => 'sysup',
  ];
        $payload = json_encode($data);

        //attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        //set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        //return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //execute the POST request
        $result = curl_exec($ch);
        //close cURL resource
        curl_close($ch);
        $result = json_decode($result);
        if (isset($result->next_ver) && $result->next_ver != '') {
            if ($result->bleeding_edge == 1 && $settings->bleeding_edge != 1) {
                die("$result->next_ver is a bleeding edge update and is not ready for automatic install. Please check back later.");
            }
            if ($result->no_update > 0) {
                if ($result->no_update == 1) {
                    die("$result->next_ver must be installed manually from UserSpice.com/updates");
                } elseif ($result->no_update == 2) {
                    die('The updater itself must be updated, please install the Updater Plugin and run it from Spice Shaker');
                }
            } else { //do the update
                echo "Update found... $result->next_ver released on $result->released.<br>";
                if(file_exists($abs_us_root.$us_url_root.'usupdate.zip')){
                unlink($abs_us_root.$us_url_root.'usupdate.zip');
                }
                $zipFile = $abs_us_root.$us_url_root.'usupdate.zip';
                echo 'Creating zip file...';
                logger($user->data()->id, "$result->next_ver", 'Creating zip file');
                $extractPath = $abs_us_root.$us_url_root;
                $zip_resource = fopen($zipFile, 'w');
                $url = 'https://github.com/mudmin/releases/raw/master/updates/'.$result->next_file;
                $hash = $result->hash;

                $ch_start = curl_init();
                echo 'attempting download...';
                logger($user->data()->id, "$result->next_ver", 'Attempting download');
                curl_setopt($ch_start, CURLOPT_URL, $url);
                curl_setopt($ch_start, CURLOPT_FAILONERROR, true);
                curl_setopt($ch_start, CURLOPT_HEADER, 0);
                curl_setopt($ch_start, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch_start, CURLOPT_AUTOREFERER, true);
                curl_setopt($ch_start, CURLOPT_BINARYTRANSFER, true);
                curl_setopt($ch_start, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch_start, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch_start, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch_start, CURLOPT_FILE, $zip_resource);
                $page = curl_exec($ch_start);
                if (!$page) {
                    echo 'Error :- '.curl_error($ch_start);
                    logger($user->data()->id, "$result->next_ver", 'Curl error'.curl_error($ch_start));
                    //unlink($zipFile);
                }
                curl_close($ch_start);

                $zip = new ZipArchive();

                if ($zip->open($zipFile) !== true) {
                    if(file_exists($zipFile)){
                    unlink($zipFile);
                    }
                    echo 'Error :- Unable to open the Zip File';
                    logger($user->data()->id, "$result->next_ver", 'Unable to open the Zip File');
                }
                echo '<br>Opening zip file and checking hash.';
                logger($user->data()->id, "$result->next_ver", 'Opening zip file and checking hash');
                $newCrc = base64_encode(hash_file('sha256', $zip->filename));
                if ($newCrc == $hash) {
                    echo '<br>Hash matches';
                    logger($user->data()->id, "$result->next_ver", 'Hash Matches');
                    $zip->extractTo($extractPath);
                    echo '...extracting zip file';
                    logger($user->data()->id, "$result->next_ver", 'Extracting zip file');
                    $zip->close();
                    echo "<br><strong><span style='color:blue'>$result->message</span></strong>";
                    if(file_exists($zipFile)){
                    unlink($zipFile);
                    }
                    logger($user->data()->id, "$result->next_ver", $result->message);
                    logger($user->data()->id, "$result->next_ver", 'Running migration script(s)');
                    Redirect::to($us_url_root.'users/updates/index.php?auto=1');
                } else {
                    if(file_exists($zipFile)){
                    unlink($zipFile);
                    }
                    logger($user->data()->id, "$result->next_ver", 'Hash match failed');
                    echo "<br>The hash does not match.  This means one of 2 things. Either the file on the server has been tampered with or (more likely) the file was
            updated and we forgot to update the hash.  Please fill out a bug report. You can still download this plugin at $url if you wish.";
                }
                echo '<br>Deleting zip file';
                logger($user->data()->id, "$result->next_ver", 'Deleting zip file');
                if(file_exists($zipFile)){
                unlink($zipFile);
                }
            }
        }
    }
}//end if key check
?>
  </h4>
  <?php if ($remoteVersion != $user_spice_ver && $settings->spice_api != '') {?>
  <br>
  <div class="text-center">
    <form class="" action="" method="post">
      <input type="submit" name="sysup" value="Download & Install Updates" class="btn btn-primary"><br>
      It's always a good idea to <strong><a href="<?=$us_url_root; ?>users/admin.php?view=backup">backup UserSpice</a></strong> before updating.
    </form>
  </div>
<br>
<?php } elseif ($settings->spice_api == '') {
    echo "<h4 align='center'>You cannot download automatic updates because you have not entered your free API key in the dashboard</h4><br>";
} ?>

<div class="row">
  <div class="col-12 text-center">
    Any messages below this are from ACTIVE plugins that are checking to make sure they have the latest database updates.
    <?php $plugins = $db->query('SELECT * FROM us_plugins WHERE last_check < ? AND status = ?', [date('Y-m-d H:i:s', strtotime('-3 hours')), 'active'])->results();
    foreach ($plugins as $p) {
        echo "<br>Checking $p->plugin ";
        if (file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$p->plugin.'/migrate.php')) {
            include $abs_us_root.$us_url_root.'usersc/plugins/'.$p->plugin.'/migrate.php';
        }
        $db->update('us_plugins', $p->id, ['last_check' => date('Y-m-d H:i:s')]);
    } ?>
  </div>
</div>
</div>
