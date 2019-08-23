<div id="compose" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title"><?=lang("MSG_NEW");?></h4>
</div>
<div class="modal-body">
  <form name="create_message" action="messages.php" method="post">

    <label><?=lang("MSG_SELECT")?>:</label>
    <select name="user_id" id="combobox" class="form-control combobox" required>
      <option readonly></option>
      <?php $userData = fetchMessageUsers(); //Fetch information for all users
      foreach($userData as $v1) {?>
        <option value="<?=$v1->id;?>"><?=$v1->fname;?> <?=$v1->lname;?></option>
      <?php } ?>
    </select><br />
    <label><?=lang("MSG_SUB")?>:</label>
    <input required size='100' class='form-control' type='text' name='msg_subject' value='' required/>
    <br /><label><?=lang("MSG_BODY");?>:</label>
    <textarea rows="20" cols="80"  id="mytextarea" name="msg_body"></textarea>
    <input type="hidden" name="csrf" value="<?=$csrf?>" />
  </p>
  <p>
    <br />
  </div>
  <div class="modal-footer">
    <div class="btn-group">
      <input class='btn btn-primary' type='submit' name="send_message" value='<?=lang("MSG_SEND");?>' class='submit' /></div>
    </form>
    <div class="btn-group"><button type="button" class="btn btn-default" data-dismiss="modal"><?=lang("GEN_CLOSE");?></button></div>
  </div>
</div>
</div>
</div>
