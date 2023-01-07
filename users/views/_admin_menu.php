<?php
$page=currentFile();
$titleQ = $db->query('SELECT title FROM pages WHERE page = ?', array($page));
if ($titleQ->count() > 0) {
    $pageTitle = $titleQ->first()->title;
}
else $pageTitle = '';
?>
<title><?= (($pageTitle != '') ? $pageTitle : ''); ?> <?=$settings->site_name?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="css/dashboard/normalize.css">
  <link rel="stylesheet" href="css/dashboard/style.css">
  <link rel="stylesheet" href="css/dashboard/minimap.css">

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
  <script src="<?=$us_url_root?>users/js/sortable.min.js"></script>


<?php if(file_exists($abs_us_root.$us_url_root."usersc/includes/dashboard.css")){ ?>
  <link rel="stylesheet" href="<?=$us_url_root?>usersc/includes/dashboard.css">
<?php } ?>
</head>
<body>
<?php

  $dirs = glob($abs_us_root.$us_url_root.'usersc/plugins/*' , GLOB_ONLYDIR);
  $plugins = [];
  foreach($dirs as $d){
    $plugins[] = str_replace($abs_us_root.$us_url_root.'usersc/plugins/', "", $d);
    $thisPlugin = end($plugins);
    // if(!array_key_exists($thisPlugin,$usplugins)){
    //   $usplugins[$thisPlugin] = 2;
    //   write_php_ini($usplugins, $abs_us_root.$us_url_root.'usersc/plugins/plugins.ini.php');
    //   include $abs_us_root.$us_url_root.'usersc/plugins/'.$thisPlugin.'/install.php';
    // }
  }


?>

<?php
if(!function_exists('usView')){
  function usView($file)
{
    global $abs_us_root;
    global $us_url_root;
    if (checkAccess('page', $file)) {
        if (file_exists($abs_us_root.$us_url_root.'usersc/includes/admin/'.$file)) {
            $path = $abs_us_root.$us_url_root.'usersc/includes/admin/'.$file;
        } elseif (file_exists($abs_us_root.$us_url_root.'users/views/'.$file)) {
            $path = $abs_us_root.$us_url_root.'users/views/'.$file;
        } else {
            $path = $abs_us_root.$us_url_root.'users/views/_admin_dashboard.php';
        }

        return $path;
    } else {
        $path = $abs_us_root.$us_url_root.'users/views/_admin_dashboard.php';

        return $path;
    }
}
}


  ?>
