<?php
$errors = $successes = [];
$form_valid = TRUE;
//Forms posted
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
        die($e->getMessage());
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
    <div class="float-right mb-2">
      <div class="btn-group"><button class="btn btn-primary" data-toggle="modal" data-bs-toggle="modal" data-target="#addcron" data-bs-target="#addcron"><i class="fa fa-plus"></i> add</button></div>
    </div>
    <table class="table table-bordered">
      <tr>
        <th class="text-center">ID</th>
        <th class="text-center">Status</th>
        <th class="text-center">Cron Name</th>
        <th class="text-center">Cron File</th>
        <th class="text-center">Sort</th>
        <th class="text-center">Created By</th>
        <th class="text-center">Last Ran</th>
        <th class="text-center">Functions</th>
      </tr>
      <?php
      if ($count > 0) {
        foreach ($query->results() as $row) { ?>
          <tr <?php if ($row->active == 0) { ?> class="bg-light" <?php } ?>>
            <td class="text-center"><?= $row->id; ?></td>
            <td class="text-center">
              <p data-field="active" id="active" class="cronactive nounderline" data-input="select" data-id="<?= $row->id; ?>"><?php if ($row->active == 0) { ?>Inactive<?php }
                                                                                                                                                                if ($row->active == 1) { ?>Active <?php } ?></p>
            </td>
            <td>
              <p data-field="name" class="cronname nounderline txt text-center" data-input="input" data-id="<?= $row->id; ?>" data-title="Rename Cron ID <?= $row->id; ?>"><?= $row->name; ?></p>
            </td>
            <td>
              <p data-field="file" class="cronfile nounderline txt text-center" data-input="input" data-id="<?= $row->id; ?>" data-title="Change File for <?= $row->name; ?>"><?= $row->file; ?></p>
            </td>
            <td>
              <p data-field="sort" class="cronsort nounderline txt text-center" data-input="input" data-id="<?= $row->id; ?>" data-title="Change sort for <?= $row->name; ?>"><?= $row->sort; ?></p>
            </td>
            <td class="text-center"><?= echousername($row->createdby); ?></td>
            <td class="text-center">
              <?php $ranQ = $db->query("SELECT datetime,user_id FROM crons_logs WHERE cron_id = ? ORDER BY datetime DESC", array($row->id));
              $ranCount = $ranQ->count();
              if ($ranCount > 0) {
                $ranResult = $ranQ->first(); ?>
                <?= $ranResult->datetime; ?> (<?= echousername($ranResult->user_id); ?>)<?php } else { ?><i>Never</i><?php } ?></td>
            <td class="text-center">
              <button type="button" name="button" id="deleteCron" data-value="<?= $row->id ?>" class="btn btn-danger">Delete</button>
            </td>
          </tr><?php
              }
            } else { ?>
        <tr>
          <td colspan='7' class="text-center">No Cron Jobs</td>
        </tr>
      <?php }
      ?>
    </table>
  </div>
</div>
<br />
<?php if ($settings->cron_ip == 'off') { ?>
  <strong>Note:</strong>
  A cron job is an automated task which allows you to perform powerful tasks without your interaction. Before implementing cron jobs,
  you want to do some thinking about security. In almost all circumstances, you do not want someone to be able to type <?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $us_url_root . 'users/cron/cron.php' ?>
  and run a bunch of commands on your server.<br><br>

  The recommended way of implementing cron jobs is...<br>
  Step 1: Go into your server and set your cron job to fire off to <?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $us_url_root . 'users/cron/cron.php' ?> every few minutes.<br>
  Step 2: Go into <a href="admin.php?view=logs">the system logs</a> and see which ip address was rejected for trying to do a cron job.<br>
  Step 3: Then go into <a href="admin.php?view=general">the admin dashboard"</a> and set that IP address in the 'Only allow cron jobs from the following IP' box.<br>
  Step 4: Go back into your server and set your cron job for a more reasonable amount of time. Most server admins don't want you running cron jobs every few minutes. Every hour or even every day is more reasonable.
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

          <input type="hidden" name="csrf" value="<?= Token::generate(); ?>" />
          <input class='btn btn-primary mr-2' type='submit' name="addCron" value='Add Cron' />
          <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">Close</button>

        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?= $us_url_root ?>users/js/oce.js"></script>
<script type="text/javascript">
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
      token: '<?= Token::generate() ?>'
    };
    $('.txt').oneClickEdit(options, success);


    var active = {
      url: 'parsers/cron_post.php',
      selectOptions: {
        0: 'Inactive',
        1: 'Active'
      },
      token: '<?= Token::generate() ?>'

    }
    $('.cronactive').oneClickEdit(active, success);

    $(document).on("click", "#deleteCron", function() {
      var deleteMe = $(this).attr("data-value");;
      var formData = {
        'value': deleteMe,
        'field': 'deleteMe',
        'token': '<?= Token::generate() ?>',
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