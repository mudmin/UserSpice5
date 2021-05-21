<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
        <ol class="breadcrumb text-right">
          <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
          <li>Tools</li>
          <li class="active">Notifications</li>
        </ol>
    </div>
  </div>
</div>
</div>
</header>
<?php
if($settings->notifications != 1){
  Redirect::to($us_url_root.'users/admin.php?err=Notifications+are+disabled');
}else{
  if(!function_exists('fetchMessageUsers')) {
  	function fetchMessageUsers() {
  		$db = DB::getInstance();
  		$settingsQ = $db->query("SELECT msg_blocked_users FROM settings");
  		$settings = $settingsQ->first();
  		if($settings->msg_blocked_users==0) $queryUser = $db->query("SELECT * FROM users WHERE msg_exempt = 0 AND permissions = 1");
  		if($settings->msg_blocked_users==1) $queryUser = $db->query("SELECT * FROM users WHERE msg_exempt = 0");
  		$resultsUser = $queryUser->results();
  		return ($resultsUser);
  	}
  }

  if ($dayLimitQ = $db->query('SELECT notif_daylimit FROM settings', array())) $dayLimit = $dayLimitQ->results()[0]->notif_daylimit;
  else $dayLimit = 7;

  // 2nd parameter- true/false for all notifications or only current
$notifications = new Notifications($user->data()->id, false, $dayLimit);
}
$validation = new Validate();
$errors = [];
$successes = [];

if (!empty($_POST)) {
  $action = Input::get('action');
  if ($action=="read" && isset($_POST['checkbox'])){
    $deletions = $_POST['checkbox'];
    if ($deletion_count = adminNotifications("read",$deletions,$user->data()->id)){
      if($deletion_count==1) $successes[] = "Successfully marked $deletion_count notification read.";
      if($deletion_count >1) $successes[] = "Successfully marked $deletion_count notifications read.";
    }
    else {
      $errors[] = lang("SQL_ERROR");
    }
  }
  if ($action=="unread" && isset($_POST['checkbox'])){
    $deletions = $_POST['checkbox'];
    if ($deletion_count = adminNotifications("unread",$deletions,$user->data()->id)){
      if($deletion_count==1) $successes[] = "Successfully marked $deletion_count notification unread.";
      if($deletion_count >1) $successes[] = "Successfully marked $deletion_count notifications unread.";
    }
    else {
      $errors[] = lang("SQL_ERROR");
    }
  }
  if ($action=="delete" && isset($_POST['checkbox'])){
    $deletions = $_POST['checkbox'];
    if ($deletion_count = adminNotifications("delete",$deletions,$user->data()->id)){
      if($deletion_count==1) $successes[] = "Successfully deleted $deletion_count notification.";
      if($deletion_count >1) $successes[] = "Successfully deleted $deletion_count notifications.";
    }
    else {
      $errors[] = lang("SQL_ERROR");
    }
  }

  if(!empty($_POST['send_mass_message'])){
    $date = date("Y-m-d H:i:s");
    $msg = Input::get('message',TRUE);
    $class = Input::get('class');
    $userData = fetchMessageUsers(); //Fetch information for all users
    foreach($userData as $v1) {
      $notifications->addNotification($msg,$v1->id,$class);

      logger($user->data()->id,"Notifications - Mass","Sent a notification to $v1->fname.");
    }

    $successes[] = "Your mass notification has been sent!";
    logger($user->data()->id,"Notifications - Mass","Finished sending mass message.");
  }
}
$adminNotificationsQ = $db->query("SELECT * FROM notifications ORDER BY date_created DESC");
$adminNotifications = $adminNotificationsQ->results();
$count = $adminNotificationsQ->count();
?>

<div class="content mt-3">
  <h2>Notifications  Manager</h2>
  <?=resultBlock($errors,$successes);?>
  <?php if(!$validation->errors()=='') { display_errors($validation->errors()); } ?>
  <?php if($count > 0) {?><label><input type="checkbox" class="checkAllMsg" />
    [ check/uncheck all ]</label><?php } ?>                         <div class="btn-group pull-right"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#composemass"><i class="fa fa-plus"></i> New Mass Notification</button></div>
    <br><br>
    <form autocomplete="off" name="threads" action="admin.php?view=admin_notifications" method="post">
      <table id="paginate" class="table table-striped">
        <thead>
          <tr>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php if($count > 0) {?>
            <?php foreach($adminNotifications as $m){?>
              <tr>
                <td style="width:85px">
                  <span class="chat-img pull-left" style="padding:5px">
                    <img src="<?=get_gravatar($db->query("SELECT email FROM users WHERE id = $m->user_id")->first()->email)?>" width="75" class="img-thumbnail">
                  </span>
                </td>
                <td><input type="checkbox" class="maincheck" name="checkbox[<?=$m->id?>]" value="<?=$m->id?>"/> <?=echouser($m->user_id)?>, <?=time2str($m->date_created)?><br /><?=html_entity_decode($m->message)?>
                  <br />
                  <?php if($m->is_read==1 && $m->is_archived==0) {?><i class="fa fa-check"></i> Read<?php } if($m->is_read==0 && $m->is_archived==0) { ?> <i class="fa fa-times"></i> Delivered<?php } if($m->is_archived==1) { ?><i class="fa fa-times"></i> Deleted<?php } ?>
                </td>
              </tr>
            <?php  } } else {?>
              <td colspan="2"><center><h3>No Notifications</h3></center></td></tr>
            <?php } ?>
          </tbody>
        </table></center>
        <?php if($count > 0) {?>
          <table class="table pull-right" width="20%">
            <tr>
              <td width="15%">
                <select class="form-control" name="action" required>
                  <option value="">Please select an action...</option>
                  <option value="read">Mark selected notifications read</option>
                  <option value="unread">Mark selected notifications unread</option>
                  <option value="delete">Delete selected notifications</option>
                </select>
              </td>
              <td width="5%">
                <input class='btn btn-primary' type='submit' name="admin_notifications" value='Go!' class='submit' /></td></tr></table>
              <?php } ?>
            </form>
          </div><!-- End of main content section --><br />


          <div id="composemass" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">New Mass Notification</h4>
                </div>
                <div class="modal-body">
                  <form autocomplete="off" name="create_mass_message" action="admin.php?view=admin_notifications" method="post">
                    <label>Class:</label>
                    <select class="form-control" name="class">
                      <option value="success" selected="selected">Success</option>
                      <option value="danger">Danger</option>
                      <option value="warning">Warning</option>
                      <option value="info">Info</option>
                      <option value="primary">Primary</option>
                      <option value="secondary">Secondary</option>
                      <option value="dark">Dark</option>
                    </select>
                    <label>Content:</label>
                    <textarea rows="5" cols="80" class="form-control" name="message"></textarea>
                    <input required type="hidden" name="csrf" value="<?=Token::generate();?>" >
                  </p>
                  <p>
                    <br />
                  </div>
                  <div class="modal-footer">
                    <div class="btn-group">       <input type="hidden" name="csrf" value="<?=Token::generate();?>" />
                      <input class='btn btn-primary' type='submit' name="send_mass_message" value='Send Message' class='submit' /></div>
                    </form>
                    <div class="btn-group"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
                  </div>
                </div>
              </div>
            </div>


            <script>
            $(document).ready(function() {
              $('#paginate').DataTable(
                {  searching: true,
                  "pageLength": 25,"stateSave": true,
                  "ordering": false,
                  "aLengthMenu": [[10, 25, 50, 100,-1], [10, 25, 50,100,"All"]],
                }
              );
              $('.checkAllMsg').on('click', function(e) {
                console.log("clicked");
                $('.maincheck').prop('checked', $(e.target).prop('checked'));
              });
            } );
            </script>
            <script src="../users/js/pagination/dataTables.min.js" type="text/javascript"></script>
