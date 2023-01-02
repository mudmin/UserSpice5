<?php
$dirs = glob($abs_us_root . $us_url_root . 'usersc/plugins/*', GLOB_ONLYDIR);
$plugins = [];
foreach($dirs as $d){
  $string = str_replace($abs_us_root . $us_url_root . 'usersc/plugins/','',$d);
  // dnd(pluginActive($string,true));
  if(!pluginActive($string,true)){ continue; }
  if(file_exists($abs_us_root . $us_url_root . 'usersc/plugins/' . $string . '/info.xml')){
    $xml = simplexml_load_file($abs_us_root . $us_url_root . 'usersc/plugins/' . $string . '/info.xml');
    $buttonTitle = $xml->button != '' ? $xml->button : ucfirst($string);
    $icon = $xml->fa_icon != '' ? $xml->fa_icon : "fa fa-plug";
  }else{
    $buttonTitle = ucfirst($string);
    $icon = "fa fa-plug";
  }
  ?>
  <li class=''>
    <a class='' href='<?=$us_url_root?>users/admin.php?view=plugins_config&plugin=<?=$string?>' ><i class='<?=$icon?>'></i>
      <span class='labelText'><?=$buttonTitle?></span>
    </a>
  </li>
  <?php
}
