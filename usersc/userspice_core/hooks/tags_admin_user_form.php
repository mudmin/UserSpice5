<?php if(count(get_included_files()) ==1) die(); //Direct Access Not Permitted
global $userdetails;
$tagsQ = $db->query("SELECT * FROM plg_tags ORDER BY tag");
$tagsC = $tagsQ->count();
if($tagsC > 0){
  $tags = $tagsQ->results();
  $mytags = $db->query("SELECT * FROM plg_tags_matches WHERE user_id = ?",[$userdetails->id])->results();
  $usedtags = [];
?>
<div class="row">
<div class="col-12 col-sm-6">
  <div class="panel-heading"><strong>Current Tags</strong></div>
  <div class="panel-body">
  <?php foreach($mytags as $t){
    $usedtags[]=$t->tag_id;
    ?>
    <label class="normal">
      <input type="checkbox" name="removeTag[]" value="<?=$t->id?>"> <?=$t->tag_name;?>
    </label><br>
  <?php } ?>
</div>
</div>
<div class="col-12 col-sm-6">
  <div class="panel-heading"><strong>Add Tags</strong></div>
  <div class="panel-body">
  <?php foreach($tags as $t){
    if(in_array($t->id,$usedtags)){  continue;  }
    ?>
    <label class="normal">
      <input type="checkbox" name="addTag[]" value="<?=$t->id?>"> <?=$t->tag;?>
    </label><br>
  <?php } ?>
</div>
</div>
</div>
<br>

<?php }
 ?>
