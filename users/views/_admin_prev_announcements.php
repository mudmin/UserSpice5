<?php 
$announce = $db->query("SELECT * FROM us_announcements ORDER BY id DESC")->results();
?>

<h2>Previous Announcements</h2>
<?php foreach($announce as $a){ ?>

          <div class="col-12">
            <div class="alert alert-<?= $a->class ?> alert-dismissible fade show" role="alert">
              <b><?= $a->title ?></b><br><?= $a->message ?>

            </div>
          </div>  
<?php }