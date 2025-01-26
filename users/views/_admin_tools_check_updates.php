<?php
$sn = Config::get('session/session_name');

if (isset($_POST['change_track'])) {
  //token check
  if (!Token::check(Input::get('csrf'))) {
    include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
  }
  $change_track = Input::get('change_track');

  $db->update('settings', 1, ['bleeding_edge' => $change_track]);

  usSuccess("Your update track has been changed");
  Redirect::to($us_url_root . 'users/admin.php?view=updates');
}

if ($settings->bleeding_edge == 1) {
  $value = "0";
  $label = "Stable";
  $class = "btn-success";
} elseif ($settings->bleeding_edge == 2) {
  $value = "0";
  $label = "Stable";
  $class = "btn-danger";
} else {
  $value = "1";
  $label = "Bleeding Edge";
  $class = "btn-warning";
}

$update_available = false;
?>
<div class="row">
  <div class="col-12 col-md-8 mx-auto mt-3">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-12 col-md-6">
            <h2>Checking for updates...</h2>

          </div>
          <div class="col-12 col-md-6 text-end">
            <form class="" action="" method="post">
              <input type="hidden" name="csrf" value="<?= Token::generate(); ?>">
              <input type="hidden" name="change_track" value="<?= $value; ?>">
              <input type="submit" class="btn <?= $class ?> mt-1" value="Change Update Track to <?= $label; ?>">
            </form>
          </div>

        </div>
      </div>
      <div class="card-body container text-center">
        <div class="row">


          <?php
          $error_tripped = false;
          if (!extension_loaded("curl")) {
            $error_tripped = true;
            usError("You must have the PHP CURL extension installed and loaded to use the update system.");
          }

          if (!extension_loaded("zip")) {
            $error_tripped = true;
            usError("You must have the PHP zip extension installed and loaded to use the update system.");
          }

          if (!ini_get('allow_url_fopen')) {
            $error_tripped = true;
            usError("The PHP setting 'allow_url_fopen' must be enabled to use the update system.");
          }
          if ($error_tripped == true) {
          ?>

            <div class="alert alert-danger" role="alert">We have detected a problem that may prevent you from automatically updating. If you cannot resolve the problem, you can still update at <a target="_blank" href="https://userspice.com/updates">https://userspice.com/updates</a>
              <br>
              Please download the updates and install them in order by unzipping them and overwriting existing files.


            </div>
          <?php
          }

          if ($settings->bleeding_edge == 2) { ?>
            <div class="alert alert-danger" role="alert">You are on the <b>EXPERIMENTAL</b> update cycle. These updates are untested and may contain serious bugs. This track is for developers and testers only. Please backup frequently and report all bugs.</div>
          <?php } elseif ($settings->bleeding_edge == 1) { ?>
            <div class="alert alert-warning" role="alert">You are on the <b>BLEEDING EDGE</b> update cycle (Thank You!). This means you will get updates a few days to a few weeks before everyone else. Although updates are tested before reaching this stage, there may be bugs. Please backup before updating and report bugs as you find them.</div>
          <?php } else { ?>
            <div class="alert alert-success" role="alert">You are on the <b>STABLE</b> update cycle. While we can't promise that any code is error free, the Bleeding Edge update cycle community has helped to test this update before it was released to the public.</div>
          <?php }
          ?>

        </div>
      </div>

      <div class="container text-center">
        <div class="row">
          <?php
          require_once $abs_us_root . $us_url_root . 'users/includes/user_spice_ver.php';

          $rc = @fsockopen('www.userspice.com', 443, $errno, $errstr, 1);
          if (!is_resource($rc)) {
            //try port 80
            $rc = @fsockopen('www.userspice.com', 80, $errno, $errstr, 1);
          }
          if (is_resource($rc)) {
            if ($settings->bleeding_edge == 2) {
              define('REMOTE_VERSION', 'https://userspice.com/version/experimental.txt');
            } elseif ($settings->bleeding_edge == 1) {
              define('REMOTE_VERSION', 'https://userspice.com/version/beversion.txt');
            } else {
              define('REMOTE_VERSION', 'https://userspice.com/version/version.txt');
            }
            $remoteVersion = trim(file_get_contents(REMOTE_VERSION));
            if ($remoteVersion == "Visit UserSpice.com") {
              $canary = true;
            } else {
              $canary = false;
            }
            $remoteVersion = preg_replace('/[^\\d.]+/', '', $remoteVersion);
            // $remoteVersion = "5.8.0";
            if (version_compare($remoteVersion, $user_spice_ver) == 1) {
              $update_available = true;
              $class = "text-bg-danger";
            } else {
              $class = "text-bg-success";
            }
          ?>
            <div class="card text-bg-secondary mb-3 me-3 col">
              <h5>Your Version</h5>
              <h4><?= $user_spice_ver ?></h4>
            </div>

            <div class="card <?= $class ?> mb-3 ms-3 col">
              <?php if ($canary) { ?>
                There is a problem with the UserSpice update system.<br>
                Please visit UserSpice.com for further information.<br><br> Please visit our discord at
                https://discord.gg/6XZ7mEWnzZ to confirm what you read on the site.<br>

              <?php } else { ?>
                <h5>Latest Version</h5>
                <h4><?= $remoteVersion ?></h4>
              <?php } ?>
            </div>
        </div>

      <?php
            if ($update_available) {
              echo "<h3>Updates are available at <a href='https://www.userspice.com/updates'>UserSpice.com/updates</a></h3>";
            } else {
              echo '<h3 class="mt-2">You are running the latest version!</h3>';
            }
          } else {
            echo '<div class="alert alert-primary" role="alert">We are sorry. UserSpice.com is not reachable by this server. Please try back later.</div>';
          }
      ?>

      <?php
      //New API Stuff
      $type = Input::get('type');
      $api = "https://api.userspice.com/api/v2/";
      if (isset($offline_development) && $offline_development == true) {
        $api = "https://localhost/bugs/api/v2/";
        usSuccess("In offline development api mode");
      }

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
          if($settings->bleeding_edge == 2){
            $data['dev'] = "true";
          }
          $payload = json_encode($data);



          //attach encoded JSON string to the POST fields
          curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
          //set the content type to application/json
          curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
          //return response instead of outputting
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          if (isset($offline_development) && $offline_development == true) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            // Add verbose debug output in dev mode
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            $verbose = fopen('php://temp', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $verbose);
          }

          //execute the POST request
          $result = curl_exec($ch);

          // Get the HTTP response code
          $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


          if (isset($offline_development) && $offline_development == true) {
            dump("HTTP Response Code: " . $httpCode);
            rewind($verbose);
            $verboseLog = stream_get_contents($verbose);
            dump("Verbose cURL output: " . $verboseLog);
            dump("Raw Response: " . $result);
          }

          //close cURL resource
          curl_close($ch);

          $result = json_decode($result);


          if (isset($result->next_ver) && $result->next_ver != '') {
            // Convert versions to comparable format and check if current version is newer
            $currentVersion = preg_replace('/[^\\d.]+/', '', $user_spice_ver);
            $nextVersion = preg_replace('/[^\\d.]+/', '', $result->next_ver);

            if (version_compare($currentVersion, $nextVersion) >= 0) {
              die("Your current version ($currentVersion) is equal to or newer than the available update ($nextVersion). No update needed.");
            }
            if ($result->bleeding_edge == 1 && $settings->bleeding_edge == 0) {
              die("$result->next_ver is a bleeding edge update and is not ready for automatic install. Please check back later.");
            }
            //dev mode can download experimental updates or bleeding edge
            if ($result->bleeding_edge == 2 && ($settings->bleeding_edge != 2 && $settings->bleeding_edge != 1)) {
              die("$result->next_ver is an experimental update and is not ready for automatic install. Please check back later.");
            }
            if ($result->no_update > 0) {
              if ($result->no_update == 1) {
                die("$result->next_ver must be installed manually from UserSpice.com/updates");
              } elseif ($result->no_update == 2) {
                die('The updater itself must be updated, please install the Updater Plugin and run it from Spice Shaker');
              }
            } else { //do the update
              echo "Update found... $result->next_ver released on $result->released.<br>";
              spiceUpdateBegins();
              $failRan = false;
              if (file_exists($abs_us_root . $us_url_root . 'usupdate.zip')) {
                unlink($abs_us_root . $us_url_root . 'usupdate.zip');
              }
              $zipFile = $abs_us_root . $us_url_root . 'usupdate.zip';
              echo 'Creating zip file...';
              logger($user->data()->id, "$result->next_ver", 'Creating zip file');
              $extractPath = $abs_us_root . $us_url_root;
              $zip_resource = fopen($zipFile, 'w');
              $url = 'https://github.com/mudmin/releases/raw/master/updates/' . $result->next_file;
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
                echo 'Error :- ' . curl_error($ch_start);
                logger($user->data()->id, "$result->next_ver", 'Curl error' . curl_error($ch_start));
              }
              curl_close($ch_start);

              $zip = new ZipArchive();

              if ($zip->open($zipFile) !== true) {

                if (file_exists($zipFile)) {
                  $zip->close();
                  unlink($zipFile);
                }
                echo 'Error :- Unable to open the Zip File';
                logger($user->data()->id, "$result->next_ver", 'Unable to open the Zip File');
                if (!$failRan) {
                  spiceUpdateFail();
                  $failRan = true;
                }
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

                if (file_exists($zipFile)) {

                  unlink($zipFile);
                }
                spiceUpdateSuccess();
                logger($user->data()->id, "$result->next_ver", $result->message);
                logger($user->data()->id, "$result->next_ver", 'Running migration script(s)');

                Redirect::to($us_url_root . 'users/updates/index.php?auto=1');
              } else {
                if (file_exists($zipFile)) {
                  $zip->close();
                  @unlink($zipFile);
                }

                logger($user->data()->id, "$result->next_ver", 'Hash match failed');
                if (!$failRan) {
                  spiceUpdateFail();
                  $failRan = true;
                }
                echo "<br>The hash does not match. This means one of 2 things. Either the file on the server has been tampered with or (more likely) the file was
            updated and we forgot to update the hash. Please fill out a bug report. You can still download this plugin at $url if you wish.";
              }
              echo '<br>Deleting zip file';
              logger($user->data()->id, "$result->next_ver", 'Deleting zip file');
              if (file_exists($zipFile)) {
                @unlink($zipFile);
              }
            }
          }
        }
      } //end if key check

      ?>
      </h4>

      <?php if ($update_available && $settings->spice_api != '') { ?>
        <br>
        <div class="text-center">
          <form class="" action="" method="post">
            <input type="submit" name="sysup" value="Download & Install Updates" class="btn btn-primary"><br>
            It's always a good idea to backup UserSpice before updating.
          </form>
        </div>
        <br>
      <?php } elseif ($settings->spice_api == '') {
        echo "<h4 align='center'>You cannot download automatic updates because you have not entered your free API key in the dashboard</h4><br>";
      } ?>
      <br><br>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12 text-center">
    Any messages below this are from ACTIVE plugins that are checking to make sure they have the latest database updates.
    <?php $plugins = $db->query('SELECT * FROM us_plugins WHERE last_check < ? AND status = ?', [date('Y-m-d H:i:s', strtotime('-3 hours')), 'active'])->results();
    foreach ($plugins as $p) {
      echo "<br>Checking $p->plugin ";
      if (file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $p->plugin . '/migrate.php')) {
        include $abs_us_root . $us_url_root . 'usersc/plugins/' . $p->plugin . '/migrate.php';
      }
      $db->update('us_plugins', $p->id, ['last_check' => date('Y-m-d H:i:s')]);
    } ?>
  </div>
</div>