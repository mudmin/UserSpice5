<?php
$errors = [];
$successes = [];
$w = Input::get("w");
$token = Token::generate();
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

<?php resultBlock($errors, $successes); ?>

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
      </tbody>
    </table>
  </div>
</div>

<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>" type="text/javascript" src="<?= $us_url_root ?>users/js/pagination/datatables.min.js"></script>
<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>">
  $(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const whitelistFilter = urlParams.get('w') || '';

    $('#seclogstable').DataTable({
      pageLength: 25,
      stateSave: true,
      aLengthMenu: [ [25, 50, 100, -1], [25, 50, 100, "All"] ],
      aaSorting: [],
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?= $us_url_root ?>users/parsers/ssp_security_logs.php",
        type: "GET",
        data: {
          token: "<?= $token ?>",
          w: whitelistFilter
        }
      },
      // Disable sorting on columns that don't make sense to sort
      columnDefs: [
        { "targets": [1], "orderable": false } // User column might be complex to sort
      ]
    });
  });
</script>