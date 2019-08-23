<?php
if(!isset($opts['submit']) && !isset($opts['nosubmit'])){ ?>
  <input type="submit" name="submit" value="submit" class="btn btn-default">
<?php   }elseif(isset($opts['nosubmit']) && $opts['nosubmit']==1) {
  //do nothing
}else{
   ?>
  <input type="submit" name="
  <?php if($opts['submit'] != ''){echo $opts['submit'];}else{echo "submit";}?>
  " value="<?php if($opts['value'] != ''){echo $opts['value'];}else{echo "Submit";}?>" class="
  <?php if($opts['class'] != ''){echo $opts['class'];}else{echo "btn btn-primary";}?>">
<?php }//end submit ?>
