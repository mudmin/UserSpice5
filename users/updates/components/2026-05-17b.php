<?php
// 2026-05-17b — Add the light/dark colour-mode toggle to UltraMenu.
//
// Inserts a self-gating "snippet" menu item as the far-right top-level item
// of the Main Menu (1) and the Dashboard Menu (2). The snippet file,
// users/includes/menu_hooks/theme_toggle.php, renders the toggle ONLY on
// templates that advertise a dark colour scheme (dark_mode.php marker), so on
// every other template the item is present but emits nothing. Admins can
// move, edit, disable or delete the item like any other menu item.
$countE = 0;

$snippetLink = 'users/includes/menu_hooks/theme_toggle.php';

// Idempotency guard — never insert a second copy if this somehow re-runs.
if ($db->query("SELECT id FROM us_menu_items WHERE link = ?", [$snippetLink])->count() == 0) {

    // menu id => permissions JSON. The Main Menu is public, so list logged-out
    // (0) plus the stock Standard (1) and Admin (2) groups; the Dashboard Menu
    // is admin-only. Admins can adjust the item's permissions afterwards.
    $targets = [
        1 => '["0","1","2"]',
        2 => '["2"]',
    ];

    foreach ($targets as $menuId => $perms) {
        // Only touch menus that actually exist on this install.
        if ($db->query("SELECT id FROM us_menus WHERE id = ?", [$menuId])->count() == 0) {
            continue;
        }

        // Far right = one past the current highest top-level display_order.
        $maxRow = $db->query(
            "SELECT MAX(display_order) AS mx FROM us_menu_items WHERE menu = ? AND parent = 0",
            [$menuId]
        )->first();
        $order = (int)($maxRow->mx ?? 0) + 1;

        $db->insert('us_menu_items', [
            'menu'          => $menuId,
            'type'          => 'snippet',
            'label'         => 'Light / Dark Mode',
            'link'          => $snippetLink,
            'icon_class'    => '',
            'li_class'      => '',
            'a_class'       => '',
            'link_target'   => '_self',
            'parent'        => 0,
            'display_order' => $order,
            'disabled'      => 0,
            'permissions'   => $perms,
        ]);
    }
}

include($abs_us_root . $us_url_root . "users/updates/components/_complete.php");
