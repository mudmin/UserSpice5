<?php
//we will turn off some advanced things like pagination datatabels and the more complicated views for > 2000 users
//beginning with version 5.5.5, there is now a setting in general settings that will allow you to turn off the full list of users and provide faster performance.
$maxUsers = $settings->max_users_dt;
$errors = $successes = [];
$uCount = $db->query("SELECT count(*) as counter FROM users")->first()->counter;
$settings->uman_search = $maxUsers > 0 && $uCount > $maxUsers ? 1 : 0;

$act = $db->query('SELECT * FROM email')->first();
$act = $act->email_act;
$form_valid = true;
$permOps = $db->query('SELECT * FROM permissions')->results();

$hooks = getMyHooks(['page' => 'admin.php?view=users']);
$validation = new Validate();

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
      'username' => [
        'display' => 'Username',
        'required' => true,
        'min' => $settings->min_un,
        'max' => $settings->max_un,
        'unique' => 'users',
      ],
      'fname' => [
        'display' => 'First Name',
        'required' => true,
        'min' => 1,
        'max' => 200,
      ],
      'lname' => [
        'display' => 'Last Name',
        'required' => true,
        'min' => 1,
        'max' => 200,
      ],
      'email' => [
        'display' => 'Email',
        'required' => true,
        'valid_email' => true,
        'unique' => 'users',
        'min' => 4,
        'max' => 200,
      ],
      'password' => [
        'display' => 'Password',
        'required' => true,
        'min' => $settings->min_pw,
        'max' => $settings->max_pw,
      ],
      'confirm' => [
        'display' => 'Confirm Password',
        'required' => true,
        'matches' => 'password',
      ],
    ]);

    if ($eventhooks = getMyHooks(['page' => 'createAttempt'])) {
      includeHook($eventhooks, 'body');
    }

    if ($validation->passed()) {
      $form_valid = true;
      if (isset($_SESSION['us_lang'])) {
        $newLang = $_SESSION['us_lang'];
      } else {
        $newLang = $settings->default_language;
      }

      try {
        // echo "Trying to create user";
        $fields = [
          'username' => $username,
          'fname' => $fname,
          'lname' => $lname,
          'email' => $email,
          'password' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 13]),
          'permissions' => 1,
          'join_date' => $join_date,
          'email_verified' => 1,
          'vericode' => $vericode,
          'force_pr' => $settings->force_pr,
          'vericode_expiry' => $vericode_expiry,
          'oauth_tos_accepted' => true,
          'language' => $newLang,
          'active' => 1,
        ];

        $db->insert('users', $fields);
        $theNewId = $db->lastId();

        $perm = Input::get('perm');
        $addNewPermission = ['user_id' => $theNewId, 'permission_id' => 1];
        $db->insert('user_permission_matches', $addNewPermission);


        include $abs_us_root . $us_url_root . 'usersc/scripts/during_user_creation.php';
        if (isset($_POST['sendEmail'])) {

          $params = [
            'username' => $username,
            'password' => $password,
            'sitename' => $settings->site_name,
            'force_pr' => $settings->force_pr,
            'fname' => $fname,
            'email' => rawurlencode($email),
            'vericode' => $vericode,
            'join_vericode_expiry' => $settings->join_vericode_expiry,
          ];
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


// Include custom column configuration
include $abs_us_root . $us_url_root . 'usersc/includes/user_manager_columns.php';

// Get user data using the custom function
$userData = $user_manager_get_data($settings, $db, $uCount, $maxUsers);
$showAllUsers = $settings->uman_search == 0 ? Input::get('showAllUsers') : false;
$random_password = random_password();

foreach ($validation->errors() as $error) {
  usError($error);
}

?>
<div class="row">
  <div class="col-12 mb-2">
    <h2>Manage Users</h2>
    <small>You can customize which fields are used by editing <code>usersc/includes/user_manager_columns.php</code></small>
    <?php includeHook($hooks, 'pre'); ?>

    <div class="row" style="margin-top:1vw;">
      <div class="col-6">
        <?php if ($showAllUsers != 1 && $settings->uman_search < 1) { ?>
          <a href="?view=users&showAllUsers=1" class="btn btn-outline-primary btn-sm nounderline"><i class="fa fa-eye"></i> Show All Users</a>
        <?php } elseif($settings->uman_search < 1) { ?>
          <a href="?view=users" class="btn btn-outline-primary btn-sm nounderline"><i class="fa fa-eye-slash"></i> Hide Inactive Users</a>
        <?php } ?>
      </div>
      <div class="col-6 text-end">
        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#adduser"><i class="fa fa-plus"></i> Add User</button>
      </div>
    </div>
  <?php
  if($settings->uman_search == 1){ ?>
    <div class="row">
      <div class="col-12 col-sm-6 offset-sm-3">
        <form class="" action="" method="post">
          <?=tokenHere();?>
          <div class="input-group">
            <input type="text" name="searchTerm" value="" class="form-control" placeholder="Search for users to manage. Enter % for all users">
            <input type="submit" name="search" value="Search" class="btn btn-outline-primary" onclick="setTimeout(function() { $('#dt-search-0').val(''); }, 100);">
          </div>

          <small>Search by first name, last name, username, or email</small>
        </form>
      </div>
    </div>
  <?php } ?>
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <table id="userstable" class='table table-hover table-list-search'>
          <thead>
            <tr>
              <?php foreach ($user_manager_columns as $col_key => $col_title) {
                // Skip permissions column if not applicable
                if ($col_key == 'perms' && $uCount >= $maxUsers) continue;
              ?>
                <th><?php echo $col_title; ?></th>
              <?php } ?>
              <?php includeHook($hooks, 'body'); ?>
            </tr>
          </thead>
          <tbody>
            <?php
            //Cycle through users
            foreach ($userData as $v1) {
            ?>
              <tr>
                <?php foreach ($user_manager_columns as $col_key => $col_title) {
                  $cell_data = $user_manager_column_data($v1, $col_key);
                  // Skip columns that return null (like perms when not applicable)
                  if ($cell_data === null && $col_key == 'perms' && $uCount >= $maxUsers) continue;
                ?>
                  <td><?php echo $cell_data; ?></td>
                <?php } ?>
                <?php includeHook($hooks, 'bottom'); ?>
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

<div id="adduser" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">New User</h4>
        <button type="button" class="btn btn-outline-secondary float-right" data-bs-dismiss="modal">&times;</button>
      </div>

      <form class="form-signup mb-0" action="" method="POST">
        <div class="modal-body">

          <div class="form-group" id="username-group">
            <label>
              Username (<?php echo $settings->min_un; ?>-<?php echo $settings->max_un; ?> chars)<span id="usernameCheck" class="small ml-2"></span>
            </label>

            <input type="search" class="form-control" id="username" name="username" autocomplete="off" value="<?php if (!$form_valid && !empty($_POST)) {
                                                                                                                echo $username;
                                                                                                              } ?>" required>
          </div>

          <div class="form-group" id="fname-group">
            <label>First Name</label>

            <input type="search" class="form-control" id="fname" name="fname" value="<?php if (!$form_valid && !empty($_POST)) {
                                                                                        echo $fname;
                                                                                      } ?>" required autocomplete="off">
          </div>

          <div class="form-group" id="lname-group">
            <label>Last Name</label>

            <input type="search" class="form-control" id="lname" name="lname" value="<?php if (!$form_valid && !empty($_POST)) {
                                                                                        echo $lname;
                                                                                      } ?>" required autocomplete="off">
          </div>

          <div class="form-group" id="email-group">
            <label>Email</label>

            <input class="form-control" type="search" name="email" id="email" value="<?php if (!$form_valid && !empty($_POST)) {
                                                                                        echo $email;
                                                                                      } ?>" required autocomplete="off">
          </div>

          <div class="form-group">
            <label>
              Password (<?php echo $settings->min_pw; ?>-<?php echo $settings->max_pw; ?> chars)
            </label>

            <div class="input-group" data-container="body">
              <div class="input-group-append">
                <span class="input-group-text password_view_control" id="addon1">
                  <span class="fa fa-eye"></span>
                </span>
              </div>

              <input class="form-control" type="password" name="password" id="password" <?php if ($settings->force_pr == 1) { ?> value="<?php echo $random_password; ?>" readonly<?php } ?> placeholder="Password" required autocomplete="off" aria-describedby="passwordhelp">

              <?php if ($settings->force_pr == 1) { ?>
                <div class="input-group-append">
                  <span class="input-group-text" id="addon2">
                    <a class="nounderline pwpopover" data-container="body" data-toggle="popover" data-placement="top" title="Why can't I edit this?" data-bs-toggle="tooltip" title="The Administrator has manual creation password resets enabled. If you choose to send an email to this user, it will supply them with the password reset link and let them know they have an account. If you choose to not, you should manually supply them with this password (discouraged).">
                      <i class="fa fa-question"></i>
                    </a>
                  </span>
                </div>
              <?php } ?>

            </div>
          </div>
          <div class="form-group">
            <label>Confirm Password</label>
            <div class="input-group" data-container="body">
              <div class="input-group-prepend">
                <span class="input-group-text password_view_control" id="addon1">
                  <span class="fa fa-eye"></span>
                </span>
              </div>

              <input type="password" id="confirm" name="confirm" <?php if ($settings->force_pr == 1) { ?> value="<?php echo $random_password; ?>" readonly <?php } ?> class="form-control" autocomplete="off" placeholder="Confirm Password" required>

              <?php if ($settings->force_pr == 1) { ?>
                <div class="input-group-append">
                  <span class="input-group-text" id="addon2">
                    <a class="nounderline pwpopover" data-container="body" data-toggle="popover" data-placement="top" title="Why can't I edit this?" data-bs-toggle="tooltip" title="The Administrator has manual creation password resets enabled. If you choose to send an email to this user, it will supply them with the password reset link and let them know they have an account. If you choose to not, you should manually supply them with this password (discouraged).">
                      <i class="fa fa-question"></i>
                    </a>
                  </span>
                </div>
              <?php } ?>
            </div>
          </div>

          <?php
          include $abs_us_root . $us_url_root . 'usersc/scripts/additional_join_form_fields.php';
          includeHook($hooks, 'form');

          ?>
          <label>
            <input type="checkbox" name="sendEmail" id="sendEmail" /> Send Email?
          </label>

        </div>

        <div class="modal-footer">
          <input type="hidden" name="csrf" value="<?php echo Token::generate(); ?>" />
          <input class='btn btn-primary submit' type='submit' id="addUser" name="addUser" value='Add User' />
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
        </div>

      </form>
    </div>
  </div>
</div>

<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>" type="text/javascript" src="<?= $us_url_root ?>users/js/pagination/datatables.min.js"></script>
<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">
  $(document).ready(function() {
    $('#userstable').DataTable({
      "pageLength": 25,
      "stateSave": true,
      "aLengthMenu": [
        [25, 50, 100, -1],
        [25, 50, 100, "All"]
      ],
      "aaSorting": [],
      "initComplete": function() {
      // Clear the search box after DataTables has fully initialized
      this.api().search('').draw();
    }
    });

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