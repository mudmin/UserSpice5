<!doctype html>
<head>
<?php

$page=currentFile();
$titleQ = $db->query('SELECT title FROM pages WHERE page = ?', array($page));
if ($titleQ->count() > 0) {
    $pageTitle = $titleQ->first()->title;
}
else $pageTitle = '';
?>
<title><?= (($pageTitle != '') ? $pageTitle : ''); ?> <?=$settings->site_name?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="css/dashboard/normalize.css">
  <link rel="stylesheet" href="css/dashboard/bootstrap.min.css">
  <link rel="stylesheet" href="<?=$us_url_root?>users/fonts/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/dashboard/style.css">

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
  <script src="js/jquery.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

<style>
body, p {
  color:black;
}

a{
  color:#0d0d0d;
  font-weight: 500;
}

a:hover{
  color: #292828;
  font-weight: 700;
}

.text-dark{
  color: black;
}
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
<?php if(file_exists($abs_us_root.$us_url_root."usersc/includes/dashboard.css")){ ?>
  <link rel="stylesheet" href="<?=$us_url_root?>usersc/includes/dashboard.css">
<?php } ?>
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
if(!function_exists('usView')){
  function usView($file)
{
    global $abs_us_root;
    global $us_url_root;
    if (checkAccess('page', $file)) {
        if (file_exists($abs_us_root.$us_url_root.'usersc/includes/admin/'.$file)) {
            $path = $abs_us_root.$us_url_root.'usersc/includes/admin/'.$file;
        } elseif (file_exists($abs_us_root.$us_url_root.'users/views/'.$file)) {
            $path = $abs_us_root.$us_url_root.'users/views/'.$file;
        } else {
            $path = $abs_us_root.$us_url_root.'users/views/_admin_dashboard.php';
        }

        return $path;
    } else {
        $path = $abs_us_root.$us_url_root.'users/views/_admin_dashboard.php';

        return $path;
    }
}
}

if(!function_exists('checkAccess')){
function checkAccess($key, $value)
{
    global $db, $user, $master_account;
    //Check if they belong to the master account array or have the Administrator (default 2) Perm
    if (in_array($user->data()->id, $master_account) || hasPerm([2], $user->data()->id)) {
        return true;
    } else {
        //They're not, now we're gonna check if the view exists in us_management and if they have perms
        $checkQ = $db->query("SELECT * FROM us_management WHERE $key = ?", [$value]);
        if (!$db->error()) {
            $checkC = $checkQ->count();
            if ($checkC < 1) {
                //The page isn't in the table, so we're gonna reject their ability to go
                return false;
            } else {
                //The page is in there, so now we're gonna check if they have permission
                $check = $checkQ->first();
                if (hasPerm([$check->access], $user->data()->id)) {
                    //They have permissions listed in us_management, let them through
                    return true;
                } else {
                    //They don't have permissions, reject them
                    return false;
                }
            }
        } else {
            //It failed to retrieve anything from us_management, so we log the error and send them away
            logger($user->data()->id, 'checkAccess', 'Failed to check access for '.$value.', Error: '.$db->errorString());
            return false;
        }
    }
}
}

if(!function_exists('activeDropdown')){
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
}

?>

  <!-- Left Panel -->
  <style>
    .navbar-header{
      position: absolute;
      top:-3rem;
    }
    .navbar{
      margin-top:3rem;
      padding:0!important;
    }
    .nav-small{
      position: absolute!important;
      left:0;
      top:1.5rem
    }
    .nav-small img{
      max-height: 32px!important;
    }

    .nav-footer{
      position: absolute;
      bottom:1rem;
    }

  </style>

  <aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
      <div class="navbar-header">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars"></i>
        </button>
        <a class="nav-brand" href="<?=$us_url_root?>index.php"><img src="images/logo.png" alt="Logo"></a>
        <a class="nav-brand nav-small d-none" href="./"><img src="images/logo2.png" alt="Logo"></a>
      </div>
      <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">
         <li <?=($view) ? '' : 'class="active"' ;?>>
            <a class="menu_item" id="dashboard" href="admin.php"> <i class="menu-icon fa fa-dashboard"></i><?=lang("BE_DASH")?> </a>
          </li>
          <!-- <h3 class="menu-title">Settings</h3> -->
          <?php if(hasPerm([2],$user->data()->id)){?>
          <li class="menu-item-has-children dropdown <?=activeDropdown($view, 'settings')[0];?>">
            <a class="menu_item" id="settings" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="<?=activeDropdown($view, 'settings')[1];?>"> <i class="menu-icon fa fa-gear"></i><?=lang("BE_SETTINGS")?></a>
            <ul class="sub-menu children dropdown-menu <?=activeDropdown($view, 'settings')[0];?>">
              <?php if(checkAccess('view','general')){?> <li <?=($view == 'general') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-gears"></i><a class="menu_item" id="settings_general" href="admin.php?view=general"><?=lang("BE_GEN")?></a></li><?php } ?>
              <?php if(checkAccess('view','reg')){?> <li <?=($view == 'reg') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-users"></i><a class="menu_item" id="settings_registration" href="admin.php?view=reg"><?=lang("BE_REG")?></a></li><?php } ?>
              <?php if(checkAccess('view','email')){?> <li <?=($view == 'email') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-envelope"></i><a class="menu_item" id="settings_email" href="admin.php?view=email"><?=lang("GEN_EMAIL")?></a></li><?php } ?>
              <?php if(checkAccess('view','nav')){?> <li <?=($view == 'nav') ? 'class="active"' : '' ;?> ><i class="menu-icon fa fa-list-alt"></i><a class="menu_item" id="settings_navigation" href="admin.php?view=nav"><?=lang("ACP_MENU_SETTINGS_NAVIGATION")?></a></li><?php } ?>
              <?php if($settings->custom_settings == 1){?> <li <?=($view == 'custom') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-snowflake-o"></i><a class="menu_item" id="settings_custom" href="admin.php?view=custom"><?=lang("BE_CUS")?></a></li><?php } ?>
              <?php if(in_array($user->data()->id, $master_account)){?> <li <?=($view == 'access') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-file-code-o"></i><a class="menu_item" id="settings_dashboard_access" href="admin.php?view=access"><?=lang("BE_DASH_ACC")?></a></li><?php } ?>
            </ul>
          </li>
        <?php } //end settings menu admin only?>
          <li class="menu-item-has-children dropdown <?=activeDropdown($view, 'tools')[0];?>">
            <a class="menu_item" id="tools" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="<?=activeDropdown($view, 'tools')[1];?>"> <i class="menu-icon fa fa-wrench"></i><?=lang("BE_TOOLS")?></a>
            <ul class="sub-menu children dropdown-menu <?=activeDropdown($view, 'tools')[0];?>">
              <?php
              if(file_exists($abs_us_root.$us_url_root."users/views/_admin_tools_backup.php")
              && checkAccess('view','backup')){ ?> <li <?=($view == 'backup') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-floppy-o"></i><a class="menu_item" id="tools_backups" href="admin.php?view=backup"><?=lang("BE_BACKUP")?></a></li>
              <?php }
              ?>
              <?php if(in_array($user->data()->id,$master_account)){?> <li <?=($view == 'bugs') ? 'class="active"' : '' ;?>><i class=" menu-icon fa fa-bug"></i><a class="menu_item" id="tools_bug_reporter" href="admin.php?view=bugs"><?=lang("ACP_MENU_TOOLS_BUG_REPORTER")?></a></li>
              <?php } ?>
              <?php if(checkAccess('view','cron')){?> <li <?=($view == 'cron') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-terminal"></i><a class="cron_manager" id="tools_cron" href="admin.php?view=cron"><?=lang("BE_CRON")?></a></li><?php } ?>
              <?php if(checkAccess('view','ip')){?> <li <?=($view == 'ip') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-warning"></i><a class="menu_item" id="tools_ip_manager" href="admin.php?view=ip"><?=lang("BE_IP")?></a></li><?php } ?>
              <?php if(checkAccess('view','logs')){?> <li <?=($view == 'logs') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-list-ol"></i><a class="menu_item" id="tools_system_logs" href="admin.php?view=logs"><?=lang("ACP_MENU_TOOLS_SYSTEM_LOGS")?></a></li><?php } ?>
              <?php if (checkAccess('view', 'security_logs')) {?> <li <?php echo ($view == 'security_logs') ? 'class="active"' : ''; ?>><i class="menu-icon fa fa-list-ol"></i><a class="menu_item" id="tools_security_logs" href="admin.php?view=security_logs"><?php echo lang('ACP_MENU_TOOLS_SECURITY_LOGS'); ?></a></li><?php } ?>
              <?php if(checkAccess('view','templates')){?> <li <?=($view == 'templates') ? 'class="active"' : '' ;?>><i class=" menu-icon fa fa-eye"></i><a class="menu_item" id="tools_templates" href="admin.php?view=templates"><?=lang("ACP_MENU_TOOLS_TEMPLATES")?></a></li><?php } ?>
              <?php if(checkAccess('view','updates')){?> <li <?=($view == 'updates') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-arrow-circle-o-up"></i><a class="menu_item" id="tools_updates" href="admin.php?view=updates"><?=lang("BE_UPDATE")?></a></li><?php } ?>

            </ul>
          </li>
<?php if(in_array($user->data()->id,$master_account)){?>

          <li class="menu-item-has-children dropdown <?=activeDropdown($view, 'addons')[0];?>">
            <a class="menu_item" id="plugins" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="<?=activeDropdown($view, 'addons')[1];?>"> <i class="menu-icon fa fa-plus"></i><?=lang("ACP_MENU_HEADER_MENU_PLUGINS")?></a>
            <ul class="sub-menu children dropdown-menu <?=activeDropdown($view, 'addons')[0];?>">
              <?php if(checkAccess('view','plugins')){?>   <li <?=($view == 'plugins') ? 'class="active"' : '' ;?>><i class="menu-icon fa fa-plug"></i><a class="menu_item" id="plugin_manager" href="admin.php?view=plugins"><?=lang("ACP_MENU_PLUGINS_PLUGIN_MANAGER")?></a></li><?php } ?>
              <?php foreach($plugins as $t){
                if(!file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$t.'/info.xml')) {
                  continue;
                }

                $xml=simplexml_load_file($abs_us_root.$us_url_root.'usersc/plugins/'.$t.'/info.xml');
                if(file_exists($abs_us_root.$us_url_root.'usersc/plugins/'.$t.'/configure.php') && isset($usplugins[$t]) && ($usplugins[$t] == 1)){?>
                     <li><i class=" menu-icon fa fa-bolt"></i>
                         <a class="menu_item" id="plugin_<?=$t?>" href="<?=$us_url_root.'users/admin.php?view=plugins_config&amp;plugin='.$t?>">
                         <?php
                             if($xml->button != ''){
                               echo $xml->button;
                             }else{
                               echo $t;
                             } ?>
                         </a>
                     </li>
                 <?php }
               }
               ?>

            </ul>
          </li>
        <?php }
           if(file_exists($abs_us_root.$us_url_root.'usersc/includes/admin_panels.php')){ ?>
            <?php if(checkAccess('view','stats')){?> <li <?=($view == 'stats') ? 'class="active"' : '' ;?>>
                <a class="menu_item" id="legacy" href="admin.php?view=legacy"><i class="menu-icon fa fa-clock-o"></i>Legacy Buttons</a>
            </li>
          <?php } }?>
          <h3 id="manage_menu" class="menu_header menu-title"><?=lang("ACP_MENU_HEADER_MANAGE")?></h3><!-- /.menu-title -->
            <?php if(checkAccess('view','pages')){?> <li <?=($view == 'pages') ? 'class="active"' : '' ;?>><a class="menu_item" id="manage_pages" href="admin.php?view=pages"><i class="menu-icon fa fa-file"></i><?=lang("ACP_MENU_MANAGE_PAGES")?></a></li><?php } ?>
            <?php if(checkAccess('view','permissions')){?> <li <?=($view == 'permissions') ? 'class="active"' : '' ;?>><a class="menu_item" id="manage_permissions" href="admin.php?view=permissions"><i class="menu-icon fa fa-lock"></i><?=lang("ACP_MENU_MANAGE_PERMISSION_LEVELS")?></a></li><?php } ?>
            <?php if(in_array($user->data()->id,$master_account)){?> <li <?=($view == 'spice') ? 'class="active"' : '' ;?>><a hclass="menu_item" id="manage_spice_shaker" href="admin.php?view=spice"><i class="menu-icon fa fa-user-secret"></i><?=lang("ACP_MENU_MANAGE_SPICE_SHAKER")?></a></li><?php } ?>
            <?php if(checkAccess('view','users')){?> <li <?=($view == 'users') ? 'class="active"' : '' ;?>><a class="menu_item" id="manage_users" href="admin.php?view=users"><i class="menu-icon fa fa-user"></i><?=lang("ACP_MENU_MANAGE_USERS")?></a></li><?php } ?>

          <h3 id="misc_menu" class="menu_header menu-title"><?=lang("ACP_MENU_HEADER_MISC")?></h3><!-- /.menu-title -->
          <li class="menu-item">
            <?php if(file_exists($abs_us_root.$us_url_root.'usersc/includes/admin_menu.php')){
              include($abs_us_root.$us_url_root.'usersc/includes/admin_menu.php');
            }?>
            <a class="menu_item" id="misc_homepage" href="<?=$us_url_root?>index.php"><i class="menu-icon fa fa-home"></i><?=lang("ACP_MENU_MISC_HOMEPAGE")?></a>
            <a class="menu_item" id="misc_account" href="<?=$us_url_root?>users/account.php"><i class="menu-icon fa fa-qq"></i><?=lang("ACP_MENU_MISC_ACCOUNT")?></a>
            <a class="menu_item" id="misc_logout" href="<?=$us_url_root?>users/logout.php"><i class="menu-icon fa fa-hand-peace-o"></i><?=lang("ACP_MENU_MISC_LOGOUT")?></a>

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
  $("#menuToggle").click(function(){
      if($(".nav-footer").css("display")!= "none"){
        $(".nav-footer").css("display", "none");
      }else{
        $(".nav-footer").css("display", "block");
      }
        $(".nav-brand").each(function(){
      if($(this).hasClass("d-none")){
        $(this).css("display", "flex!important");
        $(this).removeClass("d-none");
      }else{
        $(this).addClass("d-none");
      }
    });
  });
});

</script>
  <!-- Right Panel -->
