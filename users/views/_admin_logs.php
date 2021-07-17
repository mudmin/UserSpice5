<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?=$us_url_root; ?>users/admin.php">Dashboard</a></li>
        <li>Tools</li>
        <li class="active">System Logs</li>
        <li></li>
      </ol>
    </div>
  </div>
</div>
</div>
</header>
<?php
$mode = Input::get('mode');
$errors = [];
$successes = [];
if(in_array($user->data()->id, $master_account)) {
if(!empty($_POST['delhook'])){
  if(Input::get("delAll") != ""){
    $db->query("TRUNCATE table logs");
  }
  if(Input::get("delDebug") != ""){
    $db->query("DELETE FROM logs WHERE logtype = ? OR logtype = ?",["Redirect Diag","Form Data"]);
  }
}
}
?>
<style>
tfoot input {
  width: 100%;
  box-sizing: border-box;
}
</style>
<div class="content mt-3">
  <h2 class="mb-3">System Logs</h2>
  <?php if(in_array($user->data()->id, $master_account)) { ?>
    <form class="" action="" method="post" onsubmit="return confirm('Do you really want to do this? It cannot be undone.');">
      <input type="hidden" name="csrf" value="<?=Token::generate();?>">
      <input type="hidden" name="delhook" value="true">
      <input type="submit" name="delAll" value="Clear All Logs" class="btn btn-danger">
      <input type="submit" name="delDebug" value="Clear Debugging Logs" class="btn btn-warning">
      <?php if($mode == "debug"){ ?>
        <a href="admin.php?view=logs" class="btn btn-primary">View All Logs</a>
      <?php }else{ ?>
        <a href="admin.php?view=logs&mode=debug" class="btn btn-primary">View Only Debugging Logs</a>
      <?php } ?>
    </form>
  <?php
  }
  ?>

  <!-- <a href='admin.php?view=logsman'>Go to Logs Manager</a> -->
  <?php resultBlock($errors, $successes);
  if($mode == "diag"){
      $logs = $db->query("SELECT * FROM logs WHERE logtype = ? OR logtype = ? ORDER BY id DESC LIMIT 5000",["Redirect Diag","Form Data"])->results();
  }else{
      $logs = $db->query('SELECT * FROM logs ORDER BY id DESC LIMIT 5000')->results();
  }

  ?>
  <div class="card">
  <div class="card-body">
  <table id="paginate" class='table table-hover table-striped table-list-search display'>
    <thead>
      <th>ID</th>
      <th>IP</th>
      <th>User (ID)</th>
      <th>Date</th>
      <th>Type</th>
      <th>Note</th>
      <th></th>
    </thead>
    <tbody>
      <?php foreach ($logs as $l) { ?>
        <tr>
          <td><?=$l->id; ?></td>
          <td><?=$l->ip; ?></td>
          <td><?php echouser($l->user_id); ?> (<?=$l->user_id; ?>)</td>
          <td><?=$l->logdate; ?></td>
          <td><?=$l->logtype; ?></td>
          <td>
            <div class="input-group">
              <?php
              if(strlen($l->lognote) > 80){ ?>
              <textarea style="padding-top:0px; padding-left:5px;" rows="1" class="form-control" readonly><?=$l->lognote;?></textarea>
            <?php
            }else{
              echo $l->lognote;
            }
            ?>
            </div>
          </td>
          <td>
            <?php if ($l->metadata !== null) {?>
              <i class="fa fa-fw fa-sticky-note pull-right" onclick="generateMetadataModal(<?=$l->id; ?>)" title="View<br>Metadata" data-html="true" data-toggle="tooltip"></i>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  </div>
</div>
  </div>

  <div class="modal" id="logMetadata" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Log ID #<span id="logMetadataID"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="logMetadataBody">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="js/pagination/datatables.min.js"></script>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

function generateMetadataModal(logId) {
  $.get("<?=$us_url_root; ?>users/parsers/logMetadataById.php?id=" + logId, function(data, status) {
    $("#logMetadataBody").html(data)
    $("#logMetadataID").html(logId)
    $("#logMetadata").modal();
  });
}

$(document).ready(function () {
   $('#paginate').DataTable({"pageLength": 25,"stateSave": true,"aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 250, 500]], "aaSorting": []});
  });

</script>
