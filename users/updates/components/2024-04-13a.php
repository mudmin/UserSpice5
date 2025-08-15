<?php
$countE = 0;

$hooks = [];
$hooks['admin.php?view=user']['form'] = 'hooks/tags_admin_user_form.php';
$hooks['admin.php?view=user']['post'] = 'hooks/tags_admin_user_post.php';
registerHooks($hooks,"userspice_core");

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
