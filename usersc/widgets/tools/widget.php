<?php
$tools = [
  ['Bug Report', 'bug.png', 'bugs'],
  ['Cron Manager', 'cron.png', 'cron'],
  ['IP Manager', 'ip.png', 'ip'],
  ['Page Manager', 'pages.png', 'pages'],
  ['Permissions Manager', 'permissions.png', 'permissions'],
  ['Plugin Manager', 'plugin.png', 'plugins'],
  ['Spice Shaker', 'spice.png', 'spice'],
  ['Security Logs', 'security.png', 'security_logs'],
  ['System Logs', 'logs.png', 'logs'],
  ['Templates', 'templates.png', 'templates'],
  ['Updates', 'update.png', 'updates'],
  ['User Manager', 'user.png', 'users'],
];

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
            <a href="?view=<?=$t[2]?>" data-bs-toggle="tooltip" title="<?=$t[0]?>">
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
