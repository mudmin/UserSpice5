<div class="row">

<!-- Important Info -->
<div class="col-lg-4 col-md-6">
  <aside class="profile-nav alt">
    <section class="card">
      <div class="card-header user-header alt bg-dark">
        <div class="media">
          <div class="h1 text-light text-left mb-4">
            <i class="fa fa-camera"></i>
          </div>
          <!-- <a href="#">
          <img class="align-self-center rounded-circle mr-3" style="width:85px; height:85px;" alt="" src="images/admin.jpg">
        </a> -->
        <div class="media-body">
          <h2 align="center" class="text-light display-6">System Snapshot</h2>
        </div>
      </div>
    </div>


    <ul class="list-group list-group-flush">
      <li class="list-group-item">
        UserSpice Version <span class="badge badge-primary"><?=$user_spice_ver?></span>
        <span class="pull-right"><a href="<?=$us_url_root?>users/admin.php?view=updates">Check for Updates</a></span>
      </li>
      <li class="list-group-item">
        PHP
        <?php
        $ini = php_ini_loaded_file();
        echo $ini;
        ?>
        <span class="badge badge-primary"><?php echo $phpver = phpversion();?>
        </span>
        <span class="pull-right">
          <?php
          if(version_compare('7.1.0',$phpver) ==  1){
            echo "<font color='red'>v7.1 or Greater Suggested</font>";
          }
          ?>
        </span>
      </li>
      <?php $dataB = $db->query("select version()")->results(true);?>
      <li class="list-group-item">
        DB Version <span class="badge badge-primary"><?=$dataB[0]["version()"];?></span>
        <span class="pull-right"></span>
      </li>
      <li class="list-group-item">
        OS Info <span class="badge badge-primary"><?=php_uname('s');?>-<?=php_uname('v');?></span>
        <span class="pull-right"></span>
      </li>
    </ul>
  </section>
</aside>
</div>
<!-- Important Info -->


<!-- Support Info -->
<div class="col-lg-4 col-md-6">
  <aside class="profile-nav alt">
    <section class="card">
      <div class="card-header user-header alt bg-dark">
        <div class="media">
          <div class="h1 text-light text-left mb-4">
            <i class="fa fa-heart"></i>
          </div>
          <!-- <a href="#">
          <img class="align-self-center rounded-circle mr-3" style="width:85px; height:85px;" alt="" src="images/admin.jpg">
        </a> -->
        <div class="media-body">
          <h2 align="center" class="text-light display-6">Support Info</h2>
        </div>
      </div>
    </div>


    <ul class="list-group list-group-flush">

      <li class="list-group-item">
        <a href="https://userspice.com/kb/" target="_blank"> <i class="fa fa-book"></i>  Documentation </a>
      </li>

      <li class="list-group-item">
        <a href="https://discord.gg/PMNquvh" target="_blank"> <i class="fa fa-comments"></i>  Live Discord Chat </a>
      </li>

      <li class="list-group-item">
        <a href="https://www.youtube.com/playlist?list=PLixQt02ELp8onA67F4yrVbLnTOYsSBhxZ" target="_blank"> <i class="fa fa-quote-left"></i>  UserSpice Videos</a>
      </li>

      <li class="list-group-item">
        <a href="https://www.patreon.com/userspice" target="_blank"> <i class="fa fa-heart"></i>  Support UserSpice </a>
      </li>
    </ul>
  </section>
</aside>
</div>
<!-- Support Info -->


<!-- Top Users -->
<?php
$top = $db->query("SELECT id, logins FROM users ORDER BY logins DESC LIMIT 4")->results();
?>
<div class="col-lg-4 col-md-6">
  <aside class="profile-nav alt">
    <section class="card">
      <div class="card-header user-header alt bg-dark">
        <div class="media">
          <div class="h1 text-light text-left mb-4">
            <i class="fa fa-trophy"></i>
          </div>
          <!-- <a href="#">
          <img class="align-self-center rounded-circle mr-3" style="width:85px; height:85px;" alt="" src="images/admin.jpg">
        </a> -->
        <div class="media-body">
          <h2 align="center" class="text-light display-6">Most Active Users</h2>
        </div>
      </div>
    </div>



    <ul class="list-group list-group-flush">
      <?php
      $count = 1;
      foreach($top as $t){ ?>
        <li class="list-group-item">
          <a href="admin.php?view=users&id=<?=$t->id?>"> #<?=$count?> <?php echoUser($t->id);?> <span class="badge badge-primary pull-right"><?=$t->logins?> logins</span></a>
        </li>
        <?php
        $count++;
      } ?>

    </ul>
  </section>
</aside>
</div>

<!-- End Top Users -->
</div> <!-- End Widget -->
