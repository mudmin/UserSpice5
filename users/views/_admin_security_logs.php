<?php
$errors = [];
$successes = [];
$ignore = [];
$w = Input::get("w");
if ($w != "") {
  $ips = $db->query("SELECT * FROM us_ip_whitelist")->results();
  foreach ($ips as $i) {
    $ignore[] = $i->ip;
  }
}
?>
<style>
  tfoot input {
    width: 100%;
    box-sizing: border-box;
  }
</style>
<link rel="stylesheet" href="<?= $us_url_root ?>users/js/pagination/datatables.min.css">

<div class="row">
  <div class="col-12 col-sm-5">
    <h2 class="mb-3">Security Logs</h2>
  </div>
  <div class="col-12 col-sm-7 text-end">
    <?php if ($w != "") { ?>
      <h4><span style="color:red">Currently Ignoring Whitelisted IPs</h4>
      <a href="admin.php?view=security_logs" class="btn btn-primary">Show All</a>
    <?php } else { ?>
      <a href="admin.php?view=security_logs&w=true" class="btn btn-primary">Hide Whitelisted IPs</a>
    <?php } ?>
  </div>
</div>

<p>These logs are updated every time someone tries to access a page that they do not have permission to access. Note that this could be because they are logged out, from a bad redirect, or many other causes other than someone attempting to hack your system.</p>
<!-- <a href='admin.php?view=logsman'>Go to Logs Manager</a> -->
<?php resultBlock($errors, $successes);
$logs = $db->query("SELECT * FROM audit ORDER BY id DESC LIMIT 5000")->results(); ?>
<div class="card">

  <div class="card-body table-sm table-responsive">
    <table id="seclogstable" class='table table-hover table-striped table-list-search display'>
      <thead>
        <tr>
          <th scope="col" class="text-start">Log ID</th>
          <th scope="col" class="text-start">User</th>
          <th scope="col" class="text-start">Page Attempted</th>
          <th scope="col" class="text-start">IP</th>
          <th scope="col" class="text-start">Timestamp</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($logs as $m) {
          if (in_array($m->ip, $ignore)) {
            continue;
          }
        ?>
          <tr>
            <td><?= $m->id ?></td>
            <td><?php
                if ($m->user > 0) {
                  echouser($m->user);
                } else {
                  $q = $db->query("SELECT * FROM us_ip_list WHERE ip = ? ORDER BY id DESC", array($m->ip));
                  $c = $q->count();
                  if ($c > 0) {
                    $f = $q->first();
                    echo "IP last used by ";
                    echouser($f->user_id);
                  } else {
                    echo "<span style='color:red'>Unknown IP</span>";
                  }
                }
                ?></td>

            <td><?php echopage($m->page); ?></td>
            <td><?= $m->ip ?></td>
            <td><?= $m->timestamp ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script type="text/javascript" src="<?= $us_url_root ?>users/js/pagination/datatables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#seclogstable').DataTable({
      "pageLength": 25,
      "stateSave": true,
      "aLengthMenu": [
        [25, 50, 100, -1],
        [25, 50, 100, 250, 500]
      ],
      "aaSorting": []
    });
  });
</script>