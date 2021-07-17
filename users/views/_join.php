<?php
/*
This is a user-facing page
UserSpice 5
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

Special thanks to John Bovey for the password strenth feature.
*/
?>
<style>
.gray_out_icon{
  -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
  filter: grayscale(100%);
}
.gray_out_text{
  opacity: .5;
}
</style>

<div class="row">
  <div class="col-sm-12">
    <?php
    if (!$form_valid && Input::exists()){?>
      <?php if(!$validation->errors()=='') { display_errors($validation->errors()); } ?>
    <?php }
    includeHook($hooks,'body');
    ?>

    <form class="form-signup" action="" method="<?=$form_method;?>" id="payment-form">

      <h2 class="form-signin-heading"> <?=lang("SIGNUP_TEXT","");?></h2>

      <div class="form-group">
        <label id="username-label"><?=lang("GEN_UNAME");?>*</label>
        <span id="usernameCheck" class="small"></span>

        <input type="text" class="form-control" id="username" name="username" placeholder="<?=lang("GEN_UNAME");?>"
        value="<?php if (!$form_valid && !empty($_POST)){ echo $username;} ?>"
        required autofocus autocomplete="username">
      </div>

      <div class="form-group">
        <label for="fname" id="fname-label"><?=lang("GEN_FNAME");?>*</label>

        <input type="text" class="form-control" id="fname" name="fname" placeholder="<?=lang("GEN_FNAME");?>" value="<?php if (!$form_valid && !empty($_POST)){ echo $fname;} ?>"
        required autofocus autocomplete="first-name">
      </div>

      <div class="form-group">
        <label for="lname" id="lname-label"><?=lang("GEN_LNAME");?>*</label>

        <input type="text" class="form-control" id="lname" name="lname" placeholder="<?=lang("GEN_LNAME");?>" value="<?php if (!$form_valid && !empty($_POST)){ echo $lname;} ?>"
        required autocomplete="family-name">
      </div>

      <div class="form-group">
        <label for="email" id="email-label"><?=lang("GEN_EMAIL");?>*</label>

        <input  class="form-control" type="text" name="email" id="email" placeholder="<?=lang("GEN_EMAIL");?>" value="<?php if (!$form_valid && !empty($_POST)){ echo $email;} ?>"
        required autocomplete="email">
      </div>

      <div class="form-group">
        <?php
        $character_range = lang("GEN_MIN")." ".$settings->min_pw . " ". lang("GEN_AND") ." ". $settings->max_pw . " " .lang("GEN_MAX")." ".lang("GEN_CHAR");
        $character_statement = '<span id="character_range" class="gray_out_text">' . $character_range . ' </span>';

        if ($settings->req_cap == 1){
          $num_caps = '1'; //Password must have at least 1 capital
          if($num_caps != 1){
            $num_caps_s = 's';
          }
          $num_caps_statement = '<span id="caps" class="gray_out_text">'.lang("JOIN_HAVE") . $num_caps . lang("JOIN_CAP") .'</span>';
        }

        if ($settings->req_num == 1){
          $num_numbers = '1'; //Password must have at least 1 number
          if($num_numbers != 1){
            $num_numbers_s = 's';
          }

          $num_numbers_statement = '<span id="number" class="gray_out_text">'.lang("JOIN_HAVE") . $num_numbers . " " . lang("GEN_NUMBER") .'</span>';
        }
        $password_match_statement = '<span id="password_match" class="gray_out_text">'.lang("JOIN_TWICE").'</span>';
        ?>

        <div style="display: inline-block">
          <label for="password" id="password-label"><?=lang("GEN_PASS");?>* (<?=lang("GEN_MIN");?> <?=$settings->min_pw?> <?=lang("GEN_AND");?> <?=lang("GEN_MAX");?> <?=$settings->max_pw?> <?=lang("GEN_CHAR");?>)</label>

          <input  class="form-control" type="password" name="password" id="password" placeholder="<?=lang("GEN_PASS");?>"
          required autocomplete="new-password" aria-describedby="passwordhelp">

          <label for="confirm" id="confirm-label"><?=lang("PW_CONF");?>*</label>

          <input  type="password" id="confirm" name="confirm" class="form-control" placeholder="<?=lang("PW_CONF");?>"
          required autocomplete="new-password" >
        </div>

        <div style="display: inline-block; padding-left: 20px">
          <strong><?=lang("PW_SHOULD");?></strong><br>
          <span id="character_range_icon" class="fa fa-thumbs-o-up gray_out_icon" style="color: green"></span>&nbsp;&nbsp;<?php echo $character_statement;?>

          <br>

          <?php
          if ($settings->req_cap == 1){ ?>
            <span id="num_caps_icon" class="fa fa-thumbs-o-up gray_out_icon" style="color: green"></span>&nbsp;&nbsp;<?php echo $num_caps_statement;?>
            <br>
          <?php }

          if ($settings->req_num == 1){ ?>
            <span id="num_numbers_icon" class="fa fa-thumbs-o-up gray_out_icon" style="color: green"></span>&nbsp;&nbsp;<?php echo $num_numbers_statement;?>
            <br>
          <?php } ?>

          <span id="password_match_icon" class="fa fa-thumbs-o-up gray_out_icon" style="color: green"></span>&nbsp;&nbsp;<?php echo $password_match_statement;?>

          <br><br>

          <a class="nounderline" id="password_view_control"><span class="fa fa-eye"></span> <?=lang("PW_SHOWS");?></a>
        </div>
      </div>

      <?php
      includeHook($hooks,'form');
      include($abs_us_root.$us_url_root.'usersc/scripts/additional_join_form_fields.php');
      ?>

      <input type="hidden" value="<?=Token::generate();?>" name="csrf">

      <div class="form-group">
        <button class="submit btn btn-primary " type="submit" id="next_button"><i class="fa fa-plus-square"></i> <?=lang("SIGNUP_TEXT");?></button>
      </div>

    </form>
    <br>
  </div>
</div>


<script type="text/javascript">
$(document).ready(function(){

  $( "#password" ).keyup(function() {
    var pswd = $("#password").val();

    //validate the length
    if ( pswd.length >= <?=$settings->min_pw?> && pswd.length <= <?=$settings->max_pw?> ) {
      $("#character_range_icon").removeClass("gray_out_icon");
      $("#character_range").removeClass("gray_out_text");
    } else {
      $("#character_range_icon").addClass("gray_out_icon");
      $("#character_range").addClass("gray_out_text");
    }

    //validate capital letter
    if ( pswd.match(/[A-Z]/) ) {
      $("#num_caps_icon").removeClass("gray_out_icon");
      $("#caps").removeClass("gray_out_text");
    } else {
      $("#num_caps_icon").addClass("gray_out_icon");
      $("#caps").addClass("gray_out_text");
    }

    //validate number
    if ( pswd.match(/\d/) ) {
      $("#num_numbers_icon").removeClass("gray_out_icon");
      $("#number").removeClass("gray_out_text");
    } else {
      $("#num_numbers_icon").addClass("gray_out_icon");
      $("#number").addClass("gray_out_text");
    }
  });

  $( "#confirm" ).keyup(function() {
    var pswd = $("#password").val();
    var confirm_pswd = $("#confirm").val();

    //validate password_match
    if (pswd == confirm_pswd) {
      $("#password_match_icon").removeClass("gray_out_icon");
      $("#password_match").removeClass("gray_out_text");
    } else {
      $("#password_match_icon").addClass("gray_out_icon");
      $("#password_match").addClass("gray_out_text");
    }

  });
});
</script>
