<?php
$query = $db->query('SELECT * FROM email');
$results = $query->first();
$errors = $successes = [];
// What to look for
$search = "Redirect::to($us_url_root.'users/verify.php');";
// Read from file
$lines = file('init.php');
foreach ($lines as $line) {
  if (strpos($line, $search) !== false) {
    bold('<br><br>You have a bug in your init.php that cannot be patched automatically.<br><br>Please replace verify.php with users/verify.php towards the bottom of your init.php file.');
  }
}

$urlProtocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';

if (!empty($_POST)) {
  $token = $_POST['csrf'];
  if (!Token::check($token)) {
    include $abs_us_root.$us_url_root.'usersc/scripts/token_error.php';
  }

  if ($results->smtp_server != $_POST['smtp_server']) {
    $smtp_server = Input::get('smtp_server');
    $fields = ['smtp_server' => $smtp_server];
    $db->update('email', 1, $fields);
    $successes[] = 'Updated smtp_server';
    logger($user->data()->id, 'Email Settings', "Updated smtp_server from $results->smtp_server to $smtp_server.");
  } else {
  }
  if ($results->website_name != $_POST['website_name']) {
    $website_name = Input::get('website_name');
    $fields = ['website_name' => $website_name];
    $db->update('email', 1, $fields);
    $successes[] = 'Updated website_name';
    logger($user->data()->id, 'Email Settings', "Updated website_name from $results->website_name to $website_name.");
  } else {
  }
  if ($results->smtp_port != $_POST['smtp_port']) {
    $smtp_port = Input::get('smtp_port');
    $fields = ['smtp_port' => $smtp_port];
    $db->update('email', 1, $fields);
    $successes[] = 'Updated smtp_port';
    logger($user->data()->id, 'Email Settings', "Updated smtp_port from $results->smtp_port to $smtp_port.");
  } else {
  }
  if ($results->email_login != $_POST['emx']) {
    $email_login = Input::get('emx');
    $fields = ['email_login' => $email_login];
    $db->update('email', 1, $fields);
    $successes[] = 'Updated email_login';
    logger($user->data()->id, 'Email Settings', 'Updated email_login.');
  } else {
  }
  if ($results->email_pass != $_POST['emp']) {
    $email_pass = Input::get('emp');
    $fields = ['email_pass' => $email_pass];
    $db->update('email', 1, $fields);
    $successes[] = 'Updated email_pass';
    logger($user->data()->id, 'Email Settings', 'Updated email_pass.');
  } else {
  }
  if ($results->from_name != $_POST['from_name']) {
    $from_name = Input::get('from_name');
    $fields = ['from_name' => $from_name];
    $db->update('email', 1, $fields);
    $successes[] = 'Updated from_name';
    logger($user->data()->id, 'Email Settings', "Updated from_name from $results->from_name to $from_name.");
  } else {
  }
  if ($results->from_email != $_POST['frome']) {
    $from_email = Input::get('frome');
    $fields = ['from_email' => $from_email];
    $db->update('email', 1, $fields);
    $successes[] = 'Updated from_email';
    logger($user->data()->id, 'Email Settings', "Updated from_email from $results->from_email to $from_email.");
  } else {
  }
  if ($results->authtype != $_POST['authtype']) {
    $authtype = Input::get('authtype');
    $fields = ['authtype' => $authtype];
    $db->update('email', 1, $fields);
    $successes[] = 'Updated authtype';
    logger($user->data()->id, 'Email Settings', "Updated authtype from $results->authtype to $authtype.");
  } else {
  }
  if ($results->transport != $_POST['transport']) {
    $transport = Input::get('transport');
    $fields = ['transport' => $transport];
    $db->update('email', 1, $fields);
    $successes[] = 'Updated transport';
    logger($user->data()->id, 'Email Settings', "Updated transport from $results->transport to $transport.");
  } else {
  }
  if ($results->verify_url != $_POST['verify_url']) {
    $verify_url = Input::get('verify_url');
    if (substr($verify_url, -1) != '/') {
      $verify_url = $verify_url.'/';
      $successes[] = 'Auto corrected verify_url to append trailing slash';
    }
    $fields = ['verify_url' => $verify_url];
    $db->update('email', 1, $fields);
    $successes[] = 'Updated verify_url';
    logger($user->data()->id, 'Email Settings', "Updated verify_url from $results->verify_url to $verify_url.");
  } else {
  }
  if ($results->email_act != $_POST['email_act']) {
    //dump($_POST['email_act']);
    $email_act = Input::get('email_act');
    $fields = ['email_act' => $email_act];
    $db->update('email', 1, $fields);
    $successes[] = 'Updated email_act';
    logger($user->data()->id, 'Email Settings', "Updated email_act from $results->email_act to $email_act.");
  } else {
  }
  if ($results->debug_level != $_POST['debug_level']) {
    $debug_level = Input::get('debug_level');
    $fields = ['debug_level' => $debug_level];
    $db->update('email', 1, $fields);
    $successes[] = 'Updated debug_level';
    logger($user->data()->id, 'Email Settings', "Updated email_act from $results->debug_level to $debug_level.");
  } else {
  }
  if ($results->isSMTP != $_POST['isSMTP']) {
    $isSMTP = Input::get('isSMTP');
    $fields = ['isSMTP' => $isSMTP];
    $db->update('email', 1, $fields);
    $successes[] = 'Updated isSMTP';
    logger($user->data()->id, 'Email Settings', "Updated isSMTP from $results->isSMTP to $isSMTP.");
  } else {
  }
  if ($results->isHTML != $_POST['isHTML']) {
    $isHTML = Input::get('isHTML');
    $fields = ['isHTML' => $isHTML];
    $db->update('email', 1, $fields);
    $successes[] = 'Updated isHTML';
    logger($user->data()->id, 'Email Settings', "Updated isHTML from $results->isHTML to $isHTML.");
  } else {
  }
  if ($results->useSMTPauth != $_POST['useSMTPauth']) {
    $useSMTPauth = Input::get('useSMTPauth');
    $fields = ['useSMTPauth' => $useSMTPauth];
    $db->update('email', 1, $fields);
    $successes[] = 'Updated useSMTPauth';
    logger($user->data()->id, 'Email Settings', "Updated useSMTPauth from $results->useSMTPauth to $useSMTPauth.");
  } else {
  }
  if (isset($_POST['update_and_test'])) {
    Redirect::to($us_url_root.'users/admin.php?view=email_test');
  } else {
    //  Redirect::to($us_url_root."users/admin.php?view=email");
  }
  $query = $db->query('SELECT * FROM email');
  $results = $query->first();
}

?>
  <form name='update' action='' method='post'>
    <h2 class="mb-3">Email Server Settings</h2>
    <p class="text-dark">
      These settings control all things email-related for the server including emailing your users and verifying the user's email address.
      You must obtain and verify all settings below for YOUR email server or hosting provider. Encryption with TLS is STRONGLY recommended,
      followed by SSL. No encryption is like shouting your login credentials out into a crowded field and is not supported for now.
    </p>
    <p class="text-dark">It is <strong>HIGHLY</strong> recommended that you test your email settings before turning on the feature to require new users to verify their email</p>

    <?=resultBlock($errors, $successes); ?>
    <div class="row">
      <div class="col-sm-6">

        <div class="card no-padding">
          <div class="card-body">

            <div class="form-group">
              <label>Website Name:</label>
              <input size='50' class='form-control' type='text' autocomplete="off" name='website_name' value='<?=$results->website_name; ?>' />
            </div>
            <div class="form-group">
              <label>SMTP Server:</label>
              <input size='50' class='form-control' type='text' autocomplete="off" name='smtp_server' value='<?=$results->smtp_server; ?>' />
            </div>
            <div class="form-group">
              <label>SMTP Port:</label>
              <input size='50' class='form-control' type='text' autocomplete="off" name='smtp_port' value='<?=$results->smtp_port; ?>' />
            </div>
            <label>Email Login/Username:</label>
            <input size='50' class='form-control' type='password' autocomplete="off" name='emx' value='<?=$results->email_login; ?>' />
            <div class="form-group">
              <label>Email Password:</label>
              <input size='50' class='form-control' type='password' autocomplete="off" name='emp' value='<?=$results->email_pass; ?>' />
            </div>
            <div class="form-group">
              <label>From Name (For Sent Emails):</label>
              <input size='50' class='form-control' type='text' autocomplete="off" name='from_name' value='<?=$results->from_name; ?>' />
            </div>
            <div class="form-group">
              <label>From Email (For Sent Emails):</label>
              <input size='50' class='form-control' type='text' autocomplete="off" name='frome' value='<?=$results->from_email; ?>' />
            </div>
            <div class="form-group">
              <label>PHPMailer Authtype: (Typically CRAM-MD5, LOGIN, PLAIN, or XOAUTH2)</label>
              <input size='50' class='form-control' type='text' autocomplete="off" name='authtype' value='<?=$results->authtype; ?>' />
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card no-padding">
          <div class="card-body">
            <div class="form-group">
              <label>Transport</label>
              <select class="form-control" name="transport">
                <option value="tls" <?php if ($results->transport == 'tls') {
                  echo 'selected="selected"';
                } ?> >TLS (encrypted)</option>
                <option value="ssl" <?php if ($results->transport == 'ssl') {
                  echo 'selected="selected"';
                } ?> >SSL (encrypted, but weak)</option>
              </select>
            </div>
            <div class="form-group">
              <label>Email Debugging Level <a href="#!" tabindex="-1"  data-trigger="focus" data-bs-trigger="focus" class="nounderline"  title="0=Off, 1=Client Messages, 2=Normal Debug, 3=More Verbose, 4=Extremely Verbose.
                Debugging should be off in production projects for security reasons"><i class="fa fa-question-circle offset-circle"></i></a></label>
                <select class="form-control" width="100%" name="debug_level">
                  <option value="<?=$results->debug_level; ?>"><?=$results->debug_level; ?></option>
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                </select>
              </div>
              <div class="form-group">
                <label>Use isSMTP Feature <a href="#!" tabindex="-1"  data-trigger="focus" data-bs-trigger="focus" class="nounderline"  title="Use this if your email keeps failing and you know your credentials are correct."><i class="fa fa-question-circle offset-circle"></i></a></label>
                <select class="form-control" width="100%" name="isSMTP">
                  <?php if ($results->isSMTP == 0) {
                    echo "<option value='0'>No</option>";
                    echo "<option value='1'>Yes</option>";
                  } else {
                    echo "<option value='1'>Yes</option>";
                    echo "<option value='0'>No</option>";
                  } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Use SMTP Authentication: (Almost always, yes)</label>
                <select class="form-control" width="100%" name="useSMTPauth">
                  <?php if ($results->useSMTPauth == 'false') {
                    echo "<option value='false'>No</option>";
                    echo "<option value='true'>Yes</option>";
                  } else {
                    echo "<option value='true'>Yes</option>";
                    echo "<option value='false'>No</option>";
                  } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Send email as HTML by default</label>
                <select class="form-control" width="100%" name="isHTML">
                  <?php if ($results->isHTML == 'false') {
                    echo "<option value='false'>No</option>";
                    echo "<option value='true'>Yes</option>";
                  } else {
                    echo "<option value='true'>Yes</option>";
                    echo "<option value='false'>No</option>";
                  } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Root URL of your UserSpice install <a href="#!" tabindex="-1"  data-trigger="click" data-bs-trigger="click" class="nounderline"  title="Including http or https protocol (VERY Important). Default location would be: <?=$urlProtocol.$_SERVER['HTTP_HOST'].$us_url_root; ?>"><i class="fa fa-question-circle offset-circle"></i></a></label>
                <small class="form-text text-muted">
                  Put http://yourdomain.com/ with the final / below
                </small>
                <input size='50' class='form-control' type='text' name='verify_url' value='<?=$results->verify_url; ?>' />
              </div>
              <div class="form-group">
                <label for="email_act">Require User to Verify Their Email</label>
                <label for="email_act_yes"><input type="radio" id="email_act_yes" name="email_act" value="1" <?php echo ($results->email_act == 1) ? 'checked' : ''; ?> size="25"/>&nbsp;Yes</label>&nbsp;
                <label for="email_act_no"><input type="radio" id="email_act_no" name="email_act" value="0" <?php echo ($results->email_act == 0) ? 'checked' : ''; ?> size="25"/>&nbsp;No</label>
              </div>
              <input type="hidden" name="csrf" value="<?=Token::generate(); ?>" />
              <div class="text-center">
                <input class='btn btn-primary' name="update_only" type='submit' value='Update Email Settings' class='submit' />
                <input class='btn btn-danger' name="update_and_test" type='submit' value='Update and Test Email Settings' class='submit' />
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
