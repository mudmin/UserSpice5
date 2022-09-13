<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?php echo $us_url_root; ?>users/admin.php">Dashboard</a></li>
        <li>Manage</li>
        <li class="active">Users</li>
      </ol>
    </div>
  </div>
</div>
</div>
</header>

<?php

//PHP Goes Here!
$errors = $successes = [];
$query = $db->query('SELECT * FROM email');
$results = $query->first();
$act = $results->email_act;
$form_valid = true;
$permOpsQ = $db->query('SELECT * FROM permissions');
$permOps = $permOpsQ->results();
$hooks = getMyHooks(['page' => 'admin.php?view=users']);
$validation = new Validate();
if (!empty($_POST)) {
    includeHook($hooks, 'post');
    //Manually Add User
    if (!empty($_POST['addUser'])) {
        $vericode_expiry = date('Y-m-d H:i:s', strtotime("+$settings->join_vericode_expiry hours", strtotime(date('Y-m-d H:i:s'))));
        $join_date = date('Y-m-d H:i:s');
        $fname = Input::get('fname');
        $lname = Input::get('lname');
        $email = Input::get('email');
        $username = Input::get('username');
        $token = $_POST['csrf'];

        if (!Token::check($token)) {
            include $abs_us_root.$us_url_root.'usersc/scripts/token_error.php';
        }

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
            'max' => 100,
          ],
          'lname' => [
            'display' => 'Last Name',
            'required' => true,
            'min' => 1,
            'max' => 100,
          ],
          'email' => [
            'display' => 'Email',
            'required' => true,
            'valid_email' => true,
            'unique' => 'users',
            'min' => 5,
            'max' => 100,
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
            if (isset($_SESSION['us_lang'])){
               $newLang = $_SESSION['us_lang'];
             } else {
              $newLang = $settings->default_language;
             }
             
            try {
                // echo "Trying to create user";
                $fields = [
            'username' => $username,
            'fname' => ucfirst(Input::get('fname')),
            'lname' => ucfirst(Input::get('lname')),
            'email' => Input::get('email'),
            'password' => password_hash(Input::get('password'), PASSWORD_BCRYPT, ['cost' => 12]),
            'permissions' => 1,
            'join_date' => $join_date,
            'email_verified' => 1,
            'vericode' => randomstring(15),
            'force_pr' => $settings->force_pr,
            'vericode_expiry' => $vericode_expiry,
            'oauth_tos_accepted' => true,
            'language' => $newLang,
          ];

                $activeCheck = $db->query('SELECT active FROM users');
                if (!$activeCheck->error()) {
                    $fields['active'] = 1;
                }

                $db->insert('users', $fields);
                $theNewId = $db->lastId();
                // bold($theNewId);
                $perm = Input::get('perm');
                $addNewPermission = ['user_id' => $theNewId, 'permission_id' => 1];
                $db->insert('user_permission_matches', $addNewPermission);
                include $abs_us_root.$us_url_root.'usersc/scripts/during_user_creation.php';
                if (isset($_POST['sendEmail'])) {
                    $userDetails = fetchUserDetails(null, null, $theNewId);
                    $params = [
              'username' => $username,
              'password' => Input::get('password'),
              'sitename' => $settings->site_name,
              'force_pr' => $settings->force_pr,
              'fname' => Input::get('fname'),
              'email' => rawurlencode($userDetails->email),
              'vericode' => $userDetails->vericode,
              'join_vericode_expiry' => $settings->join_vericode_expiry,
            ];
                    $to = rawurlencode($email);
                    $subject = html_entity_decode($settings->site_name, ENT_QUOTES);
                    $body = email_body('_email_adminUser.php', $params);
                    email($to, $subject, $body);
                }
                logger($user->data()->id, 'User Manager', "Added user $username.");
                Redirect::to($us_url_root.'users/admin.php?view=user&id='.$theNewId);
            } catch (Exception $e) {
                exit($e->getMessage());
            }
        }
    }
}
  $userData = fetchAllUsers('permissions DESC,id', false, false); //Fetch information for all users
  $showAllUsers = Input::get('showAllUsers');
  if ($showAllUsers == 1) {
      $userData = fetchAllUsers('permissions DESC,id', false, true);
  }
  $random_password = random_password();

  foreach ($validation->errors() as $error) {
      $errors[] = $error[0];
  }
  ?>

  <div class="content mt-3">
  <div class="row">
    <div class="col-12 mb-2">
    <h2>Manage Users</h2>
    <?php echo resultBlock($errors, $successes); ?>
    <?php includeHook($hooks, 'pre'); ?>
    <div class="w-100 text-right">
    <button class="btn btn-outline-dark" data-toggle="modal" data-target="#adduser"><i class="fa fa-plus"></i> Add User</button>
    </div>
    </div>
    <div class="col-12">
    <div class="card">
      <div class="card-body">
      <div class="allutable">
      <table id="userstable" class='table table-hover table-list-search'>
        <thead>
          <tr>
            <th>ID</th><th></th><th>Username</th><th>Name</th><th>Email</th><?php includeHook($hooks, 'body'); ?>
            <th>Last Sign In</th><?php if ($act == 1) {?><th>Verified</th><?php } ?><th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          //Cycle through users
          foreach ($userData as $v1) {
              ?>
            <tr>
              <td><a class="nounderline text-dark" href='admin.php?view=user&id=<?php echo $v1->id; ?>'><?php echo $v1->id; ?></a></td>
              <td><a class="nounderline text-danger" href='admin.php?view=user&id=<?php echo $v1->id; ?>'><?php if ($v1->force_pr == 1) {?><i class="fa fa-lock"></i><?php } ?></a></td>
              <td><a class="nounderline text-dark" href='admin.php?view=user&id=<?php echo $v1->id; ?>'><?php echo $v1->username; ?></a></td>
              <td><a class="nounderline text-dark" href='admin.php?view=user&id=<?php echo $v1->id; ?>'><?php echo $v1->fname; ?> <?php echo $v1->lname; ?></a></td>
              <td><a class="nounderline text-dark" href='admin.php?view=user&id=<?php echo $v1->id; ?>'><?php echo $v1->email; ?></a></td>
              <?php includeHook($hooks, 'bottom'); ?>
              <td><?php if ($v1->last_login != 0) {
                  echo $v1->last_login;
              } else {?> <i>Never</i> <?php } ?></td>
              <?php if ($act == 1) {?><td>
                <?php if ($v1->email_verified == 1) {
                  echo "<i class='fa fa-thumbs-o-up'></i>";
              } ?>
              </td><?php } ?>
              <td><i class="fa fa-fw fa-<?php if ($v1->permissions == 1) {?>un<?php } ?>lock"></i></td>
            </tr>
          <?php
          } ?>
        </tbody>
      </table>
      <?php if ($showAllUsers != 1) {?><a href="?view=users&showAllUsers=1" class="btn btn-primary nounderline pull-right">Show All Users</a><?php } ?>
      <?php if ($showAllUsers == 1) {?><a href="?view=users" class="btn btn-primary nounderline pull-right">Show Active Users Only</a><?php } ?>
    </div>
      </div>
    </div>
    </div>
    </div>


<div id="adduser" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">User Addition</h4>
        <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
      </div>
      <form class="form-signup mb-0" action="" method="POST">
      <div class="modal-body">

              <div class="form-group" id="username-group">
              <label>Username (<?php echo $settings->min_un; ?>-<?php echo $settings->max_un; ?> chars)<span id="usernameCheck" class="small ml-2"></span></label>
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
              <input  class="form-control" type="search" name="email" id="email" value="<?php if (!$form_valid && !empty($_POST)) {
              echo $email;
          } ?>" required autocomplete="off">
              </div>
              <div class="form-group">
              <label>Password (<?php echo $settings->min_pw; ?>-<?php echo $settings->max_pw; ?> chars)</label>
              <div class="input-group" data-container="body">
              <div class="input-group-append">
                <span class="input-group-text password_view_control" id="addon1"><span class="fa fa-eye"></span></span>
              </div>
                <input  class="form-control" type="password" name="password" id="password" <?php if ($settings->force_pr == 1) { ?>value="<?php echo $random_password; ?>" readonly<?php } ?> placeholder="Password" required autocomplete="off" aria-describedby="passwordhelp">
                <?php if ($settings->force_pr == 1) { ?>
                  <div class="input-group-append">
                  <span class="input-group-text" id="addon2"><a class="nounderline pwpopover" data-container="body" data-toggle="popover" data-placement="top" title="Why can't I edit this?" data-content="The Administrator has manual creation password resets enabled. If you choose to send an email to this user, it will supply them with the password reset link and let them know they have an account. If you choose to not, you should manually supply them with this password (discouraged)."><i class="fa fa-question"></i></a></span>
                  </div>
                <?php } ?>
              </div>
              </div>
              <div class="form-group">
              <label>Confirm Password</label>
              <div class="input-group" data-container="body">
                <div class="input-group-prepend">
                <span class="input-group-text password_view_control" id="addon1"><span class="fa fa-eye"></span></span>
                </div>
                <input  type="password" id="confirm" name="confirm" <?php if ($settings->force_pr == 1) { ?>value="<?php echo $random_password; ?>" readonly<?php } ?> class="form-control" autocomplete="off" placeholder="Confirm Password" required >
                <?php if ($settings->force_pr == 1) { ?>
                  <div class="input-group-append">
                  <span class="input-group-text" id="addon2"><a class="nounderline pwpopover" data-container="body" data-toggle="popover" data-placement="top" title="Why can't I edit this?" data-content="The Administrator has manual creation password resets enabled. If you choose to send an email to this user, it will supply them with the password reset link and let them know they have an account. If you choose to not, you should manually supply them with this password (discouraged)."><i class="fa fa-question"></i></a></span>
                  </div>
                <?php } ?>
              </div>
              </div>

              <?php
              include $abs_us_root.$us_url_root.'usersc/scripts/additional_join_form_fields.php';
              includeHook($hooks, 'form');

              ?>
              <label><input type="checkbox" name="sendEmail" id="sendEmail" /> Send Email?</label>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="csrf" value="<?php echo Token::generate(); ?>" />
                <input class='btn btn-primary submit' type='submit' id="addUser" name="addUser" value='Add User' />
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>


    <script type="text/javascript" src="js/pagination/datatables.min.js"></script>
    <script src="js/jwerty.js"></script>

    <script>
    $(document).ready(function() {
      jwerty.key('esc', function(){
        $('.modal').modal('hide');
      });
      $('#userstable').DataTable({"pageLength": 25,"stateSave": true,"aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]], "aaSorting": []});

      $('.password_view_control').hover(function () {
        $('#password').attr('type', 'text');
        $('#confirm').attr('type', 'text');
      }, function () {
        $('#password').attr('type', 'password');
        $('#confirm').attr('type', 'password');
      });


      $('[data-toggle="popover"], .pwpopover').popover();
      $('.pwpopover').on('click', function (e) {
        $('.pwpopover').not(this).popover('hide');
      });
      $('.modal').on('hidden.bs.modal', function () {
        $('.pwpopover').popover('hide');
      });
    });
    </script>


      <script type="text/javascript">
      $(document).ready(function(){
        var x_timer;
        $("#username").keyup(function (e){
          clearTimeout(x_timer);
          var username = $(this).val();
          if (username.length > 0) {
            x_timer = setTimeout(function(){
              check_username_ajax(username);
            }, 500);
          }
          else $('#usernameCheck').text('');
        });

        function check_username_ajax(username){
          $("#usernameCheck").html('Checking...');
          $.post('parsers/existingUsernameCheck.php', {'username': username}, function(response) {
            if (response == 'error') $('#usernameCheck').html('There was an error while checking the username.');
            else if (response == 'taken') { $('#usernameCheck').html('<i class="fa fa-times" style="color: red; font-size: 12px"></i> This username is taken.');
            $('#addUser').prop('disabled', true); }
            else if (response == 'valid') { $('#usernameCheck').html('<i class="fa fa-thumbs-o-up" style="color: green; font-size: 12px"></i> This username is not taken.');
            $('#addUser').prop('disabled', false); }
            else { $('#usernameCheck').html('');
            $('#addUser').prop('disabled', false); }
          });
        }
      });
      </script>
