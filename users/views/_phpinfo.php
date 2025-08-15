<?php
if (in_array($user->data()->id, $master_account) && hasPerm(2)) {
    $config_file = $abs_us_root . $us_url_root . "users/init.php";
?>


    <div class="row">
        <div class="col-12">
            <!-- jump to phpinfo -->
            <a href="#phpinfo" class="btn btn-primary mb-3">Jump to PHP Info</a>
            <?php include($abs_us_root . $us_url_root . 'users/includes/system_requirements.php'); ?>


        </div>
        <div class="col-12" id="phpinfo">
            <?php phpinfo(); ?>
        </div>
    </div>
    <style>
        .sys-requirements-table {
            font-size: 1.5rem;
        }

        body {
            background-color: white !important;
        }
    </style>
<?php
}
