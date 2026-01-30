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
  <link rel="stylesheet" href="<?=$us_url_root?>users/css/dashboard/normalize.css">
  <link rel="stylesheet" href="<?=$us_url_root?>users/css/dashboard/style.css?v2">
  <link rel="stylesheet" href="<?=$us_url_root?>users/css/dashboard/minimap.css">

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
  <script nonce="<?=htmlspecialchars($userspice_nonce ?? '')?>" src="<?=$us_url_root?>users/js/sortable.min.js"></script>


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
if (!function_exists('usView')) {
    function usView($file)
    {
        global $abs_us_root, $us_url_root;

        $cleanRoot = rtrim($abs_us_root, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . trim($us_url_root, DIRECTORY_SEPARATOR);
        $cleanRoot = rtrim($cleanRoot, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        $dashboard = $cleanRoot . 'users' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . '_admin_dashboard.php';

        $rel = trim((string)$file);
        $rel = str_replace('\\', '/', $rel);

        if ($rel === '' ||
            str_contains($rel, "\0") ||
            str_starts_with($rel, '/') ||
            str_contains($rel, '://') ||
            str_contains($rel, ':') ||
            preg_match('#(^|/)\.\.(?:/|$)#', $rel) ||
            preg_match('#(^|/)\.(?:/|$)#', $rel)
        ) {
            return $dashboard;
        }

        if (!str_ends_with($rel, '.php')) {
            $rel .= '.php';
        }

        if (!preg_match('#^[A-Za-z0-9/_-]+\.php$#', $rel)) {
            return $dashboard;
        }

        if (!checkAccess('page', $rel)) {
            return $dashboard;
        }

        $bases = [
            $cleanRoot . 'usersc' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'admin',
            $cleanRoot . 'users' . DIRECTORY_SEPARATOR . 'views',
        ];

        foreach ($bases as $base) {
            $baseReal = realpath($base);
            if ($baseReal === false) continue;

            $candidate = $baseReal . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $rel);
            $real = realpath($candidate);

            if ($real !== false && is_file($real)) {
                $prefix = rtrim($baseReal, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
                if (str_starts_with($real, $prefix)) {
                    return $real;
                }
            }
        }

        return $dashboard;
    }
}



  ?>
