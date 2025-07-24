<?php
$v2ToolsWidgetLoaded = true;
$tools = [
  ['Bug Report', 'bug.png', 'bugs','','Find a bug in UserSpice? Let us know by reporting it from your own dashboard.'],
  ['Classic Menu', 'navigation.png', 'nav', '', 'If you still use the classic menu, you can manage it here.'],
  ['Cron Manager', 'cron.png', 'cron', '', 'This is a place to manage your recurring cron jobs.'],
  ['IP Manager', 'ip.png', 'ip', '', 'Manage IP Blacklisting and Whitelisting'],
  ['OAuth Client', 'oauth_client.png', 'oauth_client', '', 'Connect to other UserSpice installs.'],
  ['OAuth Server', 'oauth.png', 'oauth', '', 'Manage OAuth clients and settings.'],
  ['Page Manager', 'pages.png', 'pages', '', 'Decide which permissions are required to view each page.'],
  ['Permissions & Tags', 'permissions.png', 'permissions', '', 'Manage the permissions and tags that you can assign to users.'],
  ['Plugin Manager', 'plugin.png', 'plugins', '', 'Activate, deactivate, and configure plugins.'],
  ['Spice Shaker', 'spice.png', 'spice', '', 'Download official UserSpice plugins and templates, and widgets. (Free API Key Required)'],
  ['Security Logs', 'security.png', 'security_logs','', 'View logs of security-related events.'],
  ['System Logs', 'logs.png', 'logs', '', 'View logs of system events as well as logs that you have added with the logger function.'],
  ['Templates', 'templates.png', 'templates', '', 'Activate and customize your templates'],
  ['Updates', 'update.png', 'updates', '', 'Download updates for the UserSpice core (Free API Key Required)'],
  ['User Manager', 'user.png', 'users', '', 'Manage the info and permissions of your users.'],
];

if(isset($child_theme)){
  $tn = $settings->template;
  if(file_exists($abs_us_root . $us_url_root . "usersc/templates/$tn/customize.php")){
    $dsLink = $us_url_root . "usersc/templates/$tn/customize.php?child_theme=dashboard";
    $tools[] = ['Dashboard Style', 'customize_dash.png', '', $dsLink, 'Customize the look and feel of your dashboard.'];
  }
}

if(isset($core_template)){
  $tn = $core_template;
  if(file_exists($abs_us_root . $us_url_root . "usersc/templates/$tn/customize.php")){
    $dsLink = $us_url_root . "usersc/templates/$tn/customize.php";
    $tools[] = ['Template Style', 'customize_front.png', '', $dsLink, 'Customize the look and feel of your website.'];
  }
}

//an opportunity to override or add widget icons
if(file_exists($abs_us_root . $us_url_root . 'usersc/widgets/'.$widgetName.'/custom.php')){
  include $abs_us_root . $us_url_root . 'usersc/widgets/'.$widgetName.'/custom.php';
}

?>

<div class="card dash-card" data-id="<?=$widgetName?>" id="<?=$widgetName?>-card">
  <div class="card-header" id="<?=$widgetName?>-card-header">
    <span class="collapseCard" data-card="<?=$widgetName?>" id="<?=$widgetName?>-caret"><i class="fa fa-caret-down"></i></span>
    <span class="card-title-text">Tools</span>
    <span class="float-end">
      <i class="fa-solid fa-grip ps-2 grippy"></i>
    </span>
  </div>
  <div class="card-body" id="<?=$widgetName?>-card-body">
    <p class="card-text">
      <div class="row">
        <?php foreach($tools as $t){

          if(checkAccess('view',$t[2])){
            
          ?>
          <div class="col-3 col-sm-2 mb-4 text-center">
            <?php if(isset($t[3]) && $t[3] != ''){ ?>
              <a href="<?=$t[3]?>" data-bs-toggle="tooltip" title="<?=$t[4]?>">
            <?php }else{ ?>
            <a href="?view=<?=$t[2]?>" data-bs-toggle="tooltip" title="<?=$t[4]?>">
            <?php } ?>
              <div class="icon-link">
                <img src="<?=$us_url_root?>usersc/widgets/<?=$widgetName?>/<?=$t[1];?>" alt="<?=$t[0]?>" class="dash-icon">
                <br>
                <div class="dashboard-icon-label">
                  <?=$t[0];?>
                </div>
              </div>
              </a>
          </div>
        <?php }} ?>
      </div>
    </p>
  </div>
</div>
