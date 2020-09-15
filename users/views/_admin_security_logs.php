<link href="<?=$us_url_root?>users/css/datatables.css" rel="stylesheet">
<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
        <li>Tools</li>
        <li class="active">Security Logs</li>
      </ol>
    </div>
  </div>
</div>
</div>
</header>
<?php
$errors = [];
$successes = [];
?>
<style>
tfoot input {
  width: 100%;
  box-sizing: border-box;
}
</style>
<link rel="stylesheet" href="<?=$us_url_root?>users/js/pagination/datatables.min.css">
<div class="content mt-3">
  <h2 class="mb-3">Security Logs</h2>
  <!-- <a href='admin.php?view=logsman'>Go to Logs Manager</a> -->
  <?php resultBlock($errors, $successes);
  $logs = $db->query("SELECT * FROM audit ORDER BY id DESC LIMIT 5000")->results(); ?>
  <div class="card">

    <div class="card-body table-sm table-responsive">
      <table id="paginate" class='table table-hover table-striped table-list-search display'>
        <thead>
          <tr>
            <th scope="col"class="text-left">Log ID</th>
            <th scope="col"class="text-left">User</th>
            <th scope="col"class="text-left">Page Attempted</th>
            <th scope="col"class="text-left">Timestamp</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($logs as $m){ ?>
            <tr>
              <td><?=$m->id?></td>
              <td><?php
              if($m->user > 0){
                echouser($m->user);
              }else{
                $q = $db->query("SELECT * FROM us_ip_list WHERE ip = ? ORDER BY id DESC",array($m->ip));
                $c = $q->count();
                if($c > 0){
                  $f = $q->first();
                  echo "IP last used by ";
                  echouser($f->user_id);
                }else{
                  echo "<font color='red'>Unknown IP</font>";
                }
              }
              ?></td>

              <td><?php echopage($m->page);?></td>

              <td><?=$m->timestamp?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  </div>



<script type="text/javascript" src="<?=$us_url_root?>users/js/pagination/datatables.min.js"></script>
<script>

$(document).ready(function () {
   $('#paginate').DataTable({"pageLength": 25,"stateSave": true,"aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 250, 500]], "aaSorting": []});
  });

</script>
