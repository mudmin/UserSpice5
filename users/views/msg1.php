<div id="settings" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><?=lang("MSG_SETTINGS");?></h4>
</div>
<div class="modal-body">
<form class="form" id="messageSettings" name='messageSettings' action='messages.php' method='post'>
<p><strong><?=lang("GEN_ENABLE");?>/<?=lang("GEN_DISABLE");?> <?=lang("GEN_FUNCTIONS");?></strong></p>
<center>
  <div class="checkbox <?php if($settings->msg_notification==0) {?> disabled<?php } ?>">
    <label>
      <input type="checkbox" <?php if($settings->msg_notification==0) {?> disabled<?php } ?> data-toggle="toggle" data-onstyle="info" data-offstyle="danger" name="msg_notification" id="msg_notification" <?php if($user->data()->msg_notification==1) {?>checked <?php } ?> value="Yes">
      <?=lang("MSG_NOTIF");?>
    </label>
  </div>
</div>
<div class="modal-footer">
  <div class="btn-group">
    <input type="hidden" name="csrf" value="<?=$csrf?>" />
    <input class='btn btn-primary' type='submit' name="messageSettings" value='<?=lang("GEN_UPDATE");?>' class='submit' /></div>
  </form>
  <div class="btn-group"><button type="button" class="btn btn-default" data-dismiss="modal"><?=lang("GEN_CLOSE");?></button></div>
</div>
</div>

</div>
</div>
