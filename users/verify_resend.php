<?php
$debug_mode = false;
require_once '../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

// Event hook for hashing of emails in the db (v5.3.8+)
$query = $db->query("SELECT * FROM email");
$results = $query->first();
$act = $results->email_act;
$msg = lang("ERR_EM_VER");

if ($act != 1) {
  usError($msg);
  Redirect::to($us_url_root.'index.php');
}

if ($user->isLoggedIn()) $user->logout();

$token = Input::get('csrf');
if (Input::exists()) {
    if (!Token::check($token)) {
        include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
    }
}

$email_sent = FALSE;
$errors = array();

if (Input::exists('post')) {
    $hooks = getMyHooks(['page'=>'verifyResendSubmit']);
    includeHook($hooks, 'body');

    if (!isset($hookData['overrideEmailVerification'])) {
      $email = Input::get('email');
      $fuser = new User($email);
      $check = $db->query("SELECT id FROM users WHERE email = ? AND email_verified = 1", [$email])->count();
      $validate = new Validate();
      $validation = $validate->check($_POST, array(
          'email' => array(
              'display'     => lang("GEN_EMAIL"),
              'valid_email' => true,
              'required'    => true,
          ),
      ));
    } else {
      $fields = ["validation", "fuser", "check", "email"];
      foreach ($fields as $f) {
        if (isset($hookData[$f])) {
          $$f = $hookData[$f];
        }
      }
    }

    if ($validation->passed()) {
        if ($fuser->exists()) {
          if ($check > 0) {
            $string = lang("VER_SUC");
            usSuccess($string);
            Redirect::to($us_url_root."users/login.php");
          }
          $vericode = randomstring(15);
          $vericode_expiry = date("Y-m-d H:i:s", strtotime("+$settings->join_vericode_expiry hours"));
          $db->update('users', $fuser->data()->id, ['vericode' => $vericode, 'vericode_expiry' => $vericode_expiry]);
          $options = array(
              'fname'                => $fuser->data()->fname,
              'email'                => $email,
              'vericode'             => $vericode,
              'join_vericode_expiry' => $settings->join_vericode_expiry
          );
          $encoded_email = rawurlencode($email);
          $subject = lang("EML_VER") . " @ " . date("Y-m-d H:i:s");
          $body = email_body('_email_template_verify.php', $options);
          $email_sent = email($email, $subject, $body);
          $es = json_encode($email_sent);
          logger($fuser->data()->id, "User", "Requested a new verification email. $es");
          if (!$email_sent) {
              $errors[] = lang("ERR_EMAIL");
          }
        } else {
            $errors[] = lang("ERR_EM_DB");
        }
    } else {
        $errors = $validation->errors();
    }
}

if ($debug_mode) {
    echo '<div class="container mt-3"><div class="row"><div class="col-12"><pre>';
    var_dump($_GET);
    var_dump($_POST);
    var_dump($token);
    if (isset($validation)) { var_dump($validation); }
    var_dump($errors);
    echo '</pre></div></div></div>';
}

$verifyCardContent = ($email_sent)
  ? $abs_us_root.$us_url_root.'users/views/_verify_resend_success.php'
  : $abs_us_root.$us_url_root.'users/views/_verify_resend.php';
?>
<!-- Single Responsive Card for Email Verification -->
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6 mb-3">
      <div class="card">
         <div class="card-header">
            Email Verification
         </div>
         <div class="card-body">
             <?php require $verifyCardContent; ?>
         </div>
      </div>
    </div>
  </div>
</div>
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; ?>
