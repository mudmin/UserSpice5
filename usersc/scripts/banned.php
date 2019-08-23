<?php
//this is a user-facing page
// This is where a user goes who has been banned.
// It could be that you blocked them in the admin panel.
// Or their ip address could be on the blacklist.
// Note that the whitelist overrides the blacklist.
// Either way, we feel that it is best to not tell someone
// exactly why they were banned, so they don't try to defeat it
// with something like a VPN.
?>
<h1><?=lang("MAINT_BAN");?></h1>
<?php die(); ?>
