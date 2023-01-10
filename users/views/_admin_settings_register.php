<?php
$settings = $db->query("SELECT * FROM settings")->first();
?>
  <form class="" action="" name="register" method="post">
    <h2 class="mb-3">Registration Settings</h2>
    <div class="row">
      <div class="col-md-6">


        <div class="card mt-2">
          <div class="card-body">
            Please note that you can install the <a href="admin.php?view=spice&search=userinfo">User Info</a> plugin to alter your registration fields.<br><br>
            <div class="form-group">
              <label for="registration">Allow New User Registration <a href="#!" class="nounderline"  title="Registration Switcher! Also controls OAuth (Social Logins). Default: Enabled." ><i class="fa fa-question-circle offset-circle"></i></a></label>
              <span class="float-end offset-switch">
                <label class="switch switch-text switch-success">
                  <div class="form-check form-switch">
                  <input id="registration" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Registration System" <?php if($settings->registration==1) echo 'checked="true"'; ?>>
                </div>
                  <span data-on="Yes" data-off="No" class="switch-label"></span>
                  <span class="switch-handle"></span>
                </label>
              </span>
            </div>

            <div class="form-group">
              <label for="join_vericode_expiry">Registration Vericode Expiry (in hours) <a href="#!" class="nounderline" data-toggle="popover"  data-bs-toggle="tooltip" title="Length of time in hours for expiration of vericodes to email. Maximum: 999999999 (thats nine 9s!). Default: 24"><i class="fa fa-question-circle offset-circle"></i></a></label>
              <div class="input-group">
                <input type="number" step="1" min="1" max="999999999" class="form-control ajxnum" data-desc="Registration Vericode Expiry" name="join_vericode_expiry" id="join_vericode_expiry" value="<?=$settings->join_vericode_expiry?>">
                <span class="input-group-addon input-group-text">Hours</span>
              </div>
            </div>

            <!-- Allow users to change Usernames -->
            <div class="form-group">
              <label for="change_un">Allow users to change their Usernames <a href="#!" class="nounderline"   title="Does as it says. Default: Disabled."><i class="fa fa-question-circle offset-circle"></i></a></label>
              <select id="change_un" class="form-control ajxnum" data-desc="Allow users to change their Usernames" name="change_un">
                <option value="0" <?php if($settings->change_un==0) echo 'selected="selected"'; ?> >Disabled</option>
                <option value="1" <?php if($settings->change_un==1) echo 'selected="selected"'; ?> >Enabled</option>
                <option value="2" <?php if($settings->change_un==2) echo 'selected="selected"'; ?> >Only once</option>
              </select>
            </div>

          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card mt-2">
          <div class="card-body">

            <!-- right -->

            <div class="form-group">
              <label for="req_num">Recommend a Number in the Password?</label>
              <span class="float-end offset-switch">
                <label class="switch switch-text switch-success">
                  <div class="form-check form-switch">
                  <input id="req_num" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Recommend a Number" <?php if($settings->req_num==1) echo 'checked="true"'; ?>>
                </div>
                  <span data-on="Yes" data-off="No" class="switch-label"></span>
                  <span class="switch-handle"></span>
                </label>
              </span>
            </div>
            <div class="form-group">
              <label for="req_cap">Recommend a Capital Letter in the Password?</label>
              <span class="float-end offset-switch">
                <label class="switch switch-text switch-success">
                  <div class="form-check form-switch">
                  <input id="req_cap" type="checkbox" role="switch" class="form-check-input switch-input toggle" data-desc="Recommend a Capital Letter" <?php if($settings->req_cap==1) echo 'checked="true"'; ?>>
                </div>
                  <span data-on="Yes" data-off="No" class="switch-label"></span>
                  <span class="switch-handle"></span>
                </label>
              </span>
            </div>

            <div class="form-group">
              <label for="reset_vericode_expiry">Password Reset Vericode Expiry (in minutes) <a href="#!" class="nounderline"   title="Length of time in minutes for expiration of password reset vericodes to email. Maximum: 999999999 (thats nine 9s!). Default: 15"><i class="fa fa-question-circle offset-circle"></i></a></label>
              <div class="input-group">
                <input type="number" step="1" min="1" max="999999999" class="form-control ajxnum" data-desc="Password Reset Vericode Expiry" name="reset_vericode_expiry" id="reset_vericode_expiry" value="<?=$settings->reset_vericode_expiry?>">
                <span class="input-group-addon input-group-text">Minutes</span>
              </div>
            </div>



            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="min_un">Minimum Username Length</label>
                  <div class="input-group">
                    <input type="number" step="1" min="1" max="255" class="form-control ajxnum" data-desc="Minimum Username Length" name="min_un" id="min_un" value="<?=$settings->min_un?>">
                    <span class="input-group-addon input-group-text">characters</span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="max_un">Maximum Username Length</label>
                  <div class="input-group">
                    <input type="number" step="1" min="1" max="255" class="form-control ajxnum" data-desc="Maximum Username Length" name="max_un" id="max_un" value="<?=$settings->max_un?>">
                    <span class="input-group-addon input-group-text">characters</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="min_pw">Minimum Password Length</label>
                  <div class="input-group">
                    <input type="number" step="1" min="4" max="150" class="form-control ajxnum" data-desc="Minimum Password Length" name="min_pw" id="min_pw" value="<?=$settings->min_pw?>">
                    <span class="input-group-addon input-group-text">characters</span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="max_pw">Maximum Password Length</label>
                  <div class="input-group">
                    <input type="number" step="1" min="4" max="150" class="form-control ajxnum" data-desc="Maximum Password Length" name="max_pw" id="max_pw" value="<?=$settings->max_pw?>">
                    <span class="input-group-addon input-group-text">characters</span>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>


      </div>


    </div>

    <input type="hidden" name="csrf" value="<?=Token::generate()?>" />

  </form>
