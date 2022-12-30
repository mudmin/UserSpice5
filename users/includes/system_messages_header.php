<?php
//This file prepares the proper divs as needed to display the 5 classes of
//UserSpice system messages independent of the template
//it can be included separately on pages where you don't call prep.php
//note that if you create a usersc/includes/system_messages_header.php
//your file will be included instead of ours
?>
<style media="screen">
  .usmsgblock {
    z-index: 999 !important;
    position: fixed;
    top: 4.5em;
    right: 1em;
  }
  .usmsg {
    border: 1px solid;
  }
</style>
<div class="usmsgblock">
<?php
$usmsgs = array(
  'err',    //url err= messages
  'msg',    //urk msg= messages
  'valSuc', //Validation class success messages
  'valErr', //Validation class error messages
  'genMsg', //misc messages
  );
foreach($usmsgs as $u){ ?>
<div style="" id="<?=$u?>UserSpiceMessages" class="show d-none">
  <span id="<?=$u?>UserSpiceMessage"></span>
  <button type="button" class="close btn-close" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?>
</div>
