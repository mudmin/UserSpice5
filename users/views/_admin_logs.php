<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?=$us_url_root; ?>users/admin.php">Dashboard</a></li>
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
  <h2 class="mb-3">System Logs</h2>
  <!-- <a href='admin.php?view=logsman'>Go to Logs Manager</a> -->
  <?php resultBlock($errors, $successes);
  $logs = $db->query('SELECT * FROM logs ORDER BY id DESC LIMIT 5000')->results();
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
            <?php if ($l->metadata !== null) {?>
              <i class="fa fa-fw fa-sticky-note pull-right" onclick="generateMetadataModal(<?=$l->id; ?>)" title="View<br>Metadata" data-html="true" data-toggle="tooltip"></i>
            <?php } ?>
            <?=$l->lognote; ?>
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
