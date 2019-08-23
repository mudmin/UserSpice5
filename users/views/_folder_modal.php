<!-- Modal -->
<div id="folder_modal" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Choose Folders to Monitor</h4>
      </div>
      <div class="modal-body">
        <p>Currently Monitoring: <?php echo oxfordList($filter,['final'=>'and']); ?></p>
        <strong>Remove a folder from monitoring:</strong>
        <table class="table table-striped">
          <tbody>
            <?php $count=0; foreach($filter as $f){
              $f=preg_replace("/\s+/", "", $f);
              if($f != '(root)' && $f != "'users/'" && $f != "'usersc/'"){
                $count++;
                $f = str_replace("'","",$f);
                ?>
                <tr>
                  <td><?=$f?></td>
                  <td>
                    <form class="" action="admin.php?view=pages" method="post">
                      <input type="hidden" name="csrf" value="<?=$csrf;?>" />
                      <input type="hidden" name="folder" value="<?=$f?>">
                      <div class="btn-group pull-right"><input class="btn btn-danger" type="submit" name="removeFolder" value="Remove"></div>
                    </form>
                  </td>
                </tr>
              <?php  }
            }
            if($count==0) { ?>
              <td colspan='2'><strong>No folders</strong> able to be removed</td>
            <?php }
            ?>
          </tbody>
        </table>
        <div class="form-group">
          <form class="inline-form" action="admin.php?view=pages" method="POST" id="newFormForm">
            <strong>Add a folder to monitoring:</strong><br>
            Must end with a <strong>/</strong>, for example:<br>
            <strong>users/cron/</strong><br>
            <input type="hidden" name="csrf" value="<?=$csrf;?>" />
            <input size="50" type="text" name="newFolder" value="" class="form-control"><br />
            <div class="btn-group pull-right"><input class='btn btn-primary' type='submit' name="addFolder" value='Monitor Folder' class='submit' /></div><br />
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">

</script>
