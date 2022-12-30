<!-- This is just an example for doing your own file-based menu. You have access to all the UserSpice functions to build something  as simple or as complicated as you want.  -->
<ul class='us_menu horizontal dark'  style=' z-index: 50;' id='us_menu_1_638b71f2ed026'>
  <div class='us_brand full_screen'>
    <a href="<?=$us_url_root?>" >
      <img src="<?=$us_url_root?>users/images/logo.png" />
    </div>
    <div class='flex-grow-1'></div>

    <div class='us_menu_mobile_wrapper'>
      <div class='us_brand'><a href="<?=$us_url_root?>" >
        <img src="<?=$us_url_root?>users/images/logo.png" />
      </div>

      <div class='us_menu_mobile_control' data-target='1_638b71f2ed026'>
        <i class='fa fa-bars'></i>
      </div>
    </div>
    <?php if(isset($user) && $user->isLoggedIn()) { ?>
      <li class=''>
        <a class='' href='<?=$us_url_root?>users/account.php' >
          <i class='fa fa-user'></i>
          <span class='labelText'>The Admin</span></a>
        </li>

        <li class='dropdown'><a class='sub-toggle' href='<?=$us_url_root?>' id='menu_1_638b71f2ed026_dropdown_1' role='button' aria-haspopup='true' aria-expanded='false' data-toggle='dropdown' data-target='#menu_1_638b71f2ed026_dropdown_1'>
          <i class='fa fa-cogs'></i>
          <span class='labelText'></span>
          <span class='caret'></span>
        </a>

        <ul class='us_sub-menu' aria-labelledby='menu_1_dropdown_1' style=' z-index: 50;' >
          <li class=''>
            <a class='' href='<?=$us_url_root?>' ><i class='fa fa-home'></i>
              <span class='labelText'>Home</span>
            </a>
          </li>
          <li class=''><a class='' href='<?=$us_url_root?>users/account.php' >
            <i class='fa fa-user'></i>
            <span class='labelText'>Account</span>
          </a>
        </li>
        <div class='dropdown-divider'></div>
        <li class=''>
          <a class='' href='<?=$us_url_root?>users/admin.php' >
            <i class='fa fa-cogs'></i>
            <span class='labelText'>Admin Dashboard</span>
          </a>
        </li>
        <li class=''>
          <a class='' href='<?=$us_url_root?>users/admin.php?view=users' >
            <i class='fa fa-user'></i>
            <span class='labelText'>User Management</span>
          </a>
        </li>
        <li class=''>
          <a class='' href='<?=$us_url_root?>users/admin.php?view=permissions' >
            <i class='fa fa-lock'></i>
            <span class='labelText'>Permissions Management</span>
          </a>
        </li>
        <li class=''>
          <a class='' href='<?=$us_url_root?>users/admin.php?view=pages' >
            <i class='fa fa-wrench'></i>
            <span class='labelText'>Page Management</span>
          </a>
        </li>
        <li class=''>
          <a class='' href='<?=$us_url_root?>users/admin.php?view=logs' >
            <i class='fa fa-search'></i>
            <span class='labelText'>System Logs</span>
          </a>
        </li>
        <div class='dropdown-divider'></div>
        <li class=''>
          <a class='' href='<?=$us_url_root?>users/logout.php' >
            <i class='fa fa-sign-out'></i>
            <span class='labelText'>Logout</span>
          </a>
        </li>
      </ul>
    </li>
  <?php }else{ ?>

    <li class=''>
      <a class='' href='<?=$us_url_root?>users/login.php' >
        <i class='fa fa-sign-in'></i>
        <span class='labelText'>Login</span>
      </a>
    </li>
    <li class=''>
      <a class='' href='<?=$us_url_root?>users/join.php' >
        <i class='fa fa-sign-in'></i>
        <span class='labelText'>Join</span>
      </a>
    </li>

  <?php } ?>
</ul>
