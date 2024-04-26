<?php
if (in_array($user->data()->id, $master_account) && hasPerm(2)) {
    $config_file = $abs_us_root . $us_url_root . "users/init.php";
?>


    <div class="row">
        <div class="col-12 col-md-6">
        <?php phpinfo(); ?>
           
        </div>
        <div class="col-12 col-md-6">
        <?php include($abs_us_root . $us_url_root . 'users/includes/system_requirements.php'); ?>
        </div>
    </div>
<style>
    .sys-requirements-table{
        font-size: 1.5rem;
    }
</style>
<?php
}
