<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
        <li>Tools</li>
        <li><a href="<?=$us_url_root?>users/admin.php?view=logs">Logs</a></li>
        <li class="active">System Logs</li>
      </ol>
    </div>
  </div>
</div>
</div>
</header>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap-editable/css/bootstrap-editable.css" integrity="sha256-YsJ7Lkc/YB0+ssBKz0c0GTx0RI+BnXcKH5SpnttERaY=" crossorigin="anonymous" />
<style>
.editableform-loading {
  background: url('https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap-editable/img/loading.gif') center center no-repeat !important;
}
.editable-clear-x {
  background: url('https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap-editable/img/clear.png') center center no-repeat !important;
}
</style>

<?php
$errors = $successes = [];
$form_valid=TRUE;
//Forms posted
if (!empty($_POST)) {
  $token = $_POST['csrf'];
  if(!Token::check($token)){
    include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
  }
  if(!empty($_POST['addLog'])) {
    $name = Input::get('name');

    $form_valid=FALSE; // assume the worst
    $validation = new Validate();
    $validation->check($_POST,array(
      'name' => array(
        'display' => 'Type',
        'required' => true,
        'min' => 2,
        'max' => 255,
      ),
    ));
    if($validation->passed()) {
      $form_valid=TRUE;
      try {
        $fields=array(
          'name' => Input::get('name'),
          'createdby' => $user->data()->id,
          'created' => date("Y-m-d H:i:s")
        );
        $db->insert('logs_exempt',$fields);

        $logname=("System");
        $lognote=("Added Log Type Exemption for $name");
        logger($user->data()->id,$logname,$lognote);
        $successes[] = lang("ADDED_LOG");

      } catch (Exception $e) {
        die($e->getMessage());
      }

    }
  } }
  $query = $db->query("SELECT *,COUNT(*) AS count FROM logs GROUP BY logtype ORDER BY count DESC,logtype");
  $count = $query->count();
  ?>


  <div class="content mt-3">
    <h2>Logs Manager <a class="nounderline" href="../users/admin.php?view=logsman"><i class="fa fa-fw fa-refresh"></i></a> <a class="nounderline" href="../users/admin_logs.php"><i class="fa fa-fw fa-search"></i></a></h2>
    <hr>
    <center>
      <div>
        <table class="table table-bordered">
          <tr>
            <tr>
              <th><center>Log Type</center></th>
              <th><center>Count</center></th>
              <th><center>Exempted?</center></th>
              <th><center>Mapper Function</center></th>
            </tr>
            <?php
            if($count > 0)
            {
              foreach ($query->results() as $row){ ?>
                <tr>
                  <td><center><?=$row->logtype;?></center></td>
                  <td><center><?=$row->count;?></center></td>
                  <?php $exempt = $db->query("SELECT name FROM logs_exempt WHERE name = ?",array($row->logtype));
                  if($exempt->count() > 0) $exp = 1;
                  else $exp = 0; ?>
                  <td><center><a href="#" data-name="exempt" id="exempt" data-value="<?=$exp?>" class="exempt nounderline" data-mode="popup" data-type="select" data-pk="<?=$row->logtype;?>" data-url="admin_logs_exempt.php" data-title="Do you wish to exempt logs for <?=$row->logtype;?>?"><?php if($exempt->count() > 0) {?>Yes<?php } else {?> No<?php } ?></a></center></td>
                  <td><center><a href="#" data-name="mapper" id="mapper" class="mapper nounderline" data-mode="popup" data-type="select" data-pk="<?=$row->logtype;?>" data-url="admin_logs_mapper.php" data-title="What would you like to map <?=$row->logtype;?> as?">Map</a></center></td>
                </tr><?php
              } }
              else
              { ?>
                <tr><td colspan='4'><center>No Logs</center></td></tr>
              <?php }
              ?>
            </table>
          </div>
        </center>
        <br />
      </div> <!-- /.page-wrapper -->

      <div id="addexemption" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Log Type Exemption Addition</h4>
            </div>
            <div class="modal-body">
              <form class="form-signup" action="logsman.php" method="POST">
                <div class="panel-body">

                  <label>Log Type: </label>
                  <select name="type" class="form-control combobox" required>
                    <option readonly></option>
                    <?php
                    $typeQuery = $db->query("SELECT logtype FROM logs WHERE logtype NOT IN (SELECT name FROM logs_exempt) GROUP BY logtype");
                    $typeCount = $typeQuery->count();
                    if($typeCount > 0) {
                      foreach ($typeQuery->results() as $results) {?>
                        <option value="<?=$results->logtype?>"><?=$results->logtype?></option>
                      <?php } } else {?>
                        <option readonly>No Options Found</option>
                      <?php } ?>
                    </select>
                    <br />
                  </div>
                  <div class="modal-footer">
                    <div class="btn-group">	<input type="hidden" name="csrf" value="<?=Token::generate();?>" />
                      <input class='btn btn-info' type='submit' name="addLog" value='Add Exemption' class='submit' /></div>
                    </form>
                    <div class="btn-group"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                  </div>
                </div> <!-- /.row -->
              </div> <!-- /.container -->
            </div> <!-- /.wrapper -->
          </div>

          <script type="text/javascript" src="js/pagination/datatables.min.js"></script>
          <script src="js/jwerty.js"></script>
          <script src="js/bootstrap-editable.js"></script>
          <script type="text/javascript">
          $(document).ready(function() {
            $.fn.editable.defaults.mode = "inline"

            $(".exempt").editable({
              source: [
                {value: "1", text: "Yes"},
                {value: "0", text: "No"},
              ]
            });

            $(".mapper").editable({
              source: [
                <?php foreach($db->query("SELECT * FROM logs GROUP BY logtype ORDER BY logtype")->results() as $row) {?>
                  {value: "<?=$row->logtype?>", text: "<?=$row->logtype?>"},<?php } ?>
                ]
              });
            });
          </script>
