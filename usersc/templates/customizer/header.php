<?php
require_once($abs_us_root.$us_url_root.'users/includes/template/header1_must_include.php');
require_once($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/assets/fonts/glyphicons.php');
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/fonts/glyphicons.css">
<link rel="stylesheet" href="<?=$us_url_root?>users/css/bootstrap.min.css">

<link href="<?=$us_url_root?>users/css/datatables.css" rel="stylesheet">
<link href="<?=$us_url_root?>users/css/menu.css" rel="stylesheet">
<script src="<?= $us_url_root?>users/js/menu.js"></script>
<link rel="stylesheet" href="<?=$us_url_root?>users/fonts/css/fontawesome.min.css">
<link rel="stylesheet" href="<?=$us_url_root?>users/fonts/css/brands.min.css">
<link rel="stylesheet" href="<?=$us_url_root?>users/fonts/css/solid.min.css">
<link rel="stylesheet" href="<?=$us_url_root?>users/fonts/css/v4-shims.min.css">
<?php
require_once $abs_us_root . $us_url_root . "users/js/jquery.php";
?>
<script nonce="<?=htmlspecialchars($userspice_nonce ?? '')?>" src="<?=$us_url_root?>users/js/bootstrap.bundle.min.js"></script>

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

<?php
// Light/dark mode: when a dark preset is paired in the customizer, set
// data-bs-theme BEFORE the body paints so a visitor who chose (or whose OS
// prefers) dark mode never sees a flash of the light theme first.
$customizerPairFile = $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/assets/css/theme_pair.php';
$customizerDarkPaired = false;
if (file_exists($customizerPairFile)) {
  $customizerPair = require $customizerPairFile;
  if (is_array($customizerPair)) {
    // This request is the backend when the dashboard child theme is loaded.
    $customizerSurface = (isset($child_theme) && $child_theme === 'dashboard') ? 'backend' : 'frontend';
    if (!isset($customizerPair['frontend']) && isset($customizerPair['dark'])) {
      // Legacy single-key file applied to the front end only.
      $customizerDarkPaired = ($customizerSurface === 'frontend') && !empty($customizerPair['dark']);
    } else {
      $customizerDarkPaired = !empty($customizerPair[$customizerSurface]['dark']);
    }
  }
}
if ($customizerDarkPaired) :
?>
<script nonce="<?= htmlspecialchars($userspice_nonce ?? '') ?>">
(function(){try{var m=localStorage.getItem('usColorMode')||localStorage.getItem('customizerColorMode');if(m!=='dark'&&m!=='light'){m=(window.matchMedia&&window.matchMedia('(prefers-color-scheme: dark)').matches)?'dark':'light';}document.documentElement.setAttribute('data-bs-theme',m);}catch(e){}})();
</script>
<?php endif; ?>

</head>
<body class="d-flex flex-column min-vh-100">
<?php require_once($abs_us_root.$us_url_root.'users/includes/template/header3_must_include.php'); ?>
