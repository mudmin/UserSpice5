<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
<meta charset="utf-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="css/dashboard/normalize.css">
  <link rel="stylesheet" href="css/dashboard/bootstrap.min.css">
  <link rel="stylesheet" href="<?=$us_url_root?>users/fonts/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/dashboard/style.css">

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
  <script src="js/jquery.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

<style>
.btn-circle.btn-lg {
  width: 40px;
  height: 40px;
  padding: 5px 8px;
  font-size: 12px;
  line-height: 1.33;
  border-radius: 25px;
}

form label {font-weight:600}

.feedback{position: fixed;}

.feedback.left{left:5px; bottom:15px}
.feedback.right{right:5px; bottom:15px}

.feedback .dropdown-menu{width: 290px;height: 250px;bottom: 50px;}
.feedback.left .dropdown-menu{ left: 0px}
.feedback.right .dropdown-menu{ right: 0px}
.feedback .hideme{ display: none}
</style>
</head>
<body>
<?php
  if($settings->messaging == 1){
    $msgQ = $db->query("SELECT id FROM messages WHERE msg_to = ? AND msg_read = 0 AND deleted = 0",array($user->data()->id));
    $msgC = $msgQ->count();
    if($msgC == 1){
      $grammar = 'Message';
    }else{
      $grammar = 'Messages';
    }
  }

  $dirs = glob($abs_us_root.$us_url_root.'usersc/plugins/*' , GLOB_ONLYDIR);
  $plugins = [];
  foreach($dirs as $d){
    $plugins[] = str_replace($abs_us_root.$us_url_root.'usersc/plugins/', "", $d);
    $thisPlugin = end($plugins);
    // if(!array_key_exists($thisPlugin,$usplugins)){
    //   $usplugins[$thisPlugin] = 2;
    //   write_php_ini($usplugins, $abs_us_root.$us_url_root.'usersc/plugins/plugins.ini.php');
    //   include $abs_us_root.$us_url_root.'usersc/plugins/'.$thisPlugin.'/install.php';
    // }
  }


?>

<?php

function activeDropdown($View, $dropId, $Area = false){
	$sttngsDown = ['general','reg','social','email'];
	$toolsDown = ['backup','updates','cron','forms','ip','messages','notifications','security_logs','sessions','logs','templates'];
  $addonsDown = ['plugins_config'];
	switch($dropId){

		case 'settings':
		if (in_array($View,$sttngsDown)){
			return ['show', 'true'];
		}
		return ['', 'false'];

		case 'tools':
		if (in_array($View,$toolsDown)){
			return ['show', 'true'];
		}
		return ['', 'false'];

    case 'addons':
    if (in_array($View,$addonsDown)){
      return ['show', 'true'];
    }
    return ['', 'false'];

    default:
    return ['','false'];;
	}

}

?>

  <!-- Left Panel -->

  <aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

      <div class="navbar-header">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars"></i>
        </button>
        <a class="navbar-brand" href="<?=$us_url_root?>index.php"><img src="images/logo.png" alt="Logo"></a>
        <a class="navbar-brand hidden" href="./"><img src="images/logo2.png" alt="Logo"></a>
      </div>

      <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">
         <li <?=($view) ? '' : 'class="active"' ;?>>
            <a href="admin.php"> <i class="menu-icon fa fa-dashboard"></i><?=lang("BE_DASH")?> </a>
          </li>
          <!-- <h3 class="menu-title">Settings</h3> -->
          <?php if(hasPerm([2],$user->data()->id)){?>
          <li class="menu-item-has-children dropdown <?=activeDropdown($view, 'settings')[0];?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="<?=activeDropdown($view, 'settings')[1];?>"> <i class="menu-icon fa fa-gear"></i><?=lang("BE_SETTINGS")?></a>
            <ul class="sub-menu children dropdown-menu <?=activeDropdown($view, 'settings')[0];?>">
              <?php if(checkAccess('view','general')){?> <li <?=($view == 'general') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-gears"></i><a href="admin.php?view=general"><?=lang("BE_GEN")?></a></li><?php } ?>
              <?php if(checkAccess('view','reg')){?> <li <?=($view == 'reg') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-users"></i><a href="admin.php?view=reg"><?=lang("BE_REG")?></a></li><?php } ?>
              <?php if(checkAccess('view','email')){?> <li <?=($view == 'email') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-envelope"></i><a href="admin.php?view=email"><?=lang("GEN_EMAIL")?></a></li><?php } ?>
              <?php if(checkAccess('view','nav')){?> <li <?=($view == 'nav') ? 'class="active"' : '' ;?> ><i class="menu-icon fa fa-list-alt"></i><a href="admin.php?view=nav">Navigation</a></li><?php } ?>
              <?php if($settings->custom_settings == 1){?> <li <?=($view == 'custom') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-snowflake-o"></i><a href="admin.php?view=custom"><?=lang("BE_CUS")?></a></li><?php } ?>
              <?php if(in_array($user->data()->id, $master_account)){?> <li <?=($view == 'access') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-file-code-o"></i><a href="admin.php?view=access"><?=lang("BE_DASH_ACC")?></a></li><?php } ?>
            </ul>
          </li>
        <?php } //end settings menu admin only?>
          <li class="menu-item-has-children dropdown <?=activeDropdown($view, 'tools')[0];?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="<?=activeDropdown($view, 'tools')[1];?>"> <i class="menu-icon fa fa-wrench"></i><?=lang("BE_TOOLS")?></a>
            <ul class="sub-menu children dropdown-menu <?=activeDropdown($view, 'tools')[0];?>">
              <?php if(checkAccess('view','backup')){?> <li <?=($view == 'backup') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-floppy-o"></i><a href="admin.php?view=backup"><?=lang("BE_BACKUP")?></a></li><?php } ?>
              <?php if(in_array($user->data()->id,$master_account)){?> <li <?=($view == 'bugs') ? 'class="active"' : '' ;?>><i class=" menu-icon fa fa-bug"></i><a href="admin.php?view=bugs">Bug Reporter</a></li><?php } ?>
              <?php if(checkAccess('view','updates')){?> <li <?=($view == 'updates') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-arrow-circle-o-up"></i><a href="admin.php?view=updates"><?=lang("BE_UPDATE")?></a></li><?php } ?>
              <?php if(checkAccess('view','cron')){?> <li <?=($view == 'cron') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-terminal"></i><a href="admin.php?view=cron"><?=lang("BE_CRON")?></a></li><?php } ?>
              <?php if(checkAccess('view','ip')){?> <li <?=($view == 'ip') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-warning"></i><a href="admin.php?view=ip"><?=lang("BE_IP")?></a></li><?php } ?>
              <?php if(checkAccess('view','logs')){?> <li <?=($view == 'logs') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-list-ol"></i><a href="admin.php?view=logs">System Logs</a></li><?php } ?>
              <?php if(checkAccess('view','templates')){?> <li <?=($view == 'templates') ? 'class="active"' : '' ;?>><i class=" menu-icon fa fa-eye"></i><a href="admin.php?view=templates">Templates</a></li><?php } ?>
            </ul>
          </li>
<?php //dump($plugins); ?>

          <li class="menu-item-has-children dropdown <?=activeDropdown($view, 'addons')[0];?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="<?=activeDropdown($view, 'addons')[1];?>"> <i class="menu-icon fa fa-plus"></i>Plugins</a>
            <ul class="sub-menu children dropdown-menu <?=activeDropdown($view, 'addons')[0];?>">
              <?php if(checkAccess('view','plugins')){?>   <li <?=($view == 'plugins') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-plug"></i><a href="admin.php?view=plugins">Plugin Manager</a></li><?php } ?>
              <?php foreach($plugins as $t){
                $xml=simplexml_load_file($abs_us_root.$us_url_root.'usersc/plugins/'.$t.'/info.xml');
                if(file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$t.'/configure.php') && isset($usplugins[$t]) && ($usplugins[$t] == 1)){?>
                <li><i class=" menu-icon fa fa-bolt"></i>
                  <a href="<?=$us_url_root.'users/admin.php?view=plugins_config&plugin='.$t?>" >
                    <?php
                    if($xml->button != ''){
                      echo $xml->button;
                    }else{
                      echo $t;
                    } ?>
                    </a>
                <?php } ?>
                </li>
            <?php  }?>

            </ul>
          </li>
          <?php if(file_exists($abs_us_root.$us_url_root.'usersc/includes/admin_panels.php')){ ?>
            <?php if(checkAccess('view','stats')){?> <li <?=($view == 'stats') ? 'class="active"' : '' ;?>>
                <a href="admin.php?view=legacy"><i class="menu-icon fa fa-clock-o"></i>Legacy Buttons</a>
            </li>
          <?php } }?>
          <li class="menu-title">Manage</li><!-- /.menu-title -->
            <?php if(checkAccess('view','pages')){?> <li <?=($view == 'pages') ? 'class="active"' : '' ;?>><a href="admin.php?view=pages"><i class="menu-icon fa fa-file"></i>Pages</a></li><?php } ?>
            <?php if(checkAccess('view','permissions')){?> <li <?=($view == 'permissions') ? 'class="active"' : '' ;?>><a href="admin.php?view=permissions"><i class="menu-icon fa fa-lock"></i>Permission Levels</a></li><?php } ?>
            <?php if(in_array($user->data()->id,$master_account)){?> <li <?=($view == 'spice') ? 'class="active"' : '' ;?>><a href="admin.php?view=spice"><i class="menu-icon fa fa-user-secret"></i>Spice Shaker</a></li><?php } ?>
            <?php if(checkAccess('view','users')){?> <li <?=($view == 'users') ? 'class="active"' : '' ;?>><a href="admin.php?view=users"><i class="menu-icon fa fa-user"></i>Users</a></li><?php } ?>

          <h3 class="menu-title">Misc</h3><!-- /.menu-title -->
          <li class="menu-item">
            <?php if(file_exists($abs_us_root.$us_url_root.'usersc/includes/admin_menu.php')){
              include($abs_us_root.$us_url_root.'usersc/includes/admin_menu.php');
            }?>
            <a href="<?=$us_url_root?>index.php"><i class="menu-icon fa fa-home"></i>Visit Homepage</a>
            <a href="<?=$us_url_root?>users/account.php"><i class="menu-icon fa fa-qq"></i>Your Account</a>
            <a href="<?=$us_url_root?>users/logout.php"><i class="menu-icon fa fa-hand-peace-o"></i>Logout</a>

          </li>

        </ul>
      </div><!-- /.navbar-collapse -->
    </nav>

  </aside><!-- /#left-panel -->

  <!-- Left Panel -->
<script>
(function ( $ ) {
    $.fn.feedback = function(success, fail) {
    	self=$(this);
		self.find('.dropdown-menu-form').on('click', function(e){e.stopPropagation()})
    	self.find('.do-close').on('click', function(){
			self.find('.dropdown-toggle').dropdown('toggle');
			self.find('.report').show();
		});
	};
}( jQuery ));

$(document).ready(function () {
	// $('.feedback').feedback();
});
</script>
  <!-- Right Panel -->
