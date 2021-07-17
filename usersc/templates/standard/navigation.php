<?php
require_once($abs_us_root . $us_url_root . 'users/includes/template/database_navigation_prep.php');
?>
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark" style="margin-bottom:2em;">
    <a href="<?= $us_url_root ?>index.php"><img src="<?= $us_url_root ?>users/images/logo.png"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample03">
      <ul class="navbar-nav ml-auto">
        <?php
        if ($settings->navigation_type == 0) {
          $query = $db->query("SELECT * FROM email");
          $results = $query->first();

          //Value of email_act used to determine whether to display the Resend Verification link
          $email_act = $results->email_act;

          require_once($abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/assets/functions/nav.php');
        }


        if ($settings->navigation_type == 1) {
          require_once($abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/assets/functions/dbnav.php');
        }
        ?>
      </ul>
    </div>
  </div>
</nav>
<?php
    if(isset($_GET['err'])){
      err("<font color='red'>".$err."</font>");
    }

    if(isset($_GET['msg'])){
      err($msg);
    }
