<?php
//This file parses all the various messages that are stored in
//$_GET and $_SESSION variables and displays them
//note that if you create a usersc/includes/system_messages_footer.php
//your file will be included instead of ours

//Grab all the various session messages and parse them
$usSessionMessages = parseSessionMessages();
//you can create your own $usSessionMessageClasses to choose your own classes
//just include it anywhere before the footer (head_tags is a good choice)
if(!isset($usSessionMessageClasses)){
  $usSessionMessageClasses = array(
    'err'=>"primary",       //err= in the url
    'msg'=>"info",          //msg= in the url
    'genMsg'=>"dark",       //$_SESSION[Config::get('session/session_name')."genMsg"]
    'valSuc'=>"success",    //validation class success message
    'valErr'=>"danger",     //validation class error message
  );
}
//Grab GET variables and display anything you have
?>
<script type="text/javascript">
$(document).ready(function() {
<?php
  //look for the old school ?err=Whatever in the url
  if (Input::get('err') != '') { ?>
    userSpiceMessages("<?php echo htmlspecialchars_decode(htmlspecialchars(Input::get('err'))); ?>","errUserSpiceMessage","<?php echo $usSessionMessageClasses['err']; ?>");
<?php
  }

  //look for the old school ?msg=Whatever in the url
  if (Input::get('msg') != '') { ?>
    userSpiceMessages("<?php echo htmlspecialchars_decode(htmlspecialchars(Input::get('msg'))); ?>","msgUserSpiceMessage","<?php echo $usSessionMessageClasses['msg']; ?>");

<?php }
    //define the types of messages and what class they get
    $keys = [
      'genMsg' => $usSessionMessageClasses['genMsg'],
      'valSuc' => $usSessionMessageClasses['valSuc'],
      'valErr' => $usSessionMessageClasses['valErr'],
    ];

    //Display any messages that have been set in the $_SESSION variables
    foreach ($keys as $key => $class) {
        if (isset($usSessionMessages[$key]) && $usSessionMessages[$key] != '') { ?>
        userSpiceMessages("<?php echo htmlspecialchars_decode(htmlspecialchars($usSessionMessages[$key])); ?>","<?php echo $key; ?>UserSpiceMessage","<?php echo $class; ?>");
        <?php
      }
    }
    if (isset($settings->err_time)) {
        $usMsgErrorTimeout = $settings->err_time * 1000;
    } else {
        $usMsgErrorTimeout = 10000;
    }
    ?>

    function userSpiceMessages(msg,div,cls="") {
      $('#'+div+'s').removeClass();
      $('#'+div).text("");
      $('#'+div+'s').show();
      $('#'+div+'s').addClass("sufee-alert alert with-close alert-"+cls+" alert-dismissible fade show usmsg");
      $('#'+div).html(msg);
      $('#'+div+'s').delay(<?php echo $usMsgErrorTimeout; ?>).fadeOut('slow');
    }
  });
</script>
