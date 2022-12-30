<?php
if(count(get_included_files()) ==1) die(); //Direct Access Not Permitted
  // UserSpice Announcements
  $rc = @fsockopen("rss.userspice.com",443,$errCode,$errStr,1);
  if (is_resource($rc))  {
    $filename= 'https://rss.userspice.com/rss.xml';
    $file_headers = @get_headers($filename);
    if(($file_headers[0] != 'HTTP/1.1 200 OK') && ($file_headers[1] != 'HTTP/1.1 200 OK')){
      //logger($user->data()->id,"Errors","UserSpice Announcements feed not found. Please tell UserSpice!");
    } else {
      $limit = 0;
      $dis = $db->query("SELECT * FROM us_announcements")->results();
      $dismissed = [];
      foreach($dis as $d){
        $dismissed[] = $d->dismissed;
      }
      $xmlDoc = new DOMDocument();
      $xmlDoc->load('https://rss.userspice.com/rss.xml');
      $x=$xmlDoc->getElementsByTagName('item');
      for ($i=0; $i<=2; $i++) {
        if($limit == 1){
          continue;
        }

        $dis=$x->item($i)->getElementsByTagName('dis')
        ->item(0)->childNodes->item(0)->nodeValue;

        if(!in_array($dis,$dismissed) && $dis != 0){
          $ignore=$x->item($i)->getElementsByTagName('ignore')
          ->item(0)->childNodes->item(0)->nodeValue;
          if(version_compare($ignore, $user_spice_ver,'<=')){
          continue;
        }else{
          $limit = 1;
        }
          $title=$x->item($i)->getElementsByTagName('title')
          ->item(0)->childNodes->item(0)->nodeValue;
          $class=$x->item($i)->getElementsByTagName('class')
          ->item(0)->childNodes->item(0)->nodeValue;
          $link=$x->item($i)->getElementsByTagName('link')
          ->item(0)->childNodes->item(0)->nodeValue;
          $message=$x->item($i)->getElementsByTagName('message')
          ->item(0)->childNodes->item(0)->nodeValue;
        }
      }
    }
  }
// dump($ignore);
// dump($user_spice_ver);
if(isset($message) && $message != ''){  ?>
<div class="sufee-alert alert with-close alert-<?=$class?> alert-dismissible fade show">
  <span class="badge badge-pill badge-<?=$class?>"><?php echo htmlspecialchars($title);?></span> <a href="<?php echo htmlspecialchars($link);?>"><?php echo htmlspecialchars($message);?></a>
  <button type="button" class="close dismiss-announcement" data-dismiss="alert" data-bs-dismiss="alert"
  data-dis="<?=$dis?>"
  data-ignore="<?=$ignore?>"
  data-title="<?=$title?>"
  data-class="<?=$class?>"
  data-link="<?=$link?>"
  data-message="<?=$message?>"
  aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<?php } ?>

<script type="text/javascript">
$(document).ready(function() {
  //dismiss notifications
  $(".dismiss-announcement").click(function(event) {
    event.preventDefault();
    console.log("clicked");

    var formData = {
      'dismissed' 					: $(this).attr("data-dis"),
      'link' 					      : $(this).attr("data-link"),
      'title' 					    : $(this).attr("data-title"),
      'class' 					    : $(this).attr("data-class"),
      'message' 				  	: $(this).attr("data-message"),
      'ignore' 					    : $(this).attr("data-ignore"),
      'token'               : "<?=Token::generate()?>",
    };
    //
    $.ajax({
      type 		: 'POST',
      url 		: 'parsers/dismiss_announcements.php',
      data 		: formData,
      dataType 	: 'json',
      encode 		: true
    })
  });


}); //End DocReady
</script>
