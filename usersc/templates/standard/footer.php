<?php
require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/container_close.php';
require_once $abs_us_root . $us_url_root . 'users/includes/page_footer.php';

?>
</body>
<script type="text/javascript">
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
<script>
var $hamburger = $(".hamburger");
$hamburger.on("click", function(e) {
  $hamburger.toggleClass("is-active");
});
</script>

<footer id="footer" style="background-color: transparent;">
<p align="center">&copy; <?php echo date("Y"); ?> <?=$settings->copyright; ?></p>
</footer>
<?php require_once($abs_us_root.$us_url_root.'users/includes/html_footer.php');?>
