<link rel="stylesheet" href="<?=$us_url_root?>users/js/pagination/datatables.min.css">
<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?php echo $us_url_root; ?>users/admin.php">Dashboard</a></li>
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
$action = Input::get('action');
$filters = [
  'debug' => 'View Only Debugging Logs',
];
$errors = [];
$successes = [];
if (in_array($user->data()->id, $master_account) && $action != '') {
    $query = '';
    switch ($action) {
    case 'delete_logs':
      $query = 'DELETE FROM logs';
      break;
    case 'truncate_logs':
      $query = 'TRUNCATE table logs';
      break;
    case 'delete_debugging_logs':
      $query = "DELETE FROM logs WHERE logtype = 'Redirect Diag' OR logtype = 'Form Data'";
      break;
  }

    if ($query != '') {
        $db->query($query);
        if (!$db->error()) {
            logger($user->data()->id, 'Logs', 'An action was performed against the logs', ['ACTION' => $action, 'QUERY' => $query]);
        } else {
            logger($user->data()->id, 'Logs', 'An action performed against the logs has failed', ['ACTION' => $action, 'QUERY' => $query, 'ERROR' => $db->errorString()]);
        }
    }

    Redirect::to('?view=logs');
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
    <?php if (in_array($user->data()->id, $master_account)) { ?>
      <div style="padding-left: 0" class="col-xs-12 col-lg-3">
        <select class="form-control" name="logs_actions" id="logs_actions">
            <option disabled selected value>Select an action...</option>
            <option value="delete_logs">Clear All Logs (Keep IDs)</option>
            <option value="truncate_logs">Clear All Logs (Reset IDs)</option>
            <option value="delete_debugging_logs">Clear Debugging Logs</option>
        </select>
      </div>
      <div class="col-xs-12 col-lg-3">
        <select class="form-control" name="logs_filters" id="logs_filters">
            <option disabled selected value>Select a filter...</option>
            <?php if ($mode != '') { ?>
              <option value="">View All Logs</option>
            <?php } ?>
            <?php
            foreach ($filters as $key => $value) {
                if ($key == $mode) {
                    continue;
                } ?>
              <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
            <?php
            } ?>
        </select>
      </div>
      <br><br>
    <?php } ?>
  </div>

  <?php resultBlock($errors, $successes);
    $logs = UserSpice_getLogs(['preset' => $mode]);
  ?>
  <div class="card">
  <div class="card-body">
  <table id="logstable" class='table table-hover table-striped table-list-search display'>
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
          <td><?php echo Input::sanitize($l->id); ?></td>
          <td><?php echo Input::sanitize($l->ip); ?></td>
          <td><?php echouser(Input::sanitize($l->user_id)); ?> (<?php echo Input::sanitize($l->user_id); ?>)</td>
          <td><?php echo Input::sanitize($l->logdate); ?></td>
          <td><?php echo Input::sanitize($l->logtype); ?></td>
          <td>
            <div class="input-group">
              <?php
              if (strlen($l->lognote) > 80) { ?>
              <textarea style="padding-top:0px; padding-left:5px;" rows="1" class="form-control" readonly><?php echo Input::sanitize($l->lognote); ?></textarea>
            <?php
            } else {
                echo Input::sanitize($l->lognote);
            }
            ?>
            </div>
          </td>
          <td>
            <?php if ($l->metadata !== null) {?>
              <i class="fa fa-fw fa-sticky-note pull-right" onclick="generateMetadataModal(<?php echo $l->id; ?>)" title="View<br>Metadata" data-html="true" data-toggle="tooltip"></i>
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

$("select#logs_actions").change(function() {
  var val = $(this).val()
  var msg
  switch (val) {
    case 'delete_logs':
      msg = "Are you sure you want to Delete All Logs (this may take awhile)?"
    case 'truncate_logs':
      msg = "Are you sure you want to Truncate All Logs (this will reset all IDs)?"
    case 'delete_debugging_logs':
      msg = "Are you sure you want to clear Debugging Logs?"
  }
  if(confirm(msg)) {
    var url = window.location.href
    url = `${url}&action=${val}`
    window.location.href = url
  } else {
    $("select#logs_actions")[0].selectedIndex = 0;
  }
})

$("select#logs_filters").change(function() {
  var val = $(this).val()
  var url = updateQueryStringParameter(window.location.href, 'mode', val)
  window.location.href = url
})

function updateQueryStringParameter(uri, key, value) {
  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
  if (uri.match(re)) {
    if(value == '') {
      return uri.replace(re, '');
    } else {
      return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
  }
  else {
    return uri + separator + key + "=" + value;
  }
}

function generateMetadataModal(logId) {
  $.get("<?php echo $us_url_root; ?>users/parsers/logMetadataById.php?id=" + logId, function(data, status) {
    $("#logMetadataBody").html(data)
    $("#logMetadataID").html(logId)
    $("#logMetadata").modal();
  });
}

$(document).ready(function () {
   $('#logstable').DataTable({"pageLength": 25,"stateSave": true,"aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 250, 500]], "aaSorting": []});
  });

</script>
