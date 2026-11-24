<?php /* UserSpice AI Prompt — protected from HTTP access. Markdown content below. */ __halt_compiler(); ?>

# UserSpice — Proxies, CDNs and Client IPs

Load this when code reads a visitor's IP address, decides a request is "local", checks HTTPS, gates something by IP (cron, webhooks, allowlists), or when the site runs behind Cloudflare, a load balancer, a same-server reverse proxy or a tunnel.

Behind a proxy, `$_SERVER['REMOTE_ADDR']` is the proxy, not the visitor, and `$_SERVER['HTTPS']` is empty when the proxy ends TLS. Forwarded headers (`X-Forwarded-For`, `CF-Connecting-IP`) can be sent by anyone, so they only count when they come from a proxy the site trusts. `ClientIP` (`users/classes/ClientIP.php`) does that work. Use it instead of reading `$_SERVER` yourself.

---

## The contracts

| Question | Call | Returns |
|---|---|---|
| Who is the visitor? (logs, audit rows, rate limits, bans) | `ipCheck()` (same as `ClientIP::get()`) | The visitor resolved through trusted proxies. With proxy mode off, `REMOTE_ADDR`. |
| What connected to PHP? | `ClientIP::peer()` | The raw connection address. Never header-derived. |
| Is this request from this machine? | `ClientIP::isLocal()` | True only for the CLI, or a loopback connection with no forwarding headers, not from a trusted proxy, with a localhost `Host`. Fails closed. |
| Is the request HTTPS? | `ClientIP::isHttps()` | Honors `X-Forwarded-Proto`, `CF-Visitor` and `Forwarded: proto=` only from a trusted proxy. |
| Should the session cookie be Secure? | `ClientIP::requestLooksHttps()` | Lenient: trusts proto headers from anyone. Only for cookie flags; never to grant anything. |

Related: `ClientIP::isTrustedPeer()` (the connection is a configured proxy), `ClientIP::hasForwardingHeaders()` (any proxy or CDN header is present), `ClientIP::inRange($ip, $cidr)` (IPv4/IPv6 CIDR match), `ClientIP::detect()` (the diagnostic array the admin page shows).

### Which address for an IP allowlist

**An allowlist that is the only gate uses `ClientIP::peer()`. An allowlist that is a second check on top of a secret uses `ClientIP::get()`.**

- Only gate (an IP-locked admin tool, a cron endpoint with no key): a forwarded header must never open it, so compare the connection. Behind a CDN that means the caller has to reach the origin directly.
- Second check (an API key or signed webhook plus an IP list): the secret is the real gate. The resolved address keeps the check working through a CDN, and a spoofed header at worst falls back to "secret only".

```php
// Only gate: the connection address
$allowed = ['203.0.113.10', '198.51.100.0/24'];
$ok = ClientIP::isLocal();
foreach ($allowed as $range) {
    $ok = $ok || ClientIP::inRange(ClientIP::peer(), $range);
}
if (!$ok) { http_response_code(403); die('Forbidden'); }

// Second check behind a valid signature: the resolved visitor
if (!$signatureValid || !ClientIP::inRange(ipCheck(), $partnerRange)) {
    http_response_code(403); die('Forbidden');
}
```

### Never compare with `127.0.0.1` or `::1`

Behind a same-server reverse proxy (nginx in front of Apache or PHP-FPM), a TLS terminator on the same box, or a Cloudflare Tunnel (`cloudflared`), **every visitor arrives from loopback**. Code like `if (ClientIP::peer() === '127.0.0.1')` treats the whole internet as local: crons open to anyone, debug output shown to the public, "localhost login" tools logging strangers in. Use `ClientIP::isLocal()` for every such decision. `isLocalhost()` and `passwordsAllowed()` already use it.

Dev hostnames other than `localhost`, `127.0.0.1`, `[::1]` and `*.localhost` go in `users/init.php`:

```php
define('US_LOCAL_HOSTS', ['mysite.test']);
```

### HTTPS

Don't read `$_SERVER['HTTPS']` or the port: behind Cloudflare or a load balancer that ends TLS they say "http" to PHP. Use `ClientIP::isHttps()`. `users/init.php` marks the session cookie Secure with:

```php
if (ClientIP::requestLooksHttps()) {
    ini_set('session.cookie_secure', 1);
}
```

Older installs may still have an HTTPS-only check there; the Proxy & CDN page and the Security Dashboard offer the fix.

---

## Configuring proxy trust

**Admin → Proxy & CDN** (`users/admin.php?view=proxy`). It shows what PHP sees right now (connection, resolved visitor, scheme, forwarding headers, whether this request counts as local), detects Cloudflare, and has one-click modes.

- **Presets:** `cloudflare` trusts Cloudflare's published edge ranges for `CF-Connecting-IP`. `cloudflare_tunnel` trusts loopback for `CF-Connecting-IP`; use it only when loopback traffic on the box means `cloudflared`.
- **Trusted proxies:** each proxy range is bound to the header(s) it may supply. A load balancer trusted for `X-Forwarded-For` can't be used to inject `CF-Connecting-IP`.
- **One hop by default:** the rightmost entry of a forwarded list (written by your proxy) is used. Walking further left through a chain is opt-in per binding (`'recursive' => true`). Loopback and link-local addresses are never accepted from a header.
- **Lockout guard:** a change that would resolve your own address to a blacklisted one is rolled back.
- **Fresh installs** start with proxy mode on and the `cloudflare` preset. That's safe off Cloudflare: only Cloudflare's own addresses are trusted, and the TCP connection proves the peer. Existing installs keep their settings; the page shows a "you're behind Cloudflare" banner when it sees one.
- **`mod_remoteip` or nginx `real_ip`:** if the web server already rewrites `REMOTE_ADDR` to the visitor, leave PHP proxy mode off. Use one or the other.

### Where the settings live

- **Database (normal):** `settings.behind_reverse_proxy` (on/off), `settings.proxy_presets` (CSV of presets) and the `us_rate_limit_proxy_settings` table (proxy, header, priority).
- **Override file (optional):** `usersc/includes/trusted_proxies.php` returns an array (`enabled`, `presets`, `trusted_proxies`, `trusted_headers`, `bindings`). **When it exists it replaces the database settings entirely; the two are never merged.** A broken file fails closed (no header trust). The admin page can export to it and switch back.
- **Why the database is the default:** `usersc/` is what gets deployed. A `trusted_proxies.php` created on a localhost install ships with the code and silently replaces production's proxy settings. Use the file only for deliberate fleet-wide configuration or to recover from a lockout, and never commit one made on a dev box.

### Cloudflare ranges

Bundled in `users/includes/cloudflare_ips.php`. "Refresh from cloudflare.com" on the Proxy & CDN page, or the `users/cron/refresh_cloudflare_ips.php` job in the Cron Manager, writes a validated `usersc/includes/cloudflare_ips.cache.php` that takes precedence. Stale ranges fail safe: a new edge address simply isn't trusted.

---

## Cron jobs

`users/cron/cron.php` asks `cronCallerAllowed()`, which reads `settings.cron_ip`:

| `cron_ip` | Who may run cron |
|---|---|
| empty | anyone (the Security Dashboard warns) |
| `127.0.0.1`, `::1`, `localhost` | only `ClientIP::isLocal()` requests: this server's crontab or CLI |
| `off` | only local requests |
| an address | that caller, plus local requests |

For an address, `settings.cron_ip_source` picks what it's compared with: `peer` (the connection, recommended; fresh installs) or `resolved` (the visitor through trusted proxies). A missing column reads as `resolved`. It's set on the Proxy & CDN page under "IP-based access". Point external cron services at the origin or use the CLI, not the public hostname behind a CDN. `users/release_blacklist.php` always compares with the connection.

---

## Running behind Cloudflare

- SSL/TLS mode **Full (strict)**, not Flexible.
- Requests end after 100 seconds (error 524) and uploads cap at 100 MB on Free and Pro. Run long jobs from cron or the CLI.
- Never "Cache Everything" on pages with logged-in content or forms; cached HTML carries other users' CSRF tokens.
- Lock the origin to Cloudflare (firewall to Cloudflare's ranges, Authenticated Origin Pulls, or a Tunnel) so visitors can't skip it.
- Rocket Loader reorders scripts; turn it off if page JavaScript breaks.
- Country: `ClientIP::detect()['country']` holds `CF-IPCountry`, only when the connection is a trusted Cloudflare edge.

---

## Legacy and host helpers

- `Server::getClientIp()` with no argument now follows `ClientIP`. It's kept for old code; new code uses `ipCheck()`.
- `Server::getHost()` and `Server::getOrigin()` read the host and origin. They don't trust `X-Forwarded-Host`, by design (host-header poisoning of reset links).
- Never read `CF-Connecting-IP` or `X-Forwarded-For` yourself.

---

## Compatibility guards

`ClientIP` exists from 6.1.6; `ClientIP::isLocal()`, `ClientIP::isHttps()`, `ClientIP::isLoopback()` and the proxy presets from 6.1.8. Plugins that must run on older cores:

```php
function myVisitorIp() {
    if (class_exists('ClientIP') && method_exists('ClientIP', 'get')) {
        return ClientIP::get();
    }
    return Server::getClientIp();   // older cores: the connection address
}

function myIsLocal() {
    if (class_exists('ClientIP') && method_exists('ClientIP', 'isLocal')) {
        return ClientIP::isLocal();
    }
    return false;   // can't prove it on an old core: fail closed
}
```
