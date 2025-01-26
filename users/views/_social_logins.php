<?php
$_SESSION['redirect'] = $_REQUEST['redirect'] ?? "";
$_SESSION['dest'] = $_REQUEST['dest'] ?? "";
$socialsQ = $db->query("SELECT * FROM plg_social_logins WHERE built_in = 0 ORDER BY `provider`;");
$socialsC = $socialsQ->count();
$socials = $socialsQ->results();
$loginOpts = $socialsC + 0;
foreach($socials as $social) {
    if (!pluginActive($social->plugin, true) || $settings->{$social->enabledsetting} == 0) $loginOpts--;
}

if($settings->email_login > 0 && currentPage() != "join.php"){
    $loginOpts++;
    if(file_exists($abs_us_root . $us_url_root . 'usersc/images/login_icons/passwordless.png')){
        $emailImage = $us_url_root . 'usersc/images/login_icons/passwordlesss.png';
    }else{
        $emailImage = $us_url_root . 'users/images/login_icons/passwordless.png';
    }
}

if($loginOpts > 0) {
?>
<link rel="stylesheet" href="<?=$us_url_root?>users/css/social-logins.css">
<div class="mb-2 mt-2">
<div class="separator"><?= strpos(lang('EML_SIGN_IN_WITH'), "{") !== false ? 'Sign in with:' : lang('EML_SIGN_IN_WITH') ?></div>
<div class="userspice-social-logins-list">
    <?php
    if($settings->email_login > 0 && currentPage() != "join.php"){ ?>
        <a class="userspice-social-logins-item" href="<?=$us_url_root?>users/passwordless.php">
        <span class="userspice-social-parent">
        <span class="userspice-social-logins-icon">
            <span class="userspice-social-logins-icon-sized">
            <img src="<?=$emailImage?>" alt="<?=lang("GEN_EMAIL");?>">
            </span>
        </span>
        <span class="userspice-social-child"><?= ucwords(lang("GEN_EMAIL") ?? "Email");?></span>
        </span>
    </a>
    <?php }
    foreach($socials as $social) {
        if (!pluginActive($social->plugin, true) || $settings->{$social->enabledsetting} == 0) continue;
        include $abs_us_root . $us_url_root . "usersc/plugins/{$social->plugin}/{$social->link}";
        if(file_exists($abs_us_root . $us_url_root . "usersc/plugins/{$social->plugin}/{$social->image}")){
            $socialImage = $us_url_root . "usersc/plugins/{$social->plugin}/{$social->image}";
        }else{
            $socialImage = $us_url_root . "users/images/login_icons/{$social->image}";
        }
    ?>
        <a class="userspice-social-logins-item" href="<?=$link?>">
        <span class="userspice-social-parent">
        <span class="userspice-social-logins-icon">
            <span class="userspice-social-logins-icon-sized"><img src="<?=$socialImage?>" alt="<?=$social->provider?>"></span>
        </span>
        <span class="userspice-social-child"><?= strpos(lang("SOCIAL_PROVIDER_" . strtoupper($social->provider)), "{") !== false ? $social->provider : lang("SOCIAL_PROVIDER_" . strtoupper($social->provider)) ?></span>
        </span>
    </a>
    <?php
    }
    ?>
</div>
<?php } ?>