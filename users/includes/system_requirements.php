
<?php if(count(get_included_files()) ==1) die(); 
$rec = "8.2.0";
$current = phpversion();
//find the first version of php whose eol date is > today + 3 months
$searchQ = $db->query("SELECT * FROM us_php_eol WHERE eol_date > DATE_ADD(CURDATE(), INTERVAL 3 MONTH) ORDER BY eol_date ASC LIMIT 1");
$searchC = $searchQ->count();
if($searchC > 0){
    $rec = $searchQ->first()->release_version;
}
?>

<div class="row">
    <!-- System Requirements Card -->
    <div class="col-12 col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="card-title mb-0">System Requirement Check</h3>
            </div>
            <div class="card-body">
                <?php
                $php_ver = "8.0.0";
                if(!isset($app_name)){
                    $app_name = "UserSpice";
                }
                // Check to make sure php is version is good enough
                // Set your required PHP version in the install_settings file
                if (version_compare($current, $php_ver, '<')) {
                    // php version isn't high enough
                    //The system is designed to do a full stop of you don't meet the minimum PHP version
                    ?>
                    <div class="alert alert-danger" role="alert">We're sorry, but your PHP version is too old for UserSpice to function. Please update to PHP <?= $rec ?> or later to
                        continue. <a href='http://php.net/' target='_blank'>PHP Website</a></div>
                    <?php
                } else {
                ?>
                <p>Your PHP version meets the minimum system requirements of <?= $php_ver ?> or later, but you need to
                    make sure your system meets all the rest of the requirements. If you see any red in the table below,
                    please correct those issues before installing.</p>

                <table class="table table-striped sys-requirements-table">
                    <thead class="table-dark">
                    <tr>
                        <th width="50%">Requirement</th>
                        <th width="50%">State</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            PHP version >= <?= $php_ver ?>
                        </td>
                        <td class="fw-bold">
                            <?php 
                            if (version_compare($current, $php_ver, '<')) {
                                echo '<span class="text-danger">No</span>';
                                $errors = 1;
                            } elseif (version_compare($current, $rec, '>=')) {
                                echo '<span class="text-success">Ideal ('.$current.')</span>';
                                $errors = 0;
                            } else {
                                echo '<span class="text-success">Yes</span>';
                                $errors = 0;
                            } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            XML support
                        </td>
                        <td class="fw-bold">
                            <?php if (extension_loaded('xml')) {
                                echo '<span class="text-success">Available</span>';
                                $errors = 0;
                            } else {
                                echo '<span class="text-danger">Unavailable</span>';
                                $errors = 1;
                            } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            MySQLi support
                        </td>
                        <td class="fw-bold">
                            <?php if (function_exists('mysqli_connect')) {
                                echo '<span class="text-success">Available</span>';
                                $errors = 0;
                            } else {
                                echo '<span class="text-danger">Unavailable</span>';
                                $errors = 1;
                            } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            PDO support
                        </td>
                        <td class="fw-bold">
                            <?php if (class_exists('PDO')) {
                                echo '<span class="text-success">Available</span>';
                                $errors = 0;
                            } else {
                                echo '<span class="text-danger">Unavailable</span>';
                                $errors = 1;
                            } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Is <?= $config_file ?> writeable?
                        </td>
                        <td class="fw-bold">
                            <?php
                            clearstatcache();
                            if (@file_exists($config_file) && @is_writable($config_file)) {
                                echo '<span class="text-success">Writeable</span>';
                            } else {
                                $errors = 1;
                                ?>
                                <span class="text-danger">Unwriteable</span><br>
                                <small class="text-muted">It is really important that you be able to write to the init file! If you don't know
                                how to chmod your init file, <a href="//userspice.com/installation-issues/" target="_blank">please read this guide
                                    at UserSpice.com.</a></small>
                            <?php } ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Recommended Settings Card -->
    <div class="col-12 col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="card-title mb-0">Additional Recommended Settings</h3>
            </div>
            <div class="card-body">
                <p>
                    <?= $app_name ?> will most likely work regardless of the settings below, however these settings are
                    suggested.
                </p>
                <table class="table table-striped sys-requirements-table">
                    <thead class="table-dark">
                    <tr>
                        <th width="50%">Setting</th>
                        <th width="25%">Recommended</th>
                        <th width="25%">Actual</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td>PHP >= <?=$rec?></td>
                        <td>YES</td>
                        <td class="fw-bold">
                            <?php if (version_compare($current, $rec, '<')) {
                                echo '<span class="text-danger">NO</span>';
                                $phpWarn = 1;
                            } else {
                                echo '<span class="text-success">YES</span>';
                                $phpWarn = 0;
                            } ?>
                        </td>
                    </tr>
                      <tr>
                          <td>
                              CURL Enabled (For Updates and Plugins)
                          </td>
                          <td>
                              YES
                          </td>
                          <td class="fw-bold">
                              <?php if (extension_loaded("CURL") == true) {
                                  echo '<span class="text-success">YES</span>';
                              } else {
                                  echo '<span class="text-danger">NO</span>';
                              } ?>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              Zip Enabled (For Updates and Plugins)
                          </td>
                          <td>
                              YES
                          </td>
                          <td class="fw-bold">
                              <?php if (extension_loaded("ZIP") == true) {
                                  echo '<span class="text-success">YES</span>';
                              } else {
                                  echo '<span class="text-danger">NO</span>';
                              } ?>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              UserSpice Folder Writeable
                          </td>
                          <td>
                              YES
                          </td>
                          <td class="fw-bold">
                              <?php if (@is_writeable("../z_us_root.php") == true) {
                                  echo '<span class="text-success">YES</span>';
                              } else {
                                  echo '<span class="text-danger">NO</span>';
                              } ?>
                          </td>
                      </tr>
                    <?php

                    function get_php_setting($val) {
                        $r = (ini_get($val) == '1' ? 1 : 0);
                        return $r ? 'ON' : 'OFF';
                    }

                    $php_recommended_settings = array(
                        array('Safe Mode', 'safe_mode', 'OFF'),
                        array('Display Errors (Recommended during Development)', 'display_errors', 'ON'),
                        array('File Uploads', 'file_uploads', 'ON'),
                        array('Register Globals', 'register_globals', 'OFF'),
                        array('Output Buffering', 'output_buffering', 'OFF'),
                        array('Session Auto Start', 'session.auto_start', 'OFF'),
                    );

                    foreach ($php_recommended_settings as $phprec) {
                        ?>
                        <tr>
                            <td>
                                <?= $phprec[0]; ?>
                            </td>
                            <td>
                                <?= $phprec[2]; ?>
                            </td>
                            <td class="fw-bold">
                                <?php if (get_php_setting($phprec[1]) == $phprec[2]) {
                                    echo '<span class="text-success">' . get_php_setting($phprec[1]) . '</span>';
                                } else {
                                    echo '<span class="text-danger">' . get_php_setting($phprec[1]) . '</span>';
                                } ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Error Messages Row -->
<div class="row mt-3">
    <div class="col-12">
        <?php if ($errors === 1) { ?>
            <div class="alert alert-danger" role="alert">
                You have errors listed in the System Requirement Check that must be corrected
                before continuing. If you have an unwritable <?= $config_file ?>, it is suggested that you chmod
                that file to 666 for installation and then chmod it to 644 after installation. <a
                        href="//userspice.com/installation-issues/" target="_blank">please read this guide</a>.
            </div>
        <?php } ?>

        <?php if ($phpWarn === 1) { ?>
            <div class="alert alert-primary" role="alert">Your PHP is out of date and you are using an unsupported version.
                UserSpice will work fine, but if you have the option to update to 7.4 or greater, it is strongly
                suggested that you do.
            </div>
        <?php } ?>
    </div>
</div>