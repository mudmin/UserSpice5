<div class="col-sm-8">
  <div class="page-header float-right">
    <div class="page-title">
      <ol class="breadcrumb text-right">
        <ol class="breadcrumb text-right">
          <li><a href="<?=$us_url_root?>users/admin.php">Dashboard</a></li>
          <li>Submit</li>
          <li class="active">Bug Report</li>
        </ol>
      </ol>
    </div>
  </div>
</div>
</div>
</header>
<?php $dataB = $db->query("select version()")->results(true);

$api = "https://api.userspice.com/api/v2/bugs/";



if(!empty($_POST['submitKey'])){
  $spice_api = Input::get("spice_api");
  $db->update('settings',1,['spice_api'=>$spice_api]);
  usSuccess("Key added");
  Redirect::to('admin.php?view=bugs');
}
if(!empty($_POST) && $settings->spice_api != ''){
  $data = array(
    'key' => $settings->spice_api,
    'us'=>Input::sanitize($user_spice_ver),
    'db'=>Input::sanitize($dataB[0]["version()"]),
    'os'=>Input::sanitize(php_uname('s')."-".php_uname('v')),
    'sw'=>Input::sanitize($_SERVER['SERVER_SOFTWARE']),
    'brief'=>Input::get('brief'),
    'bt'=>Input::get('bugtype'),
    'problem'=>Input::get('problem'),
    'call'=>"bugreport"
  );


  $payload = json_encode($data);

  $ch = curl_init($api);

  //attach encoded JSON string to the POST fields
  curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
  //set the content type to application/json
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  //return response instead of outputting
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //execute the POST request
  $result = curl_exec($ch);

  //close cURL resource
  curl_close($ch);
  $result = json_decode($result);
  // dnd($result);
  if($result->success == true){
    logger($user->data()->id,"your_api_bugs",$result->issue);
    usSuccess($result->msg);
    Redirect::to('?view=bugs');
    // err($result->msg); //maybe a different alert later
  }else{
    usError($result->msg);
    Redirect::to('?view=bugs');
  }
}
if($settings->spice_api != ''){
  $data = array(
    'key' => $settings->spice_api,
    'call'=>"fetch"
  );
  $payload = json_encode($data);
  $ch = curl_init($api);
  //attach encoded JSON string to the POST fields
  curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
  //set the content type to application/json
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  //return response instead of outputting
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //execute the POST request
  $result = curl_exec($ch);
  //close cURL resource
  curl_close($ch);
  $result = json_decode($result);
}
?>
<div class="content mt-3">
  <h2>Bug Report</h2>
  <p>A System report will be submitted with the following information to help in the diagnosis of the problem.  If you don't want to submit this information, please submit a report directly at https://bugs.userspice.com. Please note that the API may collect other information about the API call itself in order to prevent spam.
  </p>
  <?php if($settings->spice_api == ''){ ?>
    <a href="https://userspice.com/developer-api-keys/"><span style='color:red'><strong>The Bug Report feature will not work with out a FREE API Key.</span></strong>
      Get One Here</a>
      <form class="" action="" method="post">
        <input type="password" autocomplete="new-password" class="form-control" data-desc="UserSpice API Key" name="spice_api" id="spice_api" value="<?=$settings->spice_api?>" placeholder="Paste your key here">
        <input type="submit" name="submitKey" value="Save Key">
      </form>

    <?php } ?>
    <h3>System Report</h3><br>
    <strong>UserSpice Version:</strong> <?=$user_spice_ver?><br>
    <strong>DB Version:</strong> <?=$dataB[0]["version()"];?><br>
    <strong>OS Info:</strong> <?=php_uname('s');?>-<?=php_uname('v');?></br>
    <strong>Software Info:</strong> <?=$_SERVER['SERVER_SOFTWARE']?><br><br>


    <form class="" action="" method="post">
      <label for="">Please give a brief summary of the problem</label>
      <input class="form-control" type="text" name="brief" value="" required>
      <label for="">What type of bug report is this?</label>
      <select class="form-control" name="bugtype" required>
        <option value="" disabled selected="selected">--Please Choose--</option>
        <option value="triage">General UserSpice Bug</option>
        <option value="plugin">Plugin/Widget/Template issue</option>
      </select>
      <label for="">Please give as much detail about how to recreate your problem as possible.</label>
      <textarea class="form-control" name="problem" rows="8" cols="80" required></textarea><br>
      <?php if($settings->spice_api != ''){ ?>
        <input type="submit" name="submit" value="Submit Bug Report" class="btn btn-danger">
      <?php } ?>
    </form>
    <?php if(isset($result) && count($result->fetch) > 0){ ?>
    <div class="col-12"><br>
      <h3>Your Previous Reports</h3>
      <table id="bugstable" class="table table-striped paginate">
        <thead>
          <tr>
            <th>Issue ID</th>
            <th>Issue Title</th>
            <th>Resolution</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($result->fetch as $p){ ?>
          <tr>
            <td>Issue #<?=$p->kIssueID?></td>
            <td><?=$p->Issue_Title?></td>
            <td><?=$p->Issue_Resolution_Title?></td>
            <td><a class="btn btn-primary" href="https://bugs.userspice.com/usersc/issue_detail.php?id=<?=$p->kIssueID?>">View Ticket</a></td>
          </tr>
        <?php } ?>
      </tbody>
      </table>
    </div>
  </div>
  <script type="text/javascript" src="<?=$us_url_root?>users/js/pagination/datatables.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function () {
     $('.paginate').DataTable({"pageLength": 25,"stateSave": true,"aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 250, 500]], "aaSorting": []});
    });

  </script>
<?php } ?>
