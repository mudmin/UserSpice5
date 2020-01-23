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
<?php $dataB = $db->query("select version()")->results(true);?>

<?php
if(!empty($_POST['submitKey'])){
  $spice_api = Input::get("spice_api");
  $db->update('settings',1,['spice_api'=>$spice_api]);
  Redirect::to('admin.php?view=bugs&err=Key Added');
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

  // $api = "http://127.0.0.1/bugs/api_bugs.php";
  $api = "https://userspice.com/bugs/api_bugs.php";
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
    Redirect::to('?view=bugs&err='.$result->msg);
    // err($result->msg); //maybe a different alert later
  }else{
    Redirect::to('?view=bugs&err='.$result->msg);
  }
}
?>
<div class="content mt-3">
  <h2>Bug Report</h2>
  <p>A System report will be submitted with the following information to help in the diagnosis of the problem.  If you don't want to submit this information, please submit a report directly at https://userspice.com/bugs. Please note that the API may collect other information about the API call itself in order to prevent spam.
  </p>
  <?php if($settings->spice_api == ''){ ?>
    <a href="https://userspice.com/developer-api-keys/"><font color='red'><strong>The Bug Report feature will not work with out a FREE API Key.</font></strong>
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


    <form class="" action="admin.php?view=bugs" method="post">
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
    <div class="col-12"><br>
      <h3>Your Previous Reports</h3>
      <?php $prev = $db->query("SELECT * FROM logs WHERE logtype = ? ORDER BY id DESC",["your_api_bugs"])->results();?>
      <table class="table table-striped">
        <?php foreach($prev as $p){ ?>
          <tr>
            <td><a href="https://userspice.com/bugs/usersc/issue_detail.php?id=<?=$p->lognote?>">Issue #<?=$p->lognote?></a></td>
            <td><a href="https://userspice.com/bugs/usersc/issue_detail.php?id=<?=$p->lognote?>"><?=$p->logdate?></a></td>
          </tr>
        <?php } ?>
      </table>
    </div>
  </div>
