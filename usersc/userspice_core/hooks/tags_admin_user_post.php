<?php if(count(get_included_files()) ==1) die(); //Direct Access Not Permitted
global $userdetails;
if(!empty($_POST['addTag'])){
  $add = Input::get('addTag');

  foreach($add as $a){
    $tagQ = $db->query("SELECT * FROM plg_tags WHERE id = ?",[$a]);
    $tagC = $tagQ->count();
    if($tagC < 1){  continue;  }
    $tag = $tagQ->first();
    $db->query("DELETE FROM plg_tags_matches WHERE user_id = ? AND tag_id = ?",[$userdetails->id,$a]);
    $db->insert("plg_tags_matches",[
      'tag_id'=>$a,
      'tag_name'=>$tag->tag,
      'user_id'=>$userdetails->id,
    ]);
  }
}

if(!empty($_POST['removeTag'])){
  $remove = Input::get('removeTag');
  foreach($remove as $r){
    $db->query("DELETE FROM plg_tags_matches WHERE id = ?",[$r]);
  }
}
?>
