<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
        <li>Tools</li>
        <li class="active">IP Addresses</li>
      </ol>
    </div>
  </div>
</div>
</div>
</header>

<?php
$wl = $db->query("SELECT * FROM us_ip_whitelist")->results();
$bl = $db->query("SELECT * FROM us_ip_blacklist")->results();
if(!empty($_POST)){
  if(!empty($_POST['newIP'])){
    $ip = Input::get('ip');
    $wl = Input::get('type');
    if(filter_var($ip, FILTER_VALIDATE_IP)){
      if($wl == 'whitelist'){
        logger($user->data()->id,"Setting Change","Whitelisted ".$ip);
        $db->insert('us_ip_whitelist',['ip'=>$ip]);
        Redirect::to($us_url_root.'users/admin.php?view=ip&err=New+IP+Whitelisted');
      }else{
        logger($user->data()->id,"Setting Change","Blacklisted ".$ip);
        $db->insert('us_ip_blacklist',['ip'=>$ip]);
        Redirect::to($us_url_root.'users/admin.php?view=ip&err=New+IP+Blacklisted');
      }
    }else{
      Redirect::to($us_url_root.'users/admin.php?view=ip&err=Invalid+IP+address');
    }
  }

  if(!empty($_POST['delete'])){
    foreach($_POST['deletewhite'] as $k=>$v){
      $ip = $db->query("SELECT ip FROM us_ip_whitelist WHERE id = ?",array($v))->first();
      logger($user->data()->id,"Setting Change","Deleted ".$ip->ip." from whitelist");
      $db->deleteById('us_ip_whitelist',$v);
    }
    foreach($_POST['deleteblack'] as $k=>$v){
      $ip = $db->query("SELECT ip FROM us_ip_blacklist WHERE id = ?",array($v))->first();
      logger($user->data()->id,"Setting Change","Deleted ".$ip->ip." from blacklist");
      $db->deleteById('us_ip_blacklist',$v);
    }
    Redirect::to($us_url_root.'users/admin.php?view=ip&err=IP(s) Deleted');
  }
}
?>


<div class="content mt-3">
  <div class="row">
  <div class="col-md-12">
  <h3>Manage IP Addresses</h3>
    <p>Note: Whitelist overrides Blacklist</p>
    <form action="<?=$us_url_root?>users/admin.php?view=ip" method="post">
	<div class="form-row">
	<div class="input-group col-md-6 mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="ip-label">IP Address</span>
		</div>
		<input type="text" class="form-control" aria-describedby="ip-label" name="ip" placeholder="Enter IP Address" required>
	</div>

	<div class="input-group col-md-5 mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text" id="type-label">Type</span>
		</div>
		<select class="custom-select" name="type" aria-describedby="type-label" required>
		<option value="" disabled selected>Choose Type</option>
			<option value="whitelist">Whitelist</option>
			<option value="blacklist">Blacklist</option>
		</select>
	</div>


	  <input type="submit" name="newIP" value="Add IP" class="btn btn-danger form-control col-md-1  mb-3">
	  </div>
      </form>
	  <hr />
	  </div>
    </div>
	<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-whitelisted-tab" data-toggle="tab" href="#nav-whitelisted" role="tab" aria-controls="nav-whitelisted" aria-selected="true">Whitelist</a>
    <a class="nav-item nav-link" id="nav-blacklisted-tab" data-toggle="tab" href="#nav-blacklisted" role="tab" aria-controls="nav-blacklisted" aria-selected="false">Blacklist</a>
  </div>
</nav>
<form class="" action="<?=$us_url_root?>users/admin.php?view=ip" method="post">
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-whitelisted" role="tabpanel" aria-labelledby="nav-whitelisted-tab">
  <div class="row">
      <div class="col-md-12">


        <table class="table table-striped lisTed">
          <thead>
            <tr>
              <th>IP Address</th><th class="col-sm-1">Delete</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach($wl as $b){ ?>
              <tr>
                <td><?=$b->ip?></td>
                <td><input class="form-control" type="checkbox" name="deletewhite[<?=$b->id?>]" value="<?=$b->id?>"></td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
	  </div>
  </div>
  <div class="tab-pane fade" id="nav-blacklisted" role="tabpanel" aria-labelledby="nav-blacklisted-tab">
  <div class="row">
      <div class="col-md-12">

        <table class="table table-striped lisTed">
          <thead>
            <tr>
              <th>IP Address</th><th>Reason</th><th>Last User</th><th class="col-sm-1">Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($bl as $b){ ?>
              <tr>
                <td><?=$b->ip?></td>
                <td><?php ipReason($b->reason);?></td>
                <td><?php echouser($b->last_user);?></td>
                <td><input class="form-control" type="checkbox" name="deleteblack[<?=$b->id?>]" value="<?=$b->id?>"></td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
	<p><input class="btn btn-danger my-1" type="submit" name="delete" value="Delete Selected IPs"></p>
  </form>
  <script type="text/javascript" src="js/pagination/datatables.min.js"></script>

<script>
	$(document).ready( function () {
		$('.lisTed').DataTable({
			scrollY:        480,
			scrollCollapse: true,
			paging:         false
		});
	} );
	$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
							$.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
						});
</script>
