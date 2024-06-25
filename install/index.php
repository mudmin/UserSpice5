<?php

require_once("includes/header.php");
include "../users/includes/user_spice_ver.php";

?>

<div class="container">
    <div class="row justify-content-center my-4">
        <div class="col-6">
            <div class="list-group list-group-horizontal-xl">
                <div class="list-group-item list-group-item-action active">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Step 1</h5>
                    </div>
                    <p class="mb-1"><?= $step1 ?></p>
                </div>
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Step 2</h5>
                    </div>
                    <p class="mb-1"><?= $step2 ?></p>
                </div>
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Step 3</h5>
                    </div>
                    <p class="mb-1"><?= $step3 ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php
    define('REMOTE_VERSION', 'http://userspice.com/version/version.txt');
    $remoteVersion=trim(file_get_contents(REMOTE_VERSION));
    if(version_compare($remoteVersion, $user_spice_ver) ==  1) { ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            The latest version is <?=$remoteVersion?>. <a href="https://www.userspice.com" class="alert-link">Download</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid p-2">
            <h1 class="display-5 fw-bold mb-4">Welcome to <?= $app_name . " " . $user_spice_ver ?></h1>
            <p class="fs-4">This program will walk you through the entire process of configuring <?= $app_name ?>. Before you
                proceed, you might want to make sure that you're ready to do the install.</p>
            <p class="fs-4">If you have not already created a new <font color="red"><strong>database</strong></font>, please do so
                at this time. Make sure that you have the Host Name, Username, Password, and Database name handy, as you
                will need them to complete the install. Note that if your database user has permission to create
                databases on your server, the installer can create the database for you in the next step.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h3 class="mt-4">System Requirement Check</h3>
            <?php
            // Check to make sure php is version is good enough
            // Set your required PHP version in the install_settings file
            if (version_compare(phpversion(), $php_ver, '<')) {
                // php version isn't high enough
                //The system is designed to do a full stop of you don't meet the minimum PHP version
                ?>
                <div class="alert alert-danger" role="alert">
                    We're sorry, but your PHP version is out of date. Please update to PHP <?= $php_ver ?> or later to
                    continue.
                </div>
                <?php
            } else {
            ?>
            <p>Your PHP version meets the minimum system requirements of <?= $php_ver ?> or later, but you need to
                make sure your system meets all the rest of the requirements. If you see any red in the table below,
                please correct those issues before installing.</p>

            <table class="table table-striped table-hover">
                <thead class="thead-dark">
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
                    <td class="font-weight-bold">
                        <?php if (phpversion() < $php_ver) {
                            echo '<span class="text-danger">No</span>';
                            $errors = 1;
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
                    <td class="font-weight-bold">
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
                    <td class="font-weight-bold">
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
                    <td class="font-weight-bold">
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
                    <td class="font-weight-bold">
                        <?php
                        clearstatcache();
                        if (@file_exists($config_file) && @is_writable($config_file)) {
                            echo '<span class="text-success">Writeable</span>';
                        } else {
                            $errors = 1;
                            ?>
                            <span class="text-danger">Unwriteable</span><br>
                            It is really important that you be able to write to the init file! If you don't know
                            how to chmod your init file, <a href="//userspice.com/installation-issues/" target="_blank">please read this guide
                                at UserSpice.com.</a>
                        <?php } ?>
                    </td>
                </tr>
                </tbody>
            </table>
            <?php } ?>

            <h3 class="mt-5">Additional Recommended Settings</h3>

            <p>
                <?= $app_name ?> Will most likely work regardless of the settings below, however these settings are
                suggested.
            </p>
            <table class="table table-striped table-hover" width="100%">
                <thead class="thead-dark">
                <tr>
                    <th width="50%">Setting</th>
                    <th width="25%">Recommended</th>
                    <th width="25%">Actual</th>
                </tr>
                </thead>
                <tbody>
                  <tr>
                      <td>
                          CURL Enabled (For Updates and Plugins)
                      </td>
                      <td>
                          YES
                      </td>
                      <td class="font-weight-bold">
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
                      <td class="font-weight-bold">
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
                      <td class="font-weight-bold">
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
                        <td class="font-weight-bold">
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
                <tr>
                    <td>PHP > 7.1.0</td>
                    <td>YES</td>
                    <td class="font-weight-bold">
                        <?php if (version_compare(phpversion(), '7.1.0', '<')) {
                            echo '<span class="text-danger">NO</span>';
                            $phpWarn = 1;
                        } else {
                            echo '<span class="text-success">YES</span>';
                            $phpWarn = 0;
                        } ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php if ($errors === 0) { ?>
        <div class="row mt-4 mb-5">
            <div class="col-12">
                  <p class="text-center">
                    <strong>By clicking continue, you agree with the terms of the <a href="license.php" target="_blank"><?= $app_name ?> License.</a></strong>
                  </p>
                  <p class="text-center"><a href="step2.php" class="btn btn-success">Continue</a></p>
                </div>
            </div>
        </div>
    <?php } elseif ($errors === 1) { ?>
        <div class="alert alert-danger" role="alert">
            You have errors listed in the System Requirement Check that must be corrected
            before continuing. If you have an unwritable <?= $config_file ?>, it is suggested that you chmod
            that file to 666 for installation and then chmod it to 644 after installation. <a
                    href="//userspice.com/installation-issues/" target="_blank">please read this guide</a>.
        </div>
    <?php } ?>

    <?php if ($phpWarn === 1) { ?>
        <div class="alert alert-primary" role="alert">Your PHP is out of date and you are using an unsupported version.
            UserSpice will work fine, but if you have the option to update to 7.1 or greater, it is strongly
            suggested that you do.
        </div>
    <?php } ?>

</div>

<?php require_once("includes/footer.php");
