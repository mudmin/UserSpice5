<div id="archived" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?=lang("MSG_ARC");?></h4>
  </div>
  <div class="modal-body" id="archivediv">
    <?php $messagesQ2 = $db->query("SELECT * FROM message_threads WHERE (msg_to = ? AND archive_to = ? AND hidden_to = ?) OR (msg_from = ? AND archive_from = ? AND hidden_from = ?) ORDER BY last_update DESC",array($user->data()->id,1,0,$user->data()->id,1,0));
    $messages2 = $messagesQ2->results();
    $messagesCount2 = $messagesQ2->count(); ?>
    <?php if($messagesCount2 > 0) {?><label><input type="checkbox" class="checkAllArchive" />
      <?=lang("GEN_CHECK");?></label><?php } ?>
      <form name="uthreads" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <center><table class="table table-striped">
          <thead>
            <tr>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php if($messagesCount2 > 0) {?>
                <?php foreach($messages2 as $m2){ ?>
                  <?php
                  if($m2->msg_from == $user->data()->id) { $findId = $m2->msg_to; } else { $findId = $m2->msg_from; }
                  $findUser = $db->query("SELECT picture,email FROM users WHERE id = $findId");
                  if($findUser->count()==1) $foundUser = $findUser->first()->email;
                  if($findUser->count()==0) $foundUser = "null@null.com";
                  $grav = get_gravatar(strtolower(trim($foundUser))); ?>
                  <?php $lastmessage = strtotime($m2->last_update);
                  $difference = ceil((time() - $lastmessage) / (60 * 60 * 24));
                  // if($difference==0) { $last_update = "Today, "; $last_update .= date("g:i A",$lastmessage); }
                  if($difference >= 0 && $difference < 7) {
                    $today = date("j");
                    $last_message = date("j",$lastmessage);
                    if($today==$last_message) { $last_update = "Today, "; $last_update .= date("g:i A",$lastmessage); }
                    else {
                      $last_update = date("l g:i A",$lastmessage); } }
                      elseif($difference >= 7) { $last_update = date("M j, Y g:i A",$lastmessage); }
                      $replies = $db->query("SELECT COUNT(*) AS count FROM messages WHERE msg_thread = ? GROUP BY msg_thread",array($m2->id));
                      $repliescount = $replies->count();
                      ?>
                      <td style="width:100px">
                        <center>
                          <span class="chat-img pull-left" style="padding-right:5px">
                            <a class="nounderline" href="message.php?id=<?=$m2->id?>">
                              <img src="<?=$grav ?>" width="75" class="img-thumbnail">
                            </a>
                          </span>
                        </center>
                      </td>
                      <td class="pull-left">
                        <h4>
                          <input type="checkbox" class="checkarchive" name="checkbox[<?=$m2->id?>]" value="<?=$m2->id?>"/>
                          <a class="nounderline" href="message.php?id=<?=$m2->id?>">
                            <?=$m2->msg_subject?> - with <?php if($m2->msg_from == $user->data()->id) { echouser($m2->msg_to); } else { echouser($m2->msg_from); } ?>
                          </a>
                        </h4>
                        <a class="nounderline" href="message.php?id=<?=$m2->id?>">
                          <?=lang("GEN_UPDATED");?> <?=$last_update?> <?=lang("GEN_BY");?> <?php echouser($m2->last_update_by);?>
                        </a>
                      </tr>
                    <?php } } else {?>
                      <td colspan="2"><center><h3><?=lang("MSG_NO_ARC");?></h3></center></td></tr>
                    <?php } ?>
                  </tbody>
                </table>
              </center>
                <br />
              </div>

              <!-- <div class="modal-footer">
                <div class="btn-group">
                  <input type="hidden" name="csrf" value="<?php //echo $csrf?>" />
                  <input class='btn btn-primary' type='submit' name="delete" value='<?php //echo lang("MSG_DEL_THR");?>' class='submit' /></div>
                  <div class="btn-group"><input class='btn btn-primary' type='submit' name="unarchive" value='<?php //echo lang("MSG_UN_THR");?>' class='submit' /></div>
                </form>
                <div class="btn-group"><button type="button" class="btn btn-default" data-dismiss="modal"><?php //echo $lang("GEN_CLOSE");?></button></div>
              </div>
            </div>
          </div>
        </div> -->
