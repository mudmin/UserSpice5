<?php
$tools = [
  ['Docs', 'docs.png', 'https://userspice.com/kb'],
  ['Discord Chat', 'discord.png', 'https://discord.gg/PMNquvh'],
  ['Videos', 'videos.png', 'https://www.youtube.com/playlist?list=PLixQt02ELp8onA67F4yrVbLnTOYsSBhxZ'],
  ['Support UserSpice', 'support.png', 'https://userspice.com/donate'],
  ['Your Account', 'account.png', 'account.php'],
  ['Logout', 'logout.png', 'logout.php'],
];

?>

<div class="card dash-card" data-id="<?=$widgetName?>" id="<?=$widgetName?>-card">
  <div class="card-header" id="<?=$widgetName?>-card-header">
    <span class="collapseCard" data-card="<?=$widgetName?>" id="<?=$widgetName?>-caret"><i class="fa fa-caret-down"></i></span>
    <span class="card-title-text">Miscellaneous</span>
    <span class="float-end">
      <i class="fa-solid fa-grip ps-2 grippy"></i>
    </span>
  </div>
  <div class="card-body" id="<?=$widgetName?>-card-body">
    <p class="card-text">
      <div class="row">
        <?php foreach($tools as $t){
          if(substr($t[2],0,6) == "?view="){
            $check = str_replace("?view=","",$t[2]);
            if(!checkAccess('view',$check)){
              continue;
            }
          }
          ?>
          <div class="col-3 col-sm-2 mb-4 text-center">
            <a href="<?=$t[2]?>" data-bs-toggle="tooltip" title="<?=$t[0]?>">
              <div class="icon-link">
                <img src="<?=$us_url_root?>usersc/widgets/<?=$widgetName?>/<?=$t[1];?>" alt="<?=$t[0]?>" class="dash-icon">
                <br>
                <div class="dashboard-icon-label">
                  <?=$t[0];?>
                </div>
              </div>

          </a>



          </div>
        <?php } ?>


      </div>
    </p>
  </div>
</div>
