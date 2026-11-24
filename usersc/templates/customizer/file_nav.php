<!-- if you use this feature, copy this file to file_nav_custom.php so it doesn't get overwritten during updates. -->
<!-- This is just an example for doing your own file-based menu. You have access to all the UserSpice functions to build something  as simple or as complicated as you want.  -->
<?php
// Mirrors the markup users/classes/Menu.php generates so menu.css/menu.js and the
// accessibility fixes apply: a <ul> holds only <li>, the logo has alt text, the
// hamburger is a real <button>, and icons are hidden from screen readers.
$fileNavLogoAlt = safeReturn(lang("MENU_LOGO_HOME", [$settings->site_name ?? ""]), true); // site_name is stored escaped
?>
<nav>
<ul class='us_menu horizontal dark' style=' z-index: 50;' id='us_menu_1_638b71f2ed026' data-menu_id='1'>
  <li class='us_menu_chrome'>
    <div class='us_brand full_screen'>
      <a href="<?=$us_url_root?>"><img src="<?=$us_url_root?>users/images/logo.png" alt="<?=$fileNavLogoAlt?>" /></a>
    </div>
    <div class='flex-grow-1'></div>

    <div class='us_menu_mobile_wrapper'>
      <div class='us_brand'>
        <a href="<?=$us_url_root?>"><img src="<?=$us_url_root?>users/images/logo.png" alt="<?=$fileNavLogoAlt?>" /></a>
      </div>

      <button type='button' class='us_menu_mobile_control' data-target='1_638b71f2ed026' aria-controls='us_menu_1_638b71f2ed026' aria-expanded='false' aria-label='<?=safeReturn(lang("MENU_MENU"))?>'>
        <i class='fa fa-bars' aria-hidden='true'></i>
      </button>
    </div>
  </li>
  <?php if(isset($user) && $user->isLoggedIn()) { ?>
    <li class=''>
      <a class='' href='<?=$us_url_root?>users/account.php'>
        <i class='fa fa-user' aria-hidden='true'></i>
        <span class='labelText'>The Admin</span>
      </a>
    </li>

    <li class='dropdown'><a class='sub-toggle' href='<?=$us_url_root?>' id='menu_1_638b71f2ed026_dropdown_1' role='button' aria-expanded='false' aria-label='<?=safeReturn(lang("MENU_MENU"))?>'>
        <i class='fa fa-cogs' aria-hidden='true'></i>
        <span class='labelText'></span>
        <span class='caret fa fa-caret-down' aria-hidden='true'></span>
      </a>

      <ul class='us_sub-menu' aria-labelledby='menu_1_638b71f2ed026_dropdown_1' style=' z-index: 50;'>
        <li class=''>
          <a class='' href='<?=$us_url_root?>'>
            <i class='fa fa-home' aria-hidden='true'></i>
            <span class='labelText'>Home</span>
          </a>
        </li>
        <li class=''>
          <a class='' href='<?=$us_url_root?>users/account.php'>
            <i class='fa fa-user' aria-hidden='true'></i>
            <span class='labelText'>Account</span>
          </a>
        </li>
        <li class='dropdown-divider' aria-hidden='true'></li>
        <li class=''>
          <a class='' href='<?=$us_url_root?>users/admin.php'>
            <i class='fa fa-cogs' aria-hidden='true'></i>
            <span class='labelText'>Admin Dashboard</span>
          </a>
        </li>
        <li class=''>
          <a class='' href='<?=$us_url_root?>users/admin.php?view=users'>
            <i class='fa fa-user' aria-hidden='true'></i>
            <span class='labelText'>User Management</span>
          </a>
        </li>
        <li class=''>
          <a class='' href='<?=$us_url_root?>users/admin.php?view=permissions'>
            <i class='fa fa-lock' aria-hidden='true'></i>
            <span class='labelText'>Permissions Management</span>
          </a>
        </li>
        <li class=''>
          <a class='' href='<?=$us_url_root?>users/admin.php?view=pages'>
            <i class='fa fa-wrench' aria-hidden='true'></i>
            <span class='labelText'>Page Management</span>
          </a>
        </li>
        <li class=''>
          <a class='' href='<?=$us_url_root?>users/admin.php?view=logs'>
            <i class='fa fa-search' aria-hidden='true'></i>
            <span class='labelText'>System Logs</span>
          </a>
        </li>
        <li class='dropdown-divider' aria-hidden='true'></li>
        <li class=''>
          <a class='' href='<?=$us_url_root?>users/logout.php'>
            <i class='fa fa-sign-out' aria-hidden='true'></i>
            <span class='labelText'>Logout</span>
          </a>
        </li>
      </ul>
    </li>
  <?php }else{ ?>

    <li class=''>
      <a class='' href='<?=$us_url_root?>users/login.php'>
        <i class='fa fa-sign-in' aria-hidden='true'></i>
        <span class='labelText'>Login</span>
      </a>
    </li>
    <li class=''>
      <a class='' href='<?=$us_url_root?>users/join.php'>
        <i class='fa fa-sign-in' aria-hidden='true'></i>
        <span class='labelText'>Join</span>
      </a>
    </li>

  <?php } ?>
</ul>
</nav>
