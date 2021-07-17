<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
        <li>Settings</li>
        <li><a href="<?=$us_url_root?>users/admin.php?view=email">Email</a></li>
        <li class="active">Email Test</li>
      </ol>
    </div>
  </div>
</div>
</div>
</header>

<div class="content mt-3">
  <h2>Email Test</h2>
  It's a good idea to test to make sure you can actually receive system emails before forcing your users to verify theirs. <br><br>
  <strong>DEVELOPER NOTE 1:</strong>
  If you are having difficulty with your email configuration set Debug Level
  to a non-zero value. This is a development-platform-ONLY setting - be
  sure to set it back to zero on any live platform -
  otherwise you would open significant security holes.<br><br>
  <strong>DEVELOPER NOTE 2:</strong>
  Gmail is significantly easier to use for sending mail than your average SMTP mailer.<br><br>
  <br>
  <?php
  if (!empty($_POST)){
    $to = $_POST['test_acct'];
    $subject = 'Testing Your Email Settings!';
    $body = 'This is the body of your test email';
    $mail_result=email($to,$subject,$body);

    if($mail_result){
      echo '<div class="alert alert-success" role="alert">Mail sent successfully</div><br/>';
    }else{
      echo '<div class="alert alert-danger" role="alert">Mail ERROR</div><br/>';
    }
  }
  ?>

  <form class="" name="test_email" action="" method="post">
    <label>Send test to (Ideally different than your from address):
      <input required size='50' class='form-control' type='text' name='test_acct' value='' /></label>

      <label>&nbsp;</label><br />
      <input class='btn btn-primary' type='submit' value='Send A Test Email' class='submit' />
    </form>

  </div>
