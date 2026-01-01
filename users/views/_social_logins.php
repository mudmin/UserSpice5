<?php
$_SESSION['redirect'] = $_REQUEST['redirect'] ?? "";
$_SESSION['dest'] = $_REQUEST['dest'] ?? "";
$socialsQ = $db->query("SELECT * FROM plg_social_logins WHERE built_in = 0 ORDER BY `provider`;");
$socialsC = $socialsQ->count();
$socials = $socialsQ->results();
$loginOpts = $socialsC + 0;
if ($settings->oauth == 1) {
    $oauthClientsQ = $db->query("SELECT * FROM us_oauth_client_login_options WHERE oauth = 1 ORDER BY client_name ASC");
    $oauthClients = $oauthClientsQ->results();
    $oauthClientCount = $oauthClientsQ->count();
    
    if ($oauthClientCount > 0) {
        $loginOpts += $oauthClientCount;
    }
}
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

//passkeys
if($settings->passkeys == 1 && currentPage() != "join.php"){
    $loginOpts++;
    if(file_exists($abs_us_root . $us_url_root . 'usersc/images/login_icons/passkey.png')){
        $passkeyImage = $us_url_root . 'usersc/images/login_icons/passkey.png';
    }else{
        $passkeyImage = $us_url_root . 'users/images/login_icons/passkey.png';
    }
}

if($loginOpts > 0) {
?>
<link rel="stylesheet" href="<?=$us_url_root?>users/css/social-logins.css">
<div class="<?php echo (isset($settings->social_login_location) && $settings->social_login_location == 0) ? 'mb-3 mt-1' : 'mb-2 mt-2'; ?>">
<?php if (!isset($settings->social_login_location) || $settings->social_login_location != 0): ?>
<div class="separator"><?= strpos(lang('EML_SIGN_IN_WITH'), "{") !== false ? 'Sign in with:' : lang('EML_SIGN_IN_WITH') ?></div>
<?php endif; ?>
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
    if($settings->passkeys > 0 && currentPage() != "join.php"){ ?>
        <a class="userspice-social-logins-item" href="<?=$us_url_root?>users/passkeys.php?login=1">
        <span class="userspice-social-parent">
        <span class="userspice-social-logins-icon">
            <span class="userspice-social-logins-icon-sized">
            <img src="<?=$passkeyImage?>" alt="<?=lang("GEN_PASSKEY");?>">
            </span>
        </span>
        <span class="userspice-social-child"><?= ucwords(lang("GEN_PASSKEY") ?? "Passkey");?></span>
        </span>
    </a>
    <?php
    }
    
if ($settings->oauth == 1 && isset($oauthClients)) {
    foreach ($oauthClients as $oauthClient) {
        // Determine image path following UserSpice convention
        $iconFileName = $oauthClient->client_icon ?: '_default.png';
        if (file_exists($abs_us_root . $us_url_root . "usersc/oauth_client/assets/{$iconFileName}")) {
            $oauthImage = $us_url_root . "usersc/oauth_client/assets/{$iconFileName}";
        } else {
            // Fallback to core default
            $oauthImage = $us_url_root . "users/images/login_icons/oauth-default.png";
        }
        
        $oauthLink = $us_url_root . "users/auth/oauth_request.php?client_id=" . $oauthClient->id;
        $oauthProvider = $oauthClient->login_title ?: $oauthClient->client_name;
        ?>
        <a class="userspice-social-logins-item" href="<?= $oauthLink ?>">
            <span class="userspice-social-parent">
                <span class="userspice-social-logins-icon">
                    <span class="userspice-social-logins-icon-sized">
                        <img src="<?= $oauthImage ?>" alt="<?= hed($oauthProvider) ?>">
                    </span>
                </span>
                <span class="userspice-social-child"><?= hed($oauthProvider) ?></span>
            </span>
        </a>
        <?php
    }
}
$baseDir = $abs_us_root . $us_url_root . 'usersc/';

foreach ($socials as $social) {
    if (!pluginActive($social->plugin, true) || $settings->{$social->enabledsetting} == 0) continue;

    $relativeIncludePath = "plugins/" . $social->plugin . "/" . $social->link;
    $safeIncludePath = sanitizePath($relativeIncludePath, $baseDir);

    if ($safeIncludePath) {
        include $safeIncludePath;
    }

    $relativeImagePath = "plugins/" . $social->plugin . "/" . $social->image;
    $safeImagePath = sanitizePath($relativeImagePath, $baseDir);

    if ($safeImagePath && file_exists($safeImagePath)) {
        $socialImage = $us_url_root . "usersc/plugins/" . basename($social->plugin) . "/" . basename($social->image);
    } else {
        $socialImage = $us_url_root . "users/images/login_icons/" . basename($social->image);
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