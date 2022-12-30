<!-- Modal -->
<div id="folder_modal" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Choose Folders to Monitor</h4>
        <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p class="text-dark"><strong>Remove a folder from monitoring:</strong></p>
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
                    <form class="" action="" method="post">
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
          <form class="inline-form" action="" method="POST" id="newFormForm">
            <strong>Add a folder to monitoring:</strong>

            <input type="hidden" name="csrf" value="<?=$csrf;?>" />
            <input size="50" type="text" name="newFolder" value="" class="form-control">
            <small  class="form-text text-muted">Must end with a <strong>/</strong>, for example: <strong>users/cron/</strong></small>
            <div class="btn-group pull-right"><input class='btn btn-primary' type='submit' name="addFolder" value='Monitor Folder' class='submit' /></div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal" data-bs-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">

</script>
