<?php if($user->isLoggedIn()){ ?>
<li class="nav-item"><a class="nav-link" href="<?=$us_url_root?>users/account.php"><i class="fa fa-fw fa-user"></i> <?php echo echousername($user->data()->id);?></a></li>

     <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
          <i class="fa fa-fw fa-cog"></i>
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="<?=$us_url_root?>"><i class="fa fa-fw fa-home"></i> Home</a>
        <a class="dropdown-item" href="<?=$us_url_root?>users/account.php"><i class="fa fa-fw fa-user"></i> Account</a>
        <div class='dropdown-divider'></div>

        <?php if (hasPerm([2],$user->data()->id)){ ?>
        <a class="dropdown-item" href="<?=$us_url_root?>users/admin.php"><i class="fa fa-fw fa-cogs"></i> Admin Dashboard</a>
        <a class="dropdown-item" href="<?=$us_url_root?>users/admin.php?view=users"><i class="fa fa-fw fa-user"></i> User Management</a>
        <a class="dropdown-item" href="<?=$us_url_root?>users/admin.php?view=permissions"><i class="fa fa-fw fa-lock"></i> Page Permissions</a>
        <a class="dropdown-item" href="<?=$us_url_root?>users/admin.php?view=pages"><i class="fa fa-fw fa-wrench"></i> Page Management</a>
        <?php if($settings->messaging == 1){?><a class="dropdown-item" href="<?=$us_url_root?>users/admin.php?view=messages"><i class="fa fa-fw fa-envelope"></i> Message System</a><?php } ?>
        <a class="dropdown-item" href="<?=$us_url_root?>users/admin.php?view=logs"><i class="fa fa-fw fa-search"></i> System Logs</a>
          <?php } // is user an admin ?>
        <div class='dropdown-divider'></div>
        <a class="dropdown-item" href="<?=$us_url_root?>users/logout.php"><i class="fa fa-fw fa-sign-out"></i> Logout</a>
      </div>  <!-- close tag for User dropdown menu -->
    </li>

				<?php }else{ // no one is logged in so display default items ?>
					<li><a href="<?=$us_url_root?>users/login.php" class=""><i class="fa fa-sign-in"></i> Login</a></li>
					<li><a href="<?=$us_url_root?>users/join.php" class=""><i class="fa fa-plus-square"></i> Register</a></li>
					<li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-life-ring"></i> Help <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?=$us_url_root?>users/forgot_password.php"><i class="fa fa-wrench"></i> Forgot Password</a></li>
							<?php if ($email_act){ //Only display following menu item if activation is enabled ?>
								<li><a href="<?=$us_url_root?>users/verify_resend.php"><i class="fa fa-exclamation-triangle"></i> Resend Activation Email</a></li>
							<?php }?>
						</ul>
					</li>
				<?php } //end of conditional for menu display ?>
