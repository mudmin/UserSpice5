<?php
// UserSpice specific customization options

return [
    'userspice' => [
        'us_menu_custom_bg' => [
            'label'       => 'Custom Menu Background',
            'description' => 'Background color for custom UserSpice menus. Please note that your UltraMenus have themes and you must use the "custom" theme to see these changes.',
            'type'        => 'color',
            'variable'    => '--bs-us-menu-custom-bg',
            'value'       => '#3a5e8c',
            'css_rules'   => [
                'ul.us_menu.custom, ul.us_menu.custom .us_sub-menu li, ul.us_menu.custom ul.us_sub-menu' => [
                    'background-color' => 'var(--bs-us-menu-custom-bg, #3a5e8c)'
                ]
            ]
        ],
        'us_menu_custom_text' => [
            'label'       => 'Custom Menu Text Color',
            'description' => 'Text color for custom UserSpice menus',
            'type'        => 'color',
            'variable'    => '--bs-us-menu-custom-text',
            'value'       => 'rgba(255, 255, 255, 0.85)',
            'css_rules'   => [
                'ul.us_menu.custom a, ul.us_menu.custom .us_menu_mobile_control' => [
                    'color' => 'var(--bs-us-menu-custom-text, rgba(255, 255, 255, 0.85))'
                ]
            ]
        ],
        'us_menu_custom_hover_bg' => [
            'label'       => 'Custom Menu Hover Background',
            'description' => 'Background color for hover state on custom menus',
            'type'        => 'color',
            'variable'    => '--bs-us-menu-custom-hover-bg',
            'value'       => '#4a6e9c',
            'css_rules'   => [
                'ul.us_menu.custom li:hover' => [
                    'background-color' => 'var(--bs-us-menu-custom-hover-bg, #4a6e9c)'
                ],
                'ul.us_menu.custom li:hover > a' => [
                    'background-color' => 'var(--bs-us-menu-custom-hover-bg, #4a6e9c)'
                ]
            ]
        ],
        'us_menu_custom_hover_text' => [
            'label'       => 'Custom Menu Hover Text',
            'description' => 'Text color for hover state on custom menus',
            'type'        => 'color',
            'variable'    => '--bs-us-menu-custom-hover-text',
            'value'       => '#ffffff',
            'css_rules'   => [
                'ul.us_menu.custom li:hover > a' => [
                    'color' => 'var(--bs-us-menu-custom-hover-text, #ffffff)'
                ]
            ]
        ],
        'us_menu_custom_active_bg' => [
            'label'       => 'Custom Menu Active Background',
            'description' => 'Background color for active items on custom menus',
            'type'        => 'color',
            'variable'    => '--bs-us-menu-custom-active-bg',
            'value'       => '#264e7c',
            'css_rules'   => [
                'ul.us_menu.custom li.active-style > a' => [
                    'background-color' => 'var(--bs-us-menu-custom-active-bg, #264e7c)'
                ]
            ]
        ],
        'us_menu_custom_active_text' => [
            'label'       => 'Custom Menu Active Text',
            'description' => 'Text color for active items on custom menus',
            'type'        => 'color',
            'variable'    => '--bs-us-menu-custom-active-text',
            'value'       => '#ffffff',
            'css_rules'   => [
                'ul.us_menu.custom li.active-style > a' => [
                    'color' => 'var(--bs-us-menu-custom-active-text, #ffffff)'
                ]
            ]
        ],
        'us_menu_custom_divider' => [
            'label'       => 'Custom Menu Divider',
            'description' => 'Color for dividers in custom menus',
            'type'        => 'color',
            'variable'    => '--bs-us-menu-custom-divider',
            'value'       => 'rgba(255, 255, 255, 0.2)',
            'css_rules'   => [
                'ul.us_menu.custom .dropdown-divider' => [
                    'border-color' => 'var(--bs-us-menu-custom-divider, rgba(255, 255, 255, 0.2))'
                ]
            ]
        ],
        'us_menu_custom_submenu_border' => [
            'label'       => 'Custom Submenu Border',
            'description' => 'Border color for submenus in custom style',
            'type'        => 'color',
            'variable'    => '--bs-us-menu-custom-submenu-border',
            'value'       => '#2d5580',
            'css_rules'   => [
                'ul.us_menu.custom .us_sub-menu' => [
                    'border-color' => 'var(--bs-us-menu-custom-submenu-border, #2d5580)'
                ]
            ]
        ],
    ]
];