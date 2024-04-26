<?php
if(count(get_included_files()) ==1) die(); //Direct Access Not Permitted
  // UserSpice Announcements
  $rc = @fsockopen("rss.userspice.com",443,$errCode,$errStr,1);
  
  if (checkInternet() && is_resource($rc))  {
    $filename= 'https://rss.userspice.com/rss.xml';
    $file_headers = @get_headers($filename);
   
    if(!isset($file_headers[1]) || (($file_headers[0] != 'HTTP/1.1 200 OK') && ($file_headers[1] != 'HTTP/1.1 200 OK'))){
      //logger($user->data()->id,"Errors","UserSpice Announcements feed not found. Please tell UserSpice!");
    } else {
      $limit = 0;
      $dis = $db->query("SELECT * FROM us_announcements WHERE update_announcement = 0")->results();
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
<div class="sufee-alert alert alert-<?= $class ?> alert-dismissible fade show">
<span class="badge badge-pill bg-<?=$class?> p-2" style="color: black; "><?php echo htmlspecialchars($title); ?></span> <a href="<?php echo htmlspecialchars($link); ?>"><?php echo htmlspecialchars($message); ?></a>
  <button type="button" class="btn-close dismiss-announcement" data-bs-dismiss="alert" aria-label="Close"
    data-dis="<?= $dis ?>"
    data-ignore="<?= $ignore ?>"
    data-title="<?= htmlspecialchars($title) ?>"
    data-class="<?= $class ?>"
    data-link="<?= htmlspecialchars($link) ?>"
    data-message="<?= htmlspecialchars($message) ?>"
    data-update="false"
    ></button>
</div>

<?php } 

if(in_array($user->data()->id,$master_account)){ 
    $announce = $db->query("SELECT * FROM us_announcements WHERE dismissed_by = 0 AND update_announcement = 1")->results();
    
    if(count($announce) > 0) { ?>
      <div class="row">
        <?php foreach($announce as $a){ ?>
          <div class="col-12">
            <div class="alert alert-<?= $a->class ?> alert-dismissible fade show" role="alert">
              <b><?= $a->title ?></b><br><?= $a->message ?>
              <button type="button" class="btn-close dismiss-announcement" data-bs-dismiss="alert" aria-label="Close" data-dis="<?= $a->dismissed ?>" data-title="<?= $a->title ?>" data-class="<?= $a->class ?>" data-link="<?= $a->link ?>" data-message="<?= $a->message ?>" data-update="<?=$a->id?>"></button>
            </div>
          </div>  
        <?php } ?>
        </div>
    <?php }
 }
 ?>

<script type="text/javascript">
$(document).ready(function() {
  //dismiss notifications
  $(".dismiss-announcement").click(function(event) {
    event.preventDefault();
 

    var formData = {
      'dismissed' 					: $(this).attr("data-dis"),
      'link' 					      : $(this).attr("data-link"),
      'title' 					    : $(this).attr("data-title"),
      'class' 					    : $(this).attr("data-class"),
      'message' 				  	: $(this).attr("data-message"),
      'update'              : $(this).attr("data-update"),
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
    }).done(function(response) {
      // This function is called when the Ajax request completes successfully
      console.log("Announcement dismissed successfully", response);

      // Close the announcement here if the response indicates success
      // For example, you might check `response.success`
      // if (response.success) {
      // Adjust this to target the specific announcement you want to close
      // This might need customization based on your HTML structure
      button.closest('.sufee-alert').alert('close');
      // }
    }).fail(function(jqXHR, textStatus, errorThrown) {
      // Handle failure: you might want to log the error or inform the user
      console.error("Error dismissing announcement", textStatus, errorThrown);
    });
  });
}); //End DocReady
</script>