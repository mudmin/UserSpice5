<?php
/*
 * Cloudflare's published edge ranges, used by the 'cloudflare' proxy preset
 * (see ClientIP). Source: https://www.cloudflare.com/ips-v4 and /ips-v6.
 *
 * This bundled list is the fallback. A refreshed copy at
 * usersc/includes/cloudflare_ips.cache.php takes precedence when it exists
 * and validates. A stale list fails closed: an unlisted edge resolves as the
 * edge address itself, never as a header-supplied one.
 *
 * Re-check against Cloudflare on release day and bump 'as_of'.
 */
return [
    'as_of' => '2026-11-01',
    'v4' => [
        '173.245.48.0/20',
        '103.21.244.0/22',
        '103.22.200.0/22',
        '103.31.4.0/22',
        '141.101.64.0/18',
        '108.162.192.0/18',
        '190.93.240.0/20',
        '188.114.96.0/20',
        '197.234.240.0/22',
        '198.41.128.0/17',
        '162.158.0.0/15',
        '104.16.0.0/13',
        '104.24.0.0/14',
        '172.64.0.0/13',
        '131.0.72.0/22',
    ],
    'v6' => [
        '2400:cb00::/32',
        '2606:4700::/32',
        '2803:f800::/32',
        '2405:b500::/32',
        '2405:8100::/32',
        '2a06:98c0::/29',
        '2c0f:f248::/32',
    ],
];
