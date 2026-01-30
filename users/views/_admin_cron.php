<?php
$errors = $successes = [];
$form_valid = TRUE;
//Forms posted
$cs = Token::generate();
if (!empty($_POST)) {
  $token = $_POST['csrf'];
  if (!Token::check($token)) {
    include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
  }

  if (!empty($_POST['addCron'])) {
    $name = Input::get('name');
    $file = Input::get('file');
    $sort = Input::get('sort');

    $form_valid = FALSE; // assume the worst
    $validation = new Validate();
    $validation->check($_POST, array(
      'name' => array(
        'display' => 'Name',
        'required' => true,
        'min' => 2,
        'max' => 35,
      ),
      'file' => array(
        'display' => 'File',
        'required' => true,
        'min' => 2,
        'max' => 35,
      ),
      'sort' => array(
        'display' => 'Sort',
        'required' => true,
      ),
    ));
    if ($validation->passed()) {
      $form_valid = TRUE;
      try {
        $fields = array(
          'name' => Input::get('name'),
          'file' => Input::get('file'),
          'sort' => Input::get('sort'),
          'createdby' => $user->data()->id,
        );
        $db->insert('crons', $fields);
        $successes[] = "Cron Added";
        logger($user->data()->id, "Cron Manager", "Added cron named $name.");
      } catch (Exception $e) {
        logger(null, 'Exception Caught', Input::sanitize($e->getMessage())); die("A system error occurred. We apologize for the inconvenience. Logging is available.");
      }
    }
  }
}
$query = $db->query("SELECT * FROM crons ORDER BY sort,active DESC,id ASC");
$count = $query->count();
?>

<?= resultBlock($errors, $successes); ?>
<h2>Cron Manager</h2>
<?php if ($settings->cron_ip == 'off') {
  echo "<p class='text-dark'><b>Your cron jobs are currently disabled by the system. With great power, comes the need for great responsibility. Please see the note at the bottom of this page.</b></p>";
} ?>
<div class="card">
  <div class="card-body">
    <div class="float-right text-end mb-2">
      <div class="btn-group"><button class="btn btn-primary" data-toggle="modal" data-bs-toggle="modal" data-target="#addcron" data-bs-target="#addcron"><i class="fa fa-plus"></i> Add New Job</button></div>
    </div>
    <table class="table table-bordered">
      <tr>
        <th>ID</th>
        <th>Status</th>
        <th>Cron Name</th>
        <th>Cron File</th>
        <th>Sort</th>
        <th>Created By</th>
        <th>Last Ran</th>
        <th>Action</th>
      </tr>
      <?php
      if ($count > 0) {
        foreach ($query->results() as $row) { ?>
          <tr <?php if ($row->active == 0) { ?> class="bg-light" <?php } ?>>
            <td><?= $row->id; ?></td>
            <td>
              <p data-field="active" data-token="<?=$cs?>" class="cronactive nounderline" data-input="select" data-id="<?= $row->id; ?>"><?= $row->active == 1 ? 'Active' : 'Inactive' ?></p>
            </td>
            <td>
              <p data-field="name" data-token="<?=$cs?>" class="cronname nounderline txt" data-input="input" data-id="<?= $row->id; ?>" data-title="Rename Cron ID <?= $row->id; ?>"><?= $row->name; ?></p>
            </td>
            <td>
              <p data-field="file" data-token="<?=$cs?>" class="cronfile nounderline txt" data-input="input" data-id="<?= $row->id; ?>" data-title="Change File for <?= $row->name; ?>"><?= $row->file; ?></p>
            </td>
            <td>
              <p data-field="sort" data-token="<?=$cs?>" class="cronsort nounderline txt" data-input="input" data-id="<?= $row->id; ?>" data-title="Change sort for <?= $row->name; ?>"><?= $row->sort; ?></p>
            </td>
            <td><?= echousername($row->createdby); ?></td>
            <td><?php $ranQ = $db->query("SELECT datetime,user_id FROM crons_logs WHERE cron_id = ? ORDER BY datetime DESC", array($row->id));
              $ranCount = $ranQ->count();
              if ($ranCount > 0) {
                $ranResult = $ranQ->first(); ?>
                <?= $ranResult->datetime; ?> (<?= echousername($ranResult->user_id); ?>)<?php } else { ?><i>Never</i><?php } ?></td>
            <td>
              <button type="button" name="button" id="deleteCron" data-value="<?= $row->id ?>" class="btn btn-danger btn-sm">Delete</button>
            </td>
          </tr><?php
              }
            } else { ?>
        <tr>
          <td colspan="8" class="text-center">No Cron Jobs</td>
        </tr>
      <?php }
      ?>
    </table>
  </div>
</div>
<?php if ($settings->cron_ip == 'off') {
  $scheme = isHTTPSConnection() ? 'https' : 'http';
  $cronUrl = $scheme . '://' . Server::get('HTTP_HOST') . $us_url_root . 'users/cron/cron.php';
?>
<div class="card mt-3">
  <div class="card-header bg-light">
    <strong>About the Cron Manager</strong>
  </div>
  <div class="card-body">
    <p>This manager lets you run <strong>automated PHP scripts</strong> on a schedule. Add your PHP files to <code>users/cron/</code>, register them here, and they'll execute in <strong>sort order</strong> whenever your server's cron calls the endpoint.</p>

    <p class="mb-2"><strong>Setup Steps:</strong></p>
    <ol class="mb-0">
      <li>Place your PHP script in <code>users/cron/</code> (e.g., <code>my_task.php</code>).</li>
      <li>Click <strong>Add</strong> above to register it with a name, filename, and sort order.</li>
      <li>Configure your server's cron to request <code><?= $cronUrl ?></code> at your desired interval.</li>
      <li>Check <a href="admin.php?view=logs">the system logs</a> for the <strong>rejected IP address</strong> from your first cron attempt.</li>
      <li>Go to <a href="admin.php?view=general">the admin dashboard</a> and whitelist that IP in the <strong>"Only allow cron jobs from the following IP"</strong> field.</li>
    </ol>
  </div>
</div>
<?php } ?>

<div id="addcron" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">New Cron</h4>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" data-bs-dismiss="modal">&times;</button>
      </div>
      <form class="form-signup" action="" method="POST">
        <div class="modal-body">

          <label>Cron Name: </label><input type="text" class="form-control" id="name" name="name" placeholder="Cron Name" required>

          <label>File: </label><input type="text" class="form-control" id="file" name="file" placeholder="File (include type, e.g. .php) within the cron folder only" required>

          <label>Sort: </label><input type="text" class="form-control" id="sort" name="sort" placeholder="3 digit sort code, crons run by this order, eg 100, 101, 102" required>
          <br />
        </div>
        <div class="modal-footer">

          <input type="hidden" name="csrf" value="<?= $cs; ?>" />
          <input class='btn btn-primary mr-2' type='submit' name="addCron" value='Add Cron' />
          <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">Close</button>

        </div>
      </form>
    </div>
  </div>
</div>

<script nonce="<?=htmlspecialchars($userspice_nonce ?? '')?>" type="text/javascript" src="<?= $us_url_root ?>users/js/oce.js?v2"></script>
<script nonce="<?=htmlspecialchars($userspice_nonce ?? '')?>" type="text/javascript">
  function messages(data) {
    data = JSON.parse(data);
    $('#messages').removeClass();
    $('#message').text("");
    $('#messages').show();
    if (data.success == "true") {
      $('#messages').addClass("sufee-alert alert with-close alert-success alert-dismissible fade show");
    } else {
      $('#messages').addClass("sufee-alert alert with-close alert-danger alert-dismissible fade show");
    }
    $('#message').text(data.msg);
    $('#messages').delay(3000).fadeOut('slow');

  }

  function success(resp) {
    console.log(resp);
    messages(resp);

  }

  $(document).ready(function() {
    var options = {
      url: 'parsers/cron_post.php',
      token: '<?= $cs; ?>>'
    };
    $('.txt').oneClickEdit(options, success);


    var active = {
      url: 'parsers/cron_post.php',
      selectOptions: {
        0: 'Inactive',
        1: 'Active'
      },
      token: '<?= $cs; ?>'

    }
    $('.cronactive').oneClickEdit(active, success);

    $(document).on("click", "#deleteCron", function() {
      var deleteMe = $(this).attr("data-value");;
      var formData = {
        'value': deleteMe,
        'field': 'deleteMe',
        'token': '<?= $cs; ?>',
      };

      $.ajax({
          type: 'POST',
          url: 'parsers/cron_post.php',
          data: formData,
          dataType: 'json',
        })

        .done(function(data) {
          console.log("refreshing");
          window.location.assign(document.URL);

        })
    });
  });
</script>
