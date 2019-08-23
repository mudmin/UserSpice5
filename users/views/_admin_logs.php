<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
        <li>Tools</li>
        <li class="active">System Logs</li>
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
<div class="content mt-3">
  <h2>System Logs</h2>
  <!-- <a href='admin.php?view=logsman'>Go to Logs Manager</a> -->
  <?php resultBlock($errors, $successes);
  $logs = $db->query("SELECT * FROM logs ORDER BY id DESC LIMIT 5000")->results();
  ?>
  <hr>
  <table id="paginate" class='table table-hover table-striped table-list-search display'>
    <thead>
      <th>ID</th>
      <th>IP</th>
      <th >User (ID)</th>
      <th>Date</th>
      <th>Type</th>
      <th>Note</th>
    </thead>
    <tbody>
      <?php foreach($logs as $l){ ?>
        <tr>
          <td><?=$l->id?></td>
          <td><?=$l->ip?></td>
          <td><?php echouser($l->user_id)?> (<?=$l->id?>)</td>
          <td><?=$l->logdate?></td>
          <td><?=$l->logtype?></td>
          <td><?=$l->lognote?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  </div>

<script type="text/javascript" src="js/pagination/datatables.min.js"></script>
<script>

$(document).ready(function () {
   $('#paginate').DataTable({"pageLength": 25,"stateSave": true,"aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 250, 500]], "aaSorting": []});
  });

</script>
