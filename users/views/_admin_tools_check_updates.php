<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
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
  <h3 align="center">
    <?php
    require_once $abs_us_root.$us_url_root.'users/includes/user_spice_ver.php';
    $rc = @fsockopen("www.userspice.com", 80, $errno, $errstr, 1);
    if (is_resource($rc))  {
    define('REMOTE_VERSION', 'https://userspice.com/version/version.txt');
    $remoteVersion=trim(file_get_contents(REMOTE_VERSION));
    echo "You are running version ".$user_spice_ver."<br><br>";
    echo "The latest version is ".$remoteVersion."<br><br>";
    if(version_compare($remoteVersion, $user_spice_ver) ==  1){
      echo "Updates are available at <a href='https://www.userspice.com/updates'>UserSpice.com/updates</a><br>";
    } else {
      echo "You are running the latest version!";
    }
  }else{
    echo "We are sorry. UserSpice.com is not reachable by this server. Please try back later.";
  }
    ?>
  </h3>
</div>
