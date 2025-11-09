<?php
require_once($abs_us_root.$us_url_root.'users/includes/template/header1_must_include.php');
require_once($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/assets/fonts/glyphicons.php');
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/fonts/glyphicons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link href="<?=$us_url_root?>users/css/datatables.css" rel="stylesheet">
<link href="<?=$us_url_root?>users/css/menu.css" rel="stylesheet">
<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>" src="<?= $us_url_root?>users/js/menu.js"></script>
<link rel="stylesheet" href="<?=$us_url_root?>users/fonts/css/fontawesome.min.css">
<link rel="stylesheet" href="<?=$us_url_root?>users/fonts/css/brands.min.css">
<link rel="stylesheet" href="<?=$us_url_root?>users/fonts/css/solid.min.css">
<link rel="stylesheet" href="<?=$us_url_root?>users/fonts/css/v4-shims.min.css">
<?php
require_once $abs_us_root . $us_url_root . "users/js/jquery.php";
?>
<script nonce="<?=htmlspecialchars($usespice_nonce ?? '')?>" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js" integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php
//if the theme has never been loaded before, it needs to be initialized. We do this so we can distribute it without css files and customizations in place
if (!file_exists($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/assets/css/customizations.php')) {
  require_once $abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/initialize.php';
  initializeCustomizerTheme();
}


//set a variable above init.php of $child_theme = filename to load a child theme instead of your core template
$child_loaded = false;
if(file_exists($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/assets/css/revision.php')){
  require_once($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/assets/css/revision.php');
}

//if the child_theme variable is set, we need to make sure that it is defined in the revision.php file and that the css file exists
if(isset($child_theme) && $child_theme != ''){
  //
  if(isset($child_themes) && is_array($child_themes) && isset($child_themes[$child_theme])) {
    $timestampedFile = $child_themes[$child_theme];
    if(file_exists($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/assets/child_themes/'.$timestampedFile)){
      echo '<link href="'.$us_url_root.'usersc/templates/'.$settings->template.'/assets/child_themes/'.$timestampedFile.'" rel="stylesheet">';
      $child_loaded = true;
    }
  }

} 
  // Fall back to standard theme
  if(!$child_loaded && file_exists($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/assets/css/revision.php')){
      if(isset($css_revision) && $css_revision != '' && file_exists($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/assets/css/'.$css_revision)){ 
      echo '<link href="'.$us_url_root.'usersc/templates/'.$settings->template.'/assets/css/'.$css_revision.'" rel="stylesheet">';
    }
  }
  
//if this file exists, it overrides everything before it
if(file_exists($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'.css')){?>
  <link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>.css" rel="stylesheet">
<?php } ?>

</head>
<body class="d-flex flex-column min-vh-100">
<?php require_once($abs_us_root.$us_url_root.'users/includes/template/header3_must_include.php'); ?>
