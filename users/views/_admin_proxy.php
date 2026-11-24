<?php
/*
 * Proxy & CDN settings (admin.php?view=proxy)
 *
 * Owns everything about how UserSpice learns the real client address and
 * scheme when it sits behind Cloudflare, a load balancer, or a same-server
 * proxy/tunnel. Resolution itself lives in users/classes/ClientIP.php.
 */
$self = $us_url_root . 'users/admin.php?view=proxy';

$ip_config = ClientIP::config();
$file_mode = ($ip_config['source'] === 'file');
$proxy_config_file = ClientIP::configFile();
$file_writable = $file_mode ? is_writable($proxy_config_file) : is_writable(dirname($proxy_config_file));
$proxy_enabled = $ip_config['enabled'];
$presets_column = isset($settings) && property_exists($settings, 'proxy_presets');
$uid = $user->data()->id;

/** Raw string from POST (Input::get() HTML-escapes, which would corrupt exact matches). */
$postString = function (string $key): string {
    $value = $_POST[$key] ?? '';
    return is_string($value) ? trim($value) : '';
};

/**
 * Save proxy mode and presets to whichever source is authoritative.
 */
$saveMode = function (bool $enabled, array $presets) use ($db, $file_mode, $file_writable, $ip_config, $presets_column): bool {
    if ($file_mode) {
        return $file_writable && ClientIP::writeConfigFile($ip_config['trusted_proxies'], $ip_config['trusted_headers'], $enabled, $presets);
    }
    $fields = ['behind_reverse_proxy' => $enabled ? 1 : 0];
    if ($presets_column) {
        $fields['proxy_presets'] = implode(',', $presets);
    } elseif (!empty($presets)) {
        return false;
    }
    $db->update('settings', 1, $fields);
    return !$db->error();
};

/** True when $ip is banned and not whitelisted (mirrors ipCheckBan()). */
$isBanned = function (string $ip) use ($db): bool {
    if ($db->query('SELECT id FROM us_ip_blacklist WHERE ip = ?', [$ip])->count() === 0) {
        return false;
    }
    return $db->query('SELECT id FROM us_ip_whitelist WHERE ip = ?', [$ip])->count() === 0;
};

/*
 * Lockout guard. Every change on this page can alter the address the admin
 * resolves to (a preset, a new proxy, turning proxy mode on or off, removing
 * a proxy). Snapshot all proxy state first; after a change, re-resolve this
 * request under the new settings and roll back if it lands on a banned
 * address, since ipCheckBan() would then lock the admin out of every page.
 */
$snapshot = function () use ($db, $proxy_config_file, $presets_column): array {
    return [
        'file' => is_file($proxy_config_file) ? file_get_contents($proxy_config_file) : null,
        'settings' => (array)$db->query('SELECT behind_reverse_proxy' . ($presets_column ? ', proxy_presets' : '') . ' FROM settings WHERE id = 1')->first(),
        'rows' => $db->query('SELECT * FROM us_rate_limit_proxy_settings')->results(true),
    ];
};
$restore = function (array $snap) use ($db, $proxy_config_file): void {
    if ($snap['file'] === null) {
        if (is_file($proxy_config_file)) {
            @unlink($proxy_config_file);
        }
    } else {
        ClientIP::writeAtomic($proxy_config_file, $snap['file']);
    }
    if (!empty($snap['settings'])) {
        $db->update('settings', 1, $snap['settings']);
    }
    $db->query('DELETE FROM us_rate_limit_proxy_settings');
    foreach ($snap['rows'] as $row) {
        $db->insert('us_rate_limit_proxy_settings', $row);
    }
};
$commit = function (array $snap, string $success, string $log) use ($db, $isBanned, $restore, $uid): void {
    global $settings;
    $settings = $db->query('SELECT * FROM settings WHERE id = 1')->first();
    ClientIP::reset();
    $resolved = ClientIP::get();
    if ($isBanned($resolved)) {
        $restore($snap);
        $settings = $db->query('SELECT * FROM settings WHERE id = 1')->first();
        ClientIP::reset();
        usError("Not saved: with that change your address would be " . safeReturn($resolved) . ", which is on the IP blacklist, and you'd be locked out. Whitelist it in the IP Manager first.");
        logger($uid, 'Proxy', "Rolled back a proxy change that would have locked this admin out ($resolved is blacklisted)");
        return;
    }
    usSuccess($success);
    logger($uid, 'Proxy', $log);
};

if (!empty($_POST)) {
    if (!Token::check($_POST['csrf'] ?? '')) {
        usError("Token failed");
        Redirect::to($self);
    }
    $snap = $snapshot();
    $notWritable = "usersc/includes/trusted_proxies.php is not writable.";

    // Mode + presets form
    if (isset($_POST['save_mode'])) {
        $enabled = !empty($_POST['proxy_enabled']);
        $presets = [];
        foreach ((array)($_POST['presets'] ?? []) as $preset) {
            if (is_string($preset) && isset(ClientIP::PRESETS[$preset])) {
                $presets[] = $preset;
            }
        }
        if (!$presets_column && !$file_mode && !empty($presets)) {
            usError("Presets need the latest database update. Run pending updates, then try again.");
        } elseif ($saveMode($enabled, $presets)) {
            $commit($snap, "Proxy settings saved.", 'Proxy mode ' . ($enabled ? 'on' : 'off') . '; presets: ' . (implode(',', $presets) ?: 'none'));
        } else {
            usError($file_mode ? $notWritable : "Could not save proxy settings.");
        }
        Redirect::to($self);
    }

    // One-click enable from the detection banner
    if (isset($_POST['enable_preset'])) {
        $preset = $postString('enable_preset');
        if (!isset(ClientIP::PRESETS[$preset])) {
            usError("Unknown preset.");
            Redirect::to($self);
        }
        $presets = $proxy_enabled ? $ip_config['presets'] : [];
        if (!in_array($preset, $presets, true)) {
            $presets[] = $preset;
        }
        if (!$presets_column && !$file_mode) {
            usError("Presets need the latest database update. Run pending updates, then try again.");
        } elseif ($saveMode(true, $presets)) {
            $commit($snap, ClientIP::PRESETS[$preset] . " is now on.", "Enabled preset $preset");
        } else {
            usError($file_mode ? $notWritable : "Could not save proxy settings.");
        }
        Redirect::to($self);
    }

    if (isset($_POST['refresh_cloudflare'])) {
        $result = ClientIP::refreshCloudflareRanges();
        if ($result['ok']) {
            $commit($snap, $result['message'] . " " . (int)$result['count'] . " ranges.", "Refreshed Cloudflare ranges ({$result['count']})");
        } else {
            usError(safeReturn($result['message']));
        }
        Redirect::to($self);
    }

    if (isset($_POST['add_proxy'])) {
        $proxy_ip = $postString('proxy_ip');
        $header_name = $postString('header_name');
        if ($header_name === 'custom') {
            $header_name = $postString('custom_header_name');
        }
        $priority = max(0, min(100, (int)$postString('priority')));

        if ($header_name === '' || !preg_match('/^[a-zA-Z0-9\-]{1,64}$/', $header_name)) {
            usError("Invalid HTTP header name. Only letters, numbers, and hyphens are allowed.");
        } elseif (!ClientIP::validCidr($proxy_ip)) {
            usError("Invalid IP address or CIDR format.");
        } elseif (!ClientIP::reasonableProxyRange($proxy_ip)) {
            usError("That range is too wide to trust as a proxy (wider than /8 for IPv4 or /32 for IPv6). Most of the internet could then choose its own address.");
        } elseif ($file_mode) {
            // Added from this page, a proxy is bound to the one header chosen
            $bindings = $ip_config['file_bindings'];
            foreach ($bindings as $existing) {
                if ($existing['cidr'] === $proxy_ip && isset($existing['headers'][$header_name])) {
                    usError("That proxy is already trusted for $header_name.");
                    Redirect::to($self);
                }
            }
            $bindings[] = ['cidr' => $proxy_ip, 'headers' => [$header_name => $priority]];
            if ($file_writable && ClientIP::writeConfigFile($ip_config['trusted_proxies'], $ip_config['trusted_headers'], null, null, $bindings)) {
                $commit($snap, "Trusted proxy added to the config file.", "Added binding $proxy_ip => $header_name to trusted_proxies.php");
            } else {
                usError($notWritable);
            }
        } else {
            if ($db->query('SELECT id FROM us_rate_limit_proxy_settings WHERE proxy_ip = ? AND header_name = ? AND enabled = 1', [$proxy_ip, $header_name])->count() > 0) {
                usError("That proxy is already trusted for $header_name.");
                Redirect::to($self);
            }
            $db->insert('us_rate_limit_proxy_settings', [
                'proxy_ip' => $proxy_ip,
                'header_name' => $header_name,
                'priority' => $priority,
                'enabled' => 1,
            ]);
            $commit($snap, "Trusted proxy added.", "Added proxy $proxy_ip using header $header_name");
        }
        Redirect::to($self);
    }

    if (isset($_POST['delete_proxy']) && !$file_mode) {
        $proxy_id = (int)$postString('proxy_id');
        $db->delete('us_rate_limit_proxy_settings', ['id' => $proxy_id]);
        $commit($snap, "Trusted proxy removed.", "Deleted proxy config ID: $proxy_id");
        Redirect::to($self);
    }

    if (isset($_POST['delete_binding']) && $file_mode) {
        // The position alone could point at a different entry if the file
        // changed since this page loaded, so the CIDR must match too.
        $index = (int)$postString('binding_index');
        $cidr = $postString('binding_cidr');
        $bindings = $ip_config['file_bindings'];
        if (!isset($bindings[$index]) || $bindings[$index]['cidr'] !== $cidr) {
            usError("That proxy entry has changed since the page loaded. Nothing was removed; review the list and try again.");
        } else {
            unset($bindings[$index]);
            if ($file_writable && ClientIP::writeConfigFile($ip_config['trusted_proxies'], $ip_config['trusted_headers'], null, null, array_values($bindings))) {
                $commit($snap, "Trusted proxy removed from the config file.", "Removed binding $cidr from trusted_proxies.php");
            } else {
                usError($notWritable);
            }
        }
        Redirect::to($self);
    }

    if (isset($_POST['delete_proxy_entry']) && $file_mode) {
        $entry = $postString('proxy_entry');
        if (!in_array($entry, $ip_config['trusted_proxies'], true)) {
            usError("That proxy isn't in the config file. Nothing was removed.");
        } elseif ($file_writable && ClientIP::writeConfigFile(array_values(array_diff($ip_config['trusted_proxies'], [$entry])), $ip_config['trusted_headers'])) {
            $commit($snap, "Proxy removed from the config file.", "Removed proxy $entry from trusted_proxies.php");
        } else {
            usError($notWritable);
        }
        Redirect::to($self);
    }

    if (isset($_POST['delete_header_entry']) && $file_mode) {
        $header_entry = $postString('header_entry');
        $headers = $ip_config['trusted_headers'];
        if (!array_key_exists($header_entry, $headers)) {
            usError("That header isn't in the config file. Nothing was removed.");
        } else {
            unset($headers[$header_entry]);
            if ($file_writable && ClientIP::writeConfigFile($ip_config['trusted_proxies'], $headers)) {
                $commit($snap, "Header removed from the config file.", "Removed header $header_entry from trusted_proxies.php");
            } else {
                usError($notWritable);
            }
        }
        Redirect::to($self);
    }

    // Export database settings to the config file. Rows are written as
    // per-proxy bindings so no proxy gains headers it wasn't trusted for.
    if (isset($_POST['export_proxy_file']) && !$file_mode) {
        $rows = $db->query("SELECT proxy_ip, header_name, priority FROM us_rate_limit_proxy_settings WHERE enabled = 1 ORDER BY priority ASC")->results();
        $bindings = [];
        foreach ($rows as $row) {
            $bindings[] = ['cidr' => trim($row->proxy_ip), 'headers' => [$row->header_name => (int)$row->priority]];
        }
        if (ClientIP::writeConfigFile([], [], null, $ip_config['presets'], $bindings)) {
            $commit($snap, "Proxy settings exported to usersc/includes/trusted_proxies.php. The file is now the authoritative source.", "Exported proxy config to trusted_proxies.php");
        } else {
            usError("Could not write usersc/includes/trusted_proxies.php. Check directory permissions.");
        }
        Redirect::to($self);
    }

    if (isset($_POST['save_cron_source'])) {
        $source = $postString('cron_ip_source');
        if (!property_exists($settings, 'cron_ip_source')) {
            usError("This setting needs the latest database update. Run pending updates, then try again.");
        } elseif (!in_array($source, ['peer', 'resolved'], true)) {
            usError("Unknown cron address setting.");
        } else {
            $db->update('settings', 1, ['cron_ip_source' => $source]);
            usSuccess("Cron address setting saved.");
            logger($user->data()->id, 'Proxy', 'Cron IP is now matched against the ' . ($source === 'peer' ? 'connection address' : 'resolved visitor'));
        }
        Redirect::to($self);
    }

    if (isset($_POST['remove_proxy_file']) && $file_mode) {
        if (is_writable(dirname($proxy_config_file)) && unlink($proxy_config_file)) {
            $commit($snap, "Config file removed. Database proxy settings are now active.", "Removed trusted_proxies.php; reverted to database proxy config");
        } else {
            usError("Could not remove the config file. Check directory permissions.");
        }
        Redirect::to($self);
    }
}

$detect = ClientIP::detect();
$cf = ClientIP::cloudflareRanges();
$active_presets = $ip_config['presets'];
$proxy_rows = [];
if (!$file_mode) {
    $proxy_rows = $db->query("SELECT * FROM us_rate_limit_proxy_settings WHERE enabled = 1 ORDER BY priority ASC")->results();
}

// Session cookie snippet check
$init_contents = @file_get_contents($abs_us_root . $us_url_root . 'users/init.php') ?: '';
$init_proxy_aware_cookie = strpos($init_contents, 'ClientIP::requestLooksHttps') !== false || strpos($init_contents, 'Server::getScheme') !== false;
$tls_upstream = !$detect['direct_https'] && ClientIP::requestLooksHttps();
$cloudflare_refresh_cron = $db->query("SELECT id FROM crons WHERE file = ?", ['refresh_cloudflare_ips.php'])->count() > 0;

// IP-based access card
$cron_ip_value = strtolower(trim((string)($settings->cron_ip ?? '')));
$cron_ip_remote = $cron_ip_value !== '' && $cron_ip_value !== 'off' && !in_array($cron_ip_value, ['127.0.0.1', '::1', 'localhost'], true);
$cron_source_column = property_exists($settings, 'cron_ip_source');
$cron_source = $settings->cron_ip_source ?? 'resolved';
$oauth_ip_clients = [];
if ($db->query("SHOW COLUMNS FROM us_oauth_server_clients LIKE 'ip_restrict_on'")->count() > 0) {
    $oauth_ip_clients = $db->query("SELECT client_name, ip_restrict FROM us_oauth_server_clients WHERE ip_restrict_on = 1 AND client_enabled = 1 ORDER BY client_name")->results();
}

$yesNo = function ($v) {
    return $v ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>';
};
?>

<div class="row">
    <div class="col-12">
        <div class="mb-3 d-flex align-items-center flex-wrap gap-2">
            <h2 class="mb-0"><i class="fas fa-network-wired me-2" aria-hidden="true"></i>Proxy &amp; CDN</h2>
            <span class="ms-auto d-flex gap-2">
                <a href="<?= $us_url_root ?>users/admin.php?view=rate_limits" class="btn btn-sm btn-outline-secondary"><i class="fas fa-traffic-light me-1" aria-hidden="true"></i>Rate Limits</a>
                <a href="<?= $us_url_root ?>users/admin.php?view=security" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1" aria-hidden="true"></i>Security Dashboard</a>
            </span>
        </div>
        <p class="mb-4">When your site sits behind Cloudflare, a load balancer, or a proxy on the same server, PHP sees the proxy's address instead of the visitor's. These settings tell UserSpice which proxies to trust, so logging, rate limiting, bans, and HTTPS detection use the real visitor.</p>
    </div>
</div>

<?php if ($detect['suggest'] === 'cloudflare' || $detect['suggest'] === 'cloudflare_tunnel'):
    $preset = $detect['suggest'];
    $preview = ClientIP::previewPreset($preset);
    $preview_banned = $isBanned($preview);
?>
<div class="alert alert-warning d-flex flex-wrap align-items-center gap-3" role="status">
    <div class="flex-grow-1">
        <strong><i class="fas fa-cloud me-1" aria-hidden="true"></i>
            <?= $preset === 'cloudflare' ? 'This request reached PHP through Cloudflare.' : 'This request reached PHP through Cloudflare Tunnel (cloudflared on this server).' ?>
        </strong>
        <br>UserSpice currently sees every visitor as <code><?= safeReturn($detect['peer']) ?></code>, so rate limits, bans, and logs all treat your visitors as one address.
        Turning this on would make your own address <code><?= safeReturn($preview) ?></code>.
        <?php if ($preset === 'cloudflare_tunnel'): ?>
            <br><small>Only use this if loopback traffic on this server comes from <code>cloudflared</code>. If another local service forwards visitors over loopback, use a custom trusted proxy instead.</small>
        <?php endif; ?>
        <?php if ($preview_banned): ?>
            <br><span class="text-danger"><i class="fas fa-ban me-1" aria-hidden="true"></i>That address is on the IP blacklist. Whitelist it in the <a href="<?= $us_url_root ?>users/admin.php?view=ip">IP Manager</a> before enabling this, or you'll lock yourself out.</span>
        <?php endif; ?>
    </div>
    <?php if (!$preview_banned && !($file_mode ? $file_writable : $presets_column)): ?>
        <p class="mb-0 small w-100"><?= $file_mode ? 'The config file isn\'t writable, so this can\'t be turned on from here. Add <code>\'presets\' =&gt; [\'' . safeReturn($preset) . '\']</code> to <code>usersc/includes/trusted_proxies.php</code>.' : 'Run pending database updates to enable presets.' ?></p>
    <?php endif; ?>
    <?php if (!$preview_banned && ($file_mode ? $file_writable : $presets_column)): ?>
    <form method="post">
        <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
        <button type="submit" name="enable_preset" value="<?= safeReturn($preset) ?>" class="btn btn-warning">
            Enable <?= $preset === 'cloudflare' ? 'Cloudflare' : 'Cloudflare Tunnel' ?> mode
        </button>
    </form>
    <?php endif; ?>
</div>
<?php elseif ($detect['suggest'] === 'custom'): ?>
<div class="alert alert-warning" role="status">
    <strong><i class="fas fa-random me-1" aria-hidden="true"></i>This request came through a proxy that isn't trusted yet.</strong>
    The connection is from <code><?= safeReturn($detect['peer']) ?></code> and carries forwarding headers (listed below).
    If that's your load balancer or reverse proxy, add it as a trusted proxy with the header it sets.
    <?php if ($detect['loopback_peer']): ?>
        <br><strong>Same-server proxy:</strong> every visitor currently arrives from loopback. UserSpice no longer treats proxied loopback requests as "localhost", but logs, rate limits, and bans will lump all visitors together until you trust this proxy.
    <?php endif; ?>
</div>
<?php endif; ?>

<?php if ($detect['upstream_resolved']): ?>
<div class="alert alert-info" role="status">
    <i class="fas fa-check-circle me-1" aria-hidden="true"></i>
    <strong>Your web server already resolves the real visitor address</strong> (<?= $detect['mod_remoteip'] ? "Apache's <code>mod_remoteip</code>" : 'for example nginx <code>real_ip</code> or Apache <code>mod_remoteip</code>' ?>).
    <?php if ($proxy_enabled): ?>
        PHP proxy mode is also on. Usually you want one or the other: with both, UserSpice treats the already-resolved visitor as the connecting proxy and falls back to it, which is harmless but redundant.
    <?php else: ?>
        Leave PHP proxy mode off. Scheme detection below still applies.
    <?php endif; ?>
</div>
<?php endif; ?>

<?php if ($file_mode): ?>
<div class="alert alert-info">
    <i class="fas fa-file-code me-1" aria-hidden="true"></i>
    <strong>File-based configuration.</strong> Settings come from <code>usersc/includes/trusted_proxies.php</code>; database proxy settings are ignored while it exists. Changes made here are written to the file.
    <?php if (!$file_writable): ?>
        <br><span class="text-danger"><i class="fas fa-lock me-1" aria-hidden="true"></i>The file isn't writable, so this page is read-only.</span>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php if (!empty($ip_config['file_error'])): ?>
<div class="alert alert-danger" role="alert">
    <i class="fas fa-exclamation-triangle me-1" aria-hidden="true"></i>
    <strong><code>usersc/includes/trusted_proxies.php</code> couldn't be loaded</strong> (it may be incomplete or contain a PHP error). Until it's fixed, UserSpice trusts no proxy headers and uses the raw connection address.
</div>
<?php endif; ?>

<?php if ($proxy_enabled && empty($ip_config['bindings'])): ?>
<div class="alert alert-warning" role="status">
    Proxy mode is on, but no trusted proxy or preset is configured, so nothing changes yet. Add your proxy below or turn on a preset.
</div>
<?php endif; ?>

<?php if ($file_mode && !empty($ip_config['trusted_proxies']) && count($ip_config['trusted_headers']) > 1): ?>
<div class="alert alert-warning" role="status">
    <strong>Legacy list trusts every header from every proxy.</strong> The <code>trusted_proxies</code> / <code>trusted_headers</code> lists in the config file let each listed proxy supply any of <?= count($ip_config['trusted_headers']) ?> headers, so a client can send whichever header a proxy passes through untouched. Re-add each proxy with only the header it really sets (Add), then remove the legacy entries.
</div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-7">

        <div class="card mb-4">
            <div class="card-header"><h3 class="h5 mb-0"><i class="fas fa-sliders-h me-2" aria-hidden="true"></i>Mode</h3></div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="proxy_enabled" name="proxy_enabled" value="1" <?= $proxy_enabled ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold" for="proxy_enabled">Trust forwarded client addresses from the proxies below</label>
                        <div class="form-text">Off: UserSpice uses the raw connection address for everything, exactly as a site with no proxy.</div>
                    </div>

                    <fieldset class="mb-3">
                        <legend class="h6">Presets</legend>
                        <?php foreach (ClientIP::PRESETS as $key => $label): ?>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="presets[]" value="<?= safeReturn($key) ?>" id="preset_<?= safeReturn($key) ?>" <?= in_array($key, $active_presets, true) ? 'checked' : '' ?> <?= (!$presets_column && !$file_mode) ? 'disabled aria-describedby="presets_unavailable"' : '' ?>>
                                <label class="form-check-label" for="preset_<?= safeReturn($key) ?>"><?= safeReturn($label) ?></label>
                            </div>
                        <?php endforeach; ?>
                        <?php if (!$presets_column && !$file_mode): ?>
                            <div class="text-danger small" id="presets_unavailable">Presets need the latest database update. Run pending updates first.</div>
                        <?php endif; ?>
                    </fieldset>

                    <?php if (!$file_mode || $file_writable): ?>
                        <button type="submit" name="save_mode" class="btn btn-primary">Save</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0"><i class="fas fa-server me-2" aria-hidden="true"></i>Trusted proxies</h3>
                <?php if (!$file_mode || $file_writable): ?>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addProxyModal"><i class="fas fa-plus me-1" aria-hidden="true"></i>Add</button>
                <?php endif; ?>
            </div>
            <div class="card-body p-0">
                <p class="small text-body-secondary p-3 mb-0 border-bottom">Each proxy is trusted only for the header listed with it. Presets add their own entries and aren't listed here.</p>
                <?php $listed = 0; ?>
                <?php if ($file_mode): ?>
                    <?php foreach ($ip_config['file_bindings'] as $i => $binding): $listed++; ?>
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?= safeReturn($binding['cidr']) ?></strong>
                                <br><small class="text-body-secondary">Header: <?= safeReturn(implode(', ', array_keys($binding['headers']))) ?></small>
                            </div>
                            <?php if ($file_writable): ?>
                                <form method="post">
                                    <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
                                    <input type="hidden" name="binding_index" value="<?= (int)$i ?>">
                                    <input type="hidden" name="binding_cidr" value="<?= safeReturn($binding['cidr']) ?>">
                                    <button type="submit" name="delete_binding" class="btn btn-sm btn-outline-danger" aria-label="Remove <?= safeReturn($binding['cidr']) ?>" data-us-confirm="Remove this trusted proxy from the config file?"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    <?php if (!empty($ip_config['trusted_proxies']) || !empty($ip_config['trusted_headers'])): ?>
                        <div class="p-3 border-bottom bg-body-tertiary small">
                            <strong>Legacy list</strong>: every proxy below may supply every header below. Prefer per-proxy entries (Add) for new proxies.
                        </div>
                        <?php foreach ($ip_config['trusted_proxies'] as $entry): $listed++; ?>
                            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                                <div><strong><?= safeReturn($entry) ?></strong><br><small class="text-body-secondary">Proxy (legacy list)</small></div>
                                <?php if ($file_writable): ?>
                                    <form method="post">
                                        <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
                                        <input type="hidden" name="proxy_entry" value="<?= safeReturn($entry) ?>">
                                        <button type="submit" name="delete_proxy_entry" class="btn btn-sm btn-outline-danger" aria-label="Remove <?= safeReturn($entry) ?>" data-us-confirm="Remove this proxy from the config file?"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        <?php foreach ($ip_config['trusted_headers'] as $header_name => $priority): ?>
                            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                                <div><strong><?= safeReturn($header_name) ?></strong><br><small class="text-body-secondary">Header (legacy list) &middot; priority <?= (int)$priority ?></small></div>
                                <?php if ($file_writable): ?>
                                    <form method="post">
                                        <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
                                        <input type="hidden" name="header_entry" value="<?= safeReturn($header_name) ?>">
                                        <button type="submit" name="delete_header_entry" class="btn btn-sm btn-outline-danger" aria-label="Remove <?= safeReturn($header_name) ?>" data-us-confirm="Remove this header from the config file?"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php foreach ($proxy_rows as $row): $listed++; ?>
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?= safeReturn($row->proxy_ip) ?></strong>
                                <br><small class="text-body-secondary">Header: <?= safeReturn($row->header_name) ?> &middot; priority <?= (int)$row->priority ?></small>
                            </div>
                            <form method="post">
                                <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
                                <input type="hidden" name="proxy_id" value="<?= (int)$row->id ?>">
                                <button type="submit" name="delete_proxy" class="btn btn-sm btn-outline-danger" aria-label="Remove <?= safeReturn($row->proxy_ip) ?>" data-us-confirm="Remove this trusted proxy?"><i class="fas fa-trash" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($listed === 0): ?>
                    <div class="p-3 small text-body-secondary">No custom trusted proxies.<?= empty($active_presets) ? '' : ' Presets are handling trust.' ?></div>
                <?php endif; ?>
            </div>
            <div class="card-footer d-flex flex-wrap gap-2">
                <?php if ($file_mode): ?>
                    <form method="post">
                        <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
                        <button type="submit" name="remove_proxy_file" class="btn btn-sm btn-outline-danger" data-us-confirm="Delete usersc/includes/trusted_proxies.php and switch back to database-managed settings?"><i class="fas fa-database me-1" aria-hidden="true"></i>Switch back to database settings</button>
                    </form>
                <?php elseif ($file_writable): ?>
                    <form method="post">
                        <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
                        <button type="submit" name="export_proxy_file" class="btn btn-sm btn-outline-secondary" data-us-confirm="Write these settings to usersc/includes/trusted_proxies.php? The file becomes the authoritative source, so provisioning scripts can manage it."><i class="fas fa-file-export me-1" aria-hidden="true"></i>Export to config file</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($tls_upstream && !$init_proxy_aware_cookie): ?>
        <div class="card mb-4 border-warning">
            <div class="card-header bg-warning bg-opacity-25"><h3 class="h5 mb-0"><i class="fas fa-cookie-bite me-2" aria-hidden="true"></i>Session cookie isn't marked Secure</h3></div>
            <div class="card-body">
                <p>HTTPS ends at your proxy, so PHP sees plain HTTP and <code>users/init.php</code> never marks the session cookie <code>Secure</code>. Replace the <code>session.cookie_secure</code> block in <code>users/init.php</code> with:</p>
                <pre class="bg-dark text-light p-3 rounded" tabindex="0"><code>// Proxy-aware: also true when TLS ends at a proxy or CDN in front of PHP
if (ClientIP::requestLooksHttps()) {
    ini_set('session.cookie_secure', 1);
}</code></pre>
                <p class="small text-body-secondary mb-0">It must stay above <code>session_start();</code>. It's deliberately lenient: a forged header can only mark the forger's own cookie Secure.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header"><h3 class="h5 mb-0"><i class="fas fa-search-location me-2" aria-hidden="true"></i>What PHP sees right now</h3></div>
            <div class="card-body">
                <dl class="row mb-0 small">
                    <dt class="col-6">Connection (REMOTE_ADDR)</dt><dd class="col-6"><code><?= safeReturn($detect['peer']) ?></code></dd>
                    <dt class="col-6">Resolved visitor</dt><dd class="col-6"><code><?= safeReturn($detect['resolved']) ?></code></dd>
                    <dt class="col-6">Via a trusted proxy</dt><dd class="col-6"><?= $yesNo($detect['trusted_peer']) ?></dd>
                    <dt class="col-6">Scheme</dt><dd class="col-6"><?= safeReturn(strtoupper($detect['scheme'])) ?><?= $detect['direct_https'] ? '' : ($detect['scheme'] === 'https' ? ' <small class="text-body-secondary">(from proxy)</small>' : '') ?></dd>
                    <?php if ($detect['country'] !== ''): ?>
                        <dt class="col-6">Country (Cloudflare)</dt><dd class="col-6"><?= safeReturn($detect['country']) ?></dd>
                    <?php endif; ?>
                    <dt class="col-6">Counts as localhost</dt><dd class="col-6"><?= $yesNo($detect['local']) ?></dd>
                    <dt class="col-6">Cloudflare edge address</dt><dd class="col-6"><?= $yesNo($detect['cloudflare_peer']) ?></dd>
                    <dt class="col-6">mod_remoteip loaded</dt><dd class="col-6"><?= $yesNo($detect['mod_remoteip']) ?></dd>
                </dl>
                <?php if (!empty($detect['forwarding_headers'])): ?>
                    <h4 class="h6 mt-3">Forwarding headers on this request</h4>
                    <p class="small text-body-secondary mb-1">Anyone can send these. They're only used when the connection comes from a trusted proxy.</p>
                    <ul class="small mb-0 ps-3">
                        <?php foreach ($detect['forwarding_headers'] as $name => $value): ?>
                            <li><code><?= safeReturn($name) ?>: <?= safeReturn($value) ?></code></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h3 class="h5 mb-0"><i class="fas fa-user-shield me-2" aria-hidden="true"></i>IP-based access</h3></div>
            <div class="card-body small">
                <p class="text-body-secondary">Features that allow or refuse requests by address. An allowlist that is the only gate checks the <strong>connection address</strong>; one that is a second check on top of a secret checks the <strong>resolved visitor</strong>.</p>

                <h4 class="h6">Cron jobs (<code>users/cron/cron.php</code>)</h4>
                <?php if ($cron_ip_value === ''): ?>
                    <p class="mb-2"><span class="badge bg-warning text-dark">Open</span> No cron IP is set, so anyone can run your cron jobs. Set one in <a href="<?= $us_url_root ?>users/admin.php?view=general">General settings</a>.</p>
                <?php elseif ($cron_ip_value === 'off'): ?>
                    <p class="mb-2">Cron jobs are switched off (cron IP is <code>off</code>). Only requests from this server itself can run them.</p>
                <?php elseif (!$cron_ip_remote): ?>
                    <p class="mb-2">Cron IP is <code><?= safeReturn($cron_ip_value) ?></code>: only genuinely local requests (this server's own crontab or command line) can run cron jobs.</p>
                <?php else: ?>
                    <p class="mb-2">Cron IP is <code><?= safeReturn($cron_ip_value) ?></code>. A request from this server itself is always allowed.</p>
                    <?php if ($cron_source_column): ?>
                        <form method="post" class="mb-2">
                            <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
                            <label for="cron_ip_source" class="form-label">Compare the cron IP with</label>
                            <div class="input-group input-group-sm">
                                <select class="form-select" id="cron_ip_source" name="cron_ip_source">
                                    <option value="peer" <?= $cron_source === 'peer' ? 'selected' : '' ?>>Connection address (recommended)</option>
                                    <option value="resolved" <?= $cron_source === 'resolved' ? 'selected' : '' ?>>Resolved visitor</option>
                                </select>
                                <button type="submit" name="save_cron_source" class="btn btn-outline-primary">Save</button>
                            </div>
                        </form>
                        <p class="text-body-secondary mb-2">Connection address: the cron service must reach this server directly, not through Cloudflare or another proxy. Resolved visitor: works through a trusted proxy, but depends on the proxy settings above being right. This request's connection is <code><?= safeReturn($detect['peer']) ?></code> and its resolved visitor is <code><?= safeReturn($detect['resolved']) ?></code>.</p>
                    <?php else: ?>
                        <p class="mb-2 text-body-secondary">Compared with the resolved visitor. Run the updater to choose the connection address instead.</p>
                    <?php endif; ?>
                <?php endif; ?>

                <h4 class="h6 mt-3">OAuth server IP restrictions</h4>
                <?php if (empty($oauth_ip_clients)): ?>
                    <p class="mb-2">No OAuth client enforces an IP restriction.</p>
                <?php else: ?>
                    <ul class="ps-3 mb-2">
                        <?php foreach ($oauth_ip_clients as $oc): ?>
                            <li><?= safeReturn($oc->client_name, true) ?>: <code><?= safeReturn($oc->ip_restrict, true) ?></code></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <p class="text-body-secondary mb-2">Checked against the resolved visitor, as a second check on top of the client secret. Managed on the <a href="<?= $us_url_root ?>users/admin.php?view=oauth">OAuth Server</a> page.</p>

                <h4 class="h6 mt-3">Fixed rules</h4>
                <ul class="ps-3 mb-0">
                    <li>Bans, rate limits and logs: resolved visitor.</li>
                    <li>Releasing a blacklisted address: connection address.</li>
                    <li>Localhost-only features: genuinely local requests only (see "Counts as localhost" above).</li>
                </ul>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h3 class="h5 mb-0"><i class="fas fa-cloud me-2" aria-hidden="true"></i>Cloudflare ranges</h3></div>
            <div class="card-body small">
                <p class="mb-2"><?= count($cf['ranges']) ?> ranges, <?= $cf['source'] === 'cache' ? 'refreshed' : 'bundled with UserSpice' ?> <?= safeReturn($cf['as_of']) ?>.</p>
                <p class="mb-3 text-body-secondary">Cloudflare rarely changes these. If they go stale, new edge addresses are simply not trusted, so it fails safe.</p>
                <form method="post" class="mb-2">
                    <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
                    <button type="submit" name="refresh_cloudflare" class="btn btn-sm btn-outline-secondary"><i class="fas fa-sync me-1" aria-hidden="true"></i>Refresh from cloudflare.com</button>
                </form>
                <?php if (!$cloudflare_refresh_cron): ?>
                    <p class="mb-0 text-body-secondary">To refresh automatically, add <code>refresh_cloudflare_ips.php</code> in the <a href="<?= $us_url_root ?>users/admin.php?view=cron">Cron Manager</a> (weekly is plenty).</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><h3 class="h5 mb-0"><i class="fas fa-lightbulb me-2" aria-hidden="true"></i>Running behind Cloudflare</h3></div>
            <div class="card-body small">
                <ul class="ps-3 mb-0">
                    <li class="mb-1">Use SSL/TLS mode <strong>Full (strict)</strong>, not Flexible. Flexible leaves the hop to your server unencrypted.</li>
                    <li class="mb-1">Cloudflare ends requests after <strong>100 seconds</strong> (error 524) and caps uploads at <strong>100&nbsp;MB</strong> on Free and Pro plans. Run long jobs from cron or the CLI.</li>
                    <li class="mb-1">Never apply a "Cache Everything" rule to pages that show logged-in content.</li>
                    <li class="mb-1">Lock your origin to Cloudflare (firewall to Cloudflare's ranges, Authenticated Origin Pulls, or Cloudflare Tunnel) so visitors can't bypass it.</li>
                    <li class="mb-1">Point cron jobs and server-to-server calls at the origin or the CLI, not the public hostname.</li>
                    <li>If Apache <code>mod_remoteip</code> or nginx <code>real_ip</code> already resolves visitors, leave PHP proxy mode off: use one or the other.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addProxyModal" tabindex="-1" aria-labelledby="addProxyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title h5" id="addProxyModalLabel">Add trusted proxy</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" name="csrf" value="<?= Token::generate() ?>">
                    <div class="mb-3">
                        <label for="proxy_ip" class="form-label">Proxy IP address or CIDR</label>
                        <input type="text" class="form-control" id="proxy_ip" name="proxy_ip" required placeholder="10.0.0.5 or 10.0.0.0/8" aria-describedby="proxy_ip_help">
                        <div class="form-text" id="proxy_ip_help">The address your proxy connects to PHP from.</div>
                    </div>
                    <div class="mb-3">
                        <label for="header_name" class="form-label">Header it sets</label>
                        <select class="form-select" id="header_name" name="header_name" required>
                            <option value="X-Forwarded-For">X-Forwarded-For</option>
                            <option value="X-Real-IP">X-Real-IP</option>
                            <option value="CF-Connecting-IP">CF-Connecting-IP (Cloudflare)</option>
                            <option value="Forwarded">Forwarded (RFC 7239)</option>
                            <option value="True-Client-IP">True-Client-IP (Akamai)</option>
                            <option value="X-Azure-ClientIP">X-Azure-ClientIP (Azure)</option>
                            <option value="X-Cluster-Client-IP">X-Cluster-Client-IP (GCP)</option>
                            <option value="X-Client-IP">X-Client-IP</option>
                            <option value="custom">Custom header…</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="customHeaderDiv">
                        <label for="custom_header_name" class="form-label">Custom header name</label>
                        <input type="text" class="form-control" id="custom_header_name" name="custom_header_name" placeholder="X-Your-Header">
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Priority</label>
                        <input type="number" class="form-control" id="priority" name="priority" value="0" min="0" max="100" aria-describedby="priority_help">
                        <div class="form-text" id="priority_help">Lower is checked first, when one proxy is trusted for several headers.</div>
                    </div>
                    <div class="alert alert-warning p-2 small mb-0">
                        Only add proxies you control. A trusted proxy decides which visitor address UserSpice logs, rate limits, and bans. Make sure it overwrites (not passes through) the header you choose.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="add_proxy" class="btn btn-primary">Add trusted proxy</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script nonce="<?= htmlspecialchars($userspice_nonce ?? '') ?>">
    (function () {
        var select = document.getElementById('header_name');
        var customDiv = document.getElementById('customHeaderDiv');
        var customInput = document.getElementById('custom_header_name');
        if (!select) { return; }
        select.addEventListener('change', function () {
            var custom = select.value === 'custom';
            customDiv.classList.toggle('d-none', !custom);
            customInput.required = custom;
            if (custom) { customInput.focus(); } else { customInput.value = ''; }
        });
    })();
</script>
