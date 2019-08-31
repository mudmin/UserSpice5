<?php require_once($abs_us_root.$us_url_root.'users/includes/template/header1_must_include.php'); ?>

<!-- Bootstrap 3 Glyphicons for Compatibility Reasons -->
<?php require_once($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/assets/fonts/glyphicons.php'); ?>


<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/bootstrap.min.css">

<!-- Table Sorting and Such -->
<link href="<?=$us_url_root?>users/css/datatables.css" rel="stylesheet">

<!-- Custom Fonts/Animation/Styling-->
<link rel="stylesheet" href="<?=$us_url_root?>users/fonts/css/font-awesome.min.css">

<!-- jQuery Fallback -->
<script type="text/javascript">
if (typeof jQuery == 'undefined') {
  document.write(unescape("%3Cscript src='<?=$us_url_root?>users/js/jquery.js' type='text/javascript'%3E%3C/script%3E"));
}
</script>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<style media="screen">
body {
font-family: 'Roboto', sans-serif !important;
}
</style>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>) -->
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/hamburgers.min.css" rel="stylesheet">
<?php
//optional
//require_once $abs_us_root.$us_url_root.'usersc/includes/bootstrap_corrections.php'; ?>

</head>
<?php require_once($abs_us_root.$us_url_root.'users/includes/template/header3_must_include.php'); ?>
