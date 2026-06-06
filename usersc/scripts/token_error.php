<?php
//this is a user-facing page
// Token errors are generally caused by 1 of 2 things.
// 1. Someone trying to perform a man-in-the-middle attack on a form on the site.
// 2. Something accidentally causing the page to partially reload
//
// You can decide what you want for that error message here.
if(!isset($lang) || !in_array("MAINT_TOK",$lang)){
  $lang = [
    		"MAINT_TOK"			=> "There was an error with your form. Please go back and try again. Please note that submitting the form by refreshing the page will cause an error. If this continues to happen, please contact the administrator.",
        "GEN_BACK"				=> "Back",
  ];
}
 ?>
<style>
body {
    background-color: white;
}
</style>

<br><br>

<p align="center"><?=lang("MAINT_TOK");?></p>
<p align="center"><a href="#" id="tokenBackLink"><?=lang("GEN_BACK");?></a></p>

<?php
if (!isset($GLOBALS['userspice_nonce'])) {
    $GLOBALS['userspice_nonce'] = base64_encode(random_bytes(16));
}
?>
<script nonce="<?= htmlspecialchars($GLOBALS['userspice_nonce'] ?? '') ?>">
  document.getElementById('tokenBackLink').addEventListener('click', function (e) {
    e.preventDefault();
    history.back();
  });
</script>

<?php die(); ?>
