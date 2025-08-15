<?php
if(file_exists($abs_us_root . $us_url_root . "usersc/modules/widgets.php")){
  require_once $abs_us_root . $us_url_root . "usersc/modules/widgets.php";
}else{
  require_once $abs_us_root . $us_url_root . "users/modules/widgets.php";
}
?>

<style>
/* A slower, red pulse effect */
.settingsWidgetBreathe {
  /* Changed animation duration from 2.5s to 4s */
  animation: gentlePulse 4s ease-in-out infinite;
  border-radius: 15px;
}

@keyframes gentlePulse {
  0% {
    /* Changed color to a transparent red */
    box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
  }
  50% {
    /* Changed color to a visible red (Bootstrap's 'danger' color) */
    box-shadow: 0 0 12px 3px rgba(220, 53, 69, 0.6);
  }
  100% {
    /* Changed color to a transparent red */
    box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
  }
}
</style>
