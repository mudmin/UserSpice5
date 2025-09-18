<?php
//we will turn off some advanced things like pagination datatables and the more complicated views for > 2000 users
//beginning with version 5.5.5, there is now a setting in general settings that will allow you to turn off the full list of users and provide faster performance.
$maxUsers = 2000;
$errors = $successes = [];
$act = $db->query('SELECT * FROM email')->first();
$act = $act->email_act;
$form_valid = true;
$permOps = $db->query('SELECT * FROM permissions')->results();

$hooks = getMyHooks(['page' => 'admin.php?view=users']);
$validation = new Validate();
$random_password = random_password();

if (!empty($_POST)) {
  if (!Token::check(Input::get('csrf'))) {
    include $abs_us_root . $us_url_root . 'usersc/scripts/token_error.php';
  }
  includeHook($hooks, 'post');
  //Manually Add User
  if (!empty($_POST['addUser'])) {
    $vericode_expiry = date('Y-m-d H:i:s', strtotime("+$settings->join_vericode_expiry hours", strtotime(date('Y-m-d H:i:s'))));
    $join_date = date('Y-m-d H:i:s');
    $fname = Input::get('fname');
    $lname = Input::get('lname');
    $email = Input::get('email');
    $username = Input::get('username');
    $password = Input::get('password');
    $vericode = uniqid().randomstring(15);
    $form_valid = false; // assume the worst
    $validation->check($_POST, [
      'username' => ['display' => 'Username', 'required' => true, 'min' => $settings->min_un, 'max' => $settings->max_un, 'unique' => 'users'],
      'fname' => ['display' => 'First Name', 'required' => true, 'min' => 1, 'max' => 200],
      'lname' => ['display' => 'Last Name', 'required' => true, 'min' => 1, 'max' => 200],
      'email' => ['display' => 'Email', 'required' => true, 'valid_email' => true, 'unique' => 'users', 'min' => 4, 'max' => 200],
      'password' => ['display' => 'Password', 'required' => true, 'min' => $settings->min_pw, 'max' => $settings->max_pw],
      'confirm' => ['display' => 'Confirm Password', 'required' => true, 'matches' => 'password'],
    ]);
    if ($eventhooks = getMyHooks(['page' => 'createAttempt'])) {
      includeHook($eventhooks, 'body');
    }
    if ($validation->passed()) {
      $form_valid = true;
      $newLang = isset($_SESSION['us_lang']) ? $_SESSION['us_lang'] : $settings->default_language;
      try {
        $fields = ['username' => $username, 'fname' => $fname, 'lname' => $lname, 'email' => $email, 'password' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 13]), 'permissions' => 1, 'join_date' => $join_date, 'email_verified' => 1, 'vericode' => $vericode, 'force_pr' => $settings->force_pr, 'vericode_expiry' => $vericode_expiry, 'oauth_tos_accepted' => true, 'language' => $newLang, 'active' => 1];
        $db->insert('users', $fields);
        $theNewId = $db->lastId();
        $addNewPermission = ['user_id' => $theNewId, 'permission_id' => 1];
        $db->insert('user_permission_matches', $addNewPermission);
        include $abs_us_root . $us_url_root . 'usersc/scripts/during_user_creation.php';
        if (isset($_POST['sendEmail'])) {
          $params = ['username' => $username, 'password' => $password, 'sitename' => $settings->site_name, 'force_pr' => $settings->force_pr, 'fname' => $fname, 'email' => rawurlencode($email), 'vericode' => $vericode, 'join_vericode_expiry' => $settings->join_vericode_expiry];
          $to = rawurlencode($email);
          $subject = html_entity_decode($settings->site_name, ENT_QUOTES);
          $body = email_body('_email_adminUser.php', $params);
          email($to, $subject, $body);
        }
        logger($user->data()->id, 'User Manager', "Added user $username.");
        usSuccess("$username Created");
        Redirect::to($us_url_root . 'users/admin.php?view=user&id=' . $theNewId);
      } catch (Exception $e) {
        exit($e->getMessage());
      }
    }
  }
}
// Display validation errors
foreach ($validation->errors() as $error) {
  usError($error);
}
?>

<div class="row">
  <div class="col-12 mb-2">
    <h2>Manage Users</h2>
    <?php includeHook($hooks, 'pre'); ?>
    <div class="row" style="margin-top:1vw;">
      <div class="col-12 text-end">
        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#adduser"><i class="fa fa-plus"></i> Add User</button>
      </div>
    </div>
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <table id="userstable-ssp" class='table table-hover table-striped table-list-search'>
          <thead>
            <tr>
              <th>ID</th>
              <th></th>
              <th>Username</th>
              <th>Name</th>
              <th>Email</th>
              <th>Last Sign In</th>
              <th>Permissions</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div id="adduser" class="modal fade" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserLabel">New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="form-signup mb-0" action="" method="POST">
        <div class="modal-body">
          <div class="mb-3" id="username-group">
            <label for="username">Username (<?= $settings->min_un; ?>-<?= $settings->max_un; ?> chars)</label>
            <input type="search" class="form-control" id="username" name="username" autocomplete="off" value="<?php if (!$form_valid && !empty($_POST)) { echo $username; } ?>" required>
          </div>
          <div class="mb-3" id="fname-group">
            <label for="fname">First Name</label>
            <input type="search" class="form-control" id="fname" name="fname" value="<?php if (!$form_valid && !empty($_POST)) { echo $fname; } ?>" required autocomplete="off">
          </div>
          <div class="mb-3" id="lname-group">
            <label for="lname">Last Name</label>
            <input type="search" class="form-control" id="lname" name="lname" value="<?php if (!$form_valid && !empty($_POST)) { echo $lname; } ?>" required autocomplete="off">
          </div>
          <div class="mb-3" id="email-group">
            <label for="email">Email</label>
            <input class="form-control" type="search" name="email" id="email" value="<?php if (!$form_valid && !empty($_POST)) { echo $email; } ?>" required autocomplete="off">
          </div>
          <div class="mb-3">
            <label for="password">Password (<?= $settings->min_pw; ?>-<?= $settings->max_pw; ?> chars)</label>
            <div class="input-group">
              <input class="form-control" type="password" name="password" id="password" <?php if ($settings->force_pr == 1) { ?> value="<?= $random_password; ?>" readonly<?php } ?> placeholder="Password" required autocomplete="off">
              <span class="input-group-text password_view_control" style="cursor: pointer;"><i class="fa fa-eye"></i></span>
              <?php if ($settings->force_pr == 1) { ?>
                <span class="input-group-text"><a class="nounderline pwpopover" data-bs-toggle="tooltip" title="The Administrator has manual creation password resets enabled..."><i class="fa fa-question"></i></a></span>
              <?php } ?>
            </div>
          </div>
          <div class="mb-3">
            <label for="confirm">Confirm Password</label>
            <div class="input-group">
              <input type="password" id="confirm" name="confirm" <?php if ($settings->force_pr == 1) { ?> value="<?= $random_password; ?>" readonly <?php } ?> class="form-control" autocomplete="off" placeholder="Confirm Password" required>
              <span class="input-group-text password_view_control" style="cursor: pointer;"><i class="fa fa-eye"></i></span>
               <?php if ($settings->force_pr == 1) { ?>
                <span class="input-group-text"><a class="nounderline pwpopover" data-bs-toggle="tooltip" title="The Administrator has manual creation password resets enabled..."><i class="fa fa-question"></i></a></span>
              <?php } ?>
            </div>
          </div>
          <?php
          include $abs_us_root . $us_url_root . 'usersc/scripts/additional_join_form_fields.php';
          includeHook($hooks, 'form');
          ?>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="sendEmail" id="sendEmail" />
            <label class="form-check-label" for="sendEmail">Send Email?</label>
          </div>
        </div>
        <div class="modal-footer">
          <?=tokenHere();?>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input class='btn btn-primary' type='submit' id="addUser" name="addUser" value='Add User' />
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?= $us_url_root ?>users/js/pagination/datatables.min.js"></script>
<script>
  $(document).ready(function() {
    // New DataTables Initializer for Server-Side Processing
    $('#userstable-ssp').DataTable({
      "pageLength": 25,
      "stateSave": true,
      "aLengthMenu": [
        [25, 50, 100, -1],
        [25, 50, 100, "All"]
      ],
      "aaSorting": [],
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url": "<?= $us_url_root ?>users/parsers/ssp_users.php",
        "type": "GET",
        "data": {
          "token": "<?= Token::generate() ?>"
        }
      },
      // Disable sorting on columns that don't correspond to a single DB field
      "columnDefs": [
        { "targets": [1, 7], "orderable": false }
      ]
    });

    // Existing JS for the modal
    $('.password_view_control').hover(function() {
      $('#password').attr('type', 'text');
      $('#confirm').attr('type', 'text');
    }, function() {
      $('#password').attr('type', 'password');
      $('#confirm').attr('type', 'password');
    });

    $('[data-toggle="popover"], .pwpopover').popover();
    $('.pwpopover').on('click', function(e) {
      $('.pwpopover').not(this).popover('hide');
    });
    $('.modal').on('hidden.bs.modal', function() {
      $('.pwpopover').popover('hide');
    });
  });
</script>