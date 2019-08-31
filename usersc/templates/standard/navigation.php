<!-- Grab the initial menu work that UserSpice does for you -->
<?php require_once($abs_us_root . $us_url_root . 'users/includes/template/database_navigation_prep.php'); ?>

<!-- This file is a way of allowing the end user to customize stuff -->
<!-- without getting in the middle of the whole template itself -->
<?php require_once($abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/assets/functions/style.php'); ?>
<?php


if (file_exists($abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/info.xml')) {
  $xml = simplexml_load_file($abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/info.xml');
  $navstyle = $xml->navstyle;
}

if ($navstyle == 'Default') {
  ?>
  <!-- Set your logo and the "header" of the navigation here -->
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <a href="<?= $us_url_root ?>index.php"><img src="<?= $us_url_root ?>users/images/logo.png"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample03">
      <ul class="navbar-nav ml-auto">

        <!-- Here's where it gets tricky.  We need to concatenate together the html to make the menu. -->
        <!-- Basically you will be editing each function into the "style" of your menu -->
        <?php
        if ($settings->navigation_type == 0) {
          $query = $db->query("SELECT * FROM email");
          $results = $query->first();

          //Value of email_act used to determine whether to display the Resend Verification link
          $email_act = $results->email_act;

          // Set up notifications button/modal
          if ($user->isLoggedIn()) {
            if ($dayLimitQ = $db->query('SELECT notif_daylimit FROM settings', array()))
            $dayLimit = $dayLimitQ->results()[0]->notif_daylimit;
            else
            $dayLimit = 7;

            // 2nd parameter- true/false for all notifications or only current
            $notifications = new Notification($user->data()->id, false, $dayLimit);
          }
          require_once($abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/assets/functions/nav.php');
        }


        if ($settings->navigation_type == 1) {
          require_once($abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/assets/functions/dbnav.php');
        }
        ?>


        <!-- Close everything out and leave the hooks so error and bold messages work on your template -->
      </ul>
    </div>
  </div>
</nav>
<?php

} elseif ($navstyle == 'Left Side') {

  if ($settings->navigation_type == 0) {
    $query = $db->query("SELECT * FROM email");
    $results = $query->first();

    //Value of email_act used to determine whether to display the Resend Verification link
    $email_act = $results->email_act;

    // Set up notifications button/modal
    if ($user->isLoggedIn()) {
      if ($dayLimitQ = $db->query('SELECT notif_daylimit FROM settings', array()))
      $dayLimit = $dayLimitQ->results()[0]->notif_daylimit;
      else
      $dayLimit = 7;

      // 2nd parameter- true/false for all notifications or only current
      $notifications = new Notification($user->data()->id, false, $dayLimit);
    } ?>
    <body>
      <div class="col-md-3 float-left col-1 pl-0 pr-0 width collapse show" id="sidebar" aria-expanded="true">
        <div class="list-group border-0 card text-center text-md-left">
          <?php if($user->isLoggedIn()){ //anyone is logged in?>
            <a href="<?=$us_url_root?>" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-home"></i> <span class="d-none d-md-inline">Home</span></a>
            <?php if($settings->notifications==1) {?>
              <?php /*<li><a href="portal/'.PAGE_PATH.'#" id="notificationsTrigger" data-toggle="modal" data-target="#notificationsModal"><i class="fa fa-bell"></i> <span id="notifCount" class="badge" style="margin-top: -5px"><?= (($notifications->getUnreadCount() > 0) ? $notifications->getUnreadCount() : ''); ?></span></a></li>*/?>

              <a class="list-group-item d-inline-block collapsed" href="#" onclick="displayNotifications('new')" id="notificationsTrigger" data-toggle="modal" data-target="#notificationsModal"  style="text-decoration: none;"><span class="fa fa-bell-o"></span> <span id="notifCount" class="badge badge-pill badge-primary" style="margin-top: -5px;"><?= (int)$notifications->getUnreadCount(); ?></span> Notifications</a>
            <?php } ?>
            <a class="list-group-item d-inline-block collapsed" href="<?=$us_url_root?>users/account.php"><i class="fa fa-user"></i> <span class="d-none d-md-inline"><?php echo echousername($user->data()->id);?></span></a>
            <a href="#menu1" class="list-group-item d-inline-block collapsed" data-toggle="collapse" aria-expanded="false"><i class="fa fa-cog"></i> <span class="d-none d-md-inline"> Settings</span> </a>
            <div class="collapse" id="menu1" data-parent="#sidebar">
              <a href="<?=$us_url_root?>users/admin.php" class="list-group-item collapsed">Admin Dashboard</a>
              <a href="<?=$us_url_root?>users/admin.php?view=users" class="list-group-item collapsed">User Management</a>
              <a href="<?=$us_url_root?>users/admin.php?view=permissions" class="list-group-item collapsed">Page Permissions</a>
              <a href="<?=$us_url_root?>users/admin.php?view=pages" class="list-group-item collapsed">Page Management</a>
              <a href="<?=$us_url_root?>users/admin.php?view=logs" class="list-group-item collapsed">System Logs</a>
              <a href="<?=$us_url_root?>users/logout.php" class="list-group-item collapsed">Logout</a>
            </div>
          <?php } else { ?>
            <a href="#" class="list-group-item d-inline-block collapsed" data-parent="#sidebar"><i class="fa fa-home"></i> <span class="d-none d-md-inline">Home</span></a>
            <a href="<?=$us_url_root?>users/login.php" class="list-group-item d-inline-block collapsed"><i class="fa fa-sign-in"></i> Login</a>
            <a href="<?=$us_url_root?>users/join.php" class="list-group-item d-inline-block collapsed"><i class="fa fa-plus-square"></i> Register</a>
            <a href="#menu2" class="list-group-item d-inline-block collapsed" data-toggle="collapse" aria-expanded="false"><i class="fa fa-cog"></i> <span class="d-none d-md-inline">Help</span> </a>
            <div class="collapse" id="menu2" data-parent="#sidebar">
              <a href="<?=$us_url_root?>users/forgot_password.php"><i class="fa fa-wrench"></i> Forgot Password</a>
              <?php if ($email_act){ //Only display following menu item if activation is enabled ?>
                <a href="<?=$us_url_root?>users/verify_resend.php"><i class="fa fa-exclamation-triangle"></i> Resend Activation Email</a>
              <?php }?>
            </div>

          <?php } ?>
        </div>
      </div>
      <button class="hamburger hamburger--arrowalt is-active" data-target="#sidebar" data-toggle="collapse" type="button" style="float:left;display:flex;">
        <span class="hamburger-box">
          <span class="hamburger-inner"></span>
        </span>
      </button>

      <div class="" style="background-color: #023c73;">
        <div class="text-center">
          <a style="left:-35px;position: relative;" href="<?= $us_url_root ?>"><img style="" src="<?= $us_url_root ?>users/images/logo.png"></a>
        </div>
      </div>
    <?php }
    if ($settings->navigation_type == 1) {
      require_once($abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/assets/functions/dbnav.php');
    }
    ?>



  <?php } elseif ($navstyle == 'Right Side') {
    if ($settings->navigation_type == 0) {
      $query = $db->query("SELECT * FROM email");
      $results = $query->first();

      //Value of email_act used to determine whether to display the Resend Verification link
      $email_act = $results->email_act;

      // Set up notifications button/modal
      if ($user->isLoggedIn()) {
        if ($dayLimitQ = $db->query('SELECT notif_daylimit FROM settings', array()))
        $dayLimit = $dayLimitQ->results()[0]->notif_daylimit;
        else
        $dayLimit = 7;

        // 2nd parameter- true/false for all notifications or only current
        $notifications = new Notification($user->data()->id, false, $dayLimit);
      } ?>


      <body>

        <div class="col-md-3 float-right col-1 pl-0 pr-0 width collapse show" id="sidebarLeft" aria-expanded="true">
          <div class="list-group border-0 card text-center text-md-right">
            <?php if($user->isLoggedIn()){ //anyone is logged in?>
              <a href="<?=$us_url_root?>" class="list-group-item d-inline-block collapsed" data-parent="#sidebarLeft"><i class="fa fa-home"></i> <span class="d-none d-md-inline">Home</span></a>
              <?php if($settings->notifications==1) {?>
                <?php /*<li><a href="portal/'.PAGE_PATH.'#" id="notificationsTrigger" data-toggle="modal" data-target="#notificationsModal"><i class="fa fa-bell"></i> <span id="notifCount" class="badge" style="margin-top: -5px"><?= (($notifications->getUnreadCount() > 0) ? $notifications->getUnreadCount() : ''); ?></span></a></li>*/?>

                <a class="list-group-item d-inline-block collapsed" href="#" onclick="displayNotifications('new')" id="notificationsTrigger" data-toggle="modal" data-target="#notificationsModal"  style="text-decoration: none;"><span class="fa fa-bell-o"></span> <span id="notifCount" class="badge badge-pill badge-primary" style="margin-top: -5px;"><?= (int)$notifications->getUnreadCount(); ?></span> Notifications</a>
              <?php } ?>
              <a class="list-group-item d-inline-block collapsed" href="<?=$us_url_root?>users/account.php"><i class="fa fa-user"></i> <span class="d-none d-md-inline"><?php echo ucfirst(echousername($user->data()->id));?></span></a>
              <a href="#menu1" class="list-group-item d-inline-block collapsed" data-toggle="collapse" aria-expanded="false"><i class="fa fa-cog"></i> <span class="d-none d-md-inline"> Settings</span> </a>
              <div class="collapse" id="menu1" data-parent="#sidebarLeft">
                <a href="<?=$us_url_root?>users/admin.php" class="list-group-item collapsed">Admin Dashboard</a>
                <a href="<?=$us_url_root?>users/admin.php?view=users" class="list-group-item collapsed">User Management</a>
                <a href="<?=$us_url_root?>users/admin.php?view=permissions" class="list-group-item collapsed">Page Permissions</a>
                <a href="<?=$us_url_root?>users/admin.php?view=pages" class="list-group-item collapsed">Page Management</a>
                <a href="<?=$us_url_root?>users/admin.php?view=logs" class="list-group-item collapsed">System Logs</a>
                <a href="<?=$us_url_root?>users/logout.php" class="list-group-item collapsed">Logout</a>
              </div>
            <?php } else { ?>
              <a href="#" class="list-group-item d-inline-block collapsed" data-parent="#sidebarLeft"><i class="fa fa-home"></i> <span class="d-none d-md-inline">Home</span></a>
              <a href="<?=$us_url_root?>users/login.php" class="list-group-item d-inline-block collapsed"><i class="fa fa-sign-in"></i> Login</a>
              <a href="<?=$us_url_root?>users/join.php" class="list-group-item d-inline-block collapsed"><i class="fa fa-plus-square"></i> Register</a>
              <a href="#menu2" class="list-group-item d-inline-block collapsed" data-toggle="collapse" aria-expanded="false"><i class="fa fa-cog"></i> <span class="d-none d-md-inline">Help</span> </a>
              <div class="collapse" id="menu2" data-parent="#sidebarLeft">
                <a href="<?=$us_url_root?>users/forgot_password.php"><i class="fa fa-wrench"></i> Forgot Password</a>
                <?php if ($email_act){ //Only display following menu item if activation is enabled ?>
                  <a href="<?=$us_url_root?>users/verify_resend.php"><i class="fa fa-exclamation-triangle"></i> Resend Activation Email</a>
                <?php }?>
              </div>

            <?php } ?>
          </div>
        </div>
        <button class="hamburger hamburger--arrowalt-r is-active" data-target="#sidebarLeft" data-toggle="collapse" type="button" style="float:right;display: flex;">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
        <div class="" style="background-color: #023c73;">
          <div class="text-center">
            <a style="right:-35px;position: relative;" href="<?= $us_url_root ?>"><img style="" src="<?= $us_url_root ?>users/images/logo.png"></a>
          </div>
        </div>
      <?php }
      if ($settings->navigation_type == 1) {
        require_once($abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/assets/functions/dbnav.php');
      }
      ?>
    <?php } elseif ($navstyle == 'Parallax Side') {



    }
    if(isset($_GET['err'])){
      err("<font color='red'>".$err."</font>");
    }

    if(isset($_GET['msg'])){
      err($msg);
    }
