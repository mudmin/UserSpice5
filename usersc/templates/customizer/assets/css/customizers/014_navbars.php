<?php
// Navbar customization options

return [
    'navbars' => [
        'navbar_light_color' => [
            'label'       => 'Navbar Light Text Color',
            'type'        => 'color',
            'variable'    => '--bs-navbar-light-color',
            'value'       => 'rgba(0, 0, 0, 0.55)',
            'css_rules'   => [
                '.navbar-light .navbar-nav .nav-link' => [
                    'color' => 'var(--bs-navbar-light-color)'
                ]
            ]
        ],
        'navbar_light_hover_color' => [
            'label'       => 'Navbar Light Hover Color',
            'type'        => 'color',
            'variable'    => '--bs-navbar-light-hover-color',
            'value'       => 'rgba(0, 0, 0, 0.7)',
            'css_rules'   => [
                '.navbar-light .navbar-nav .nav-link:hover' => [
                    'color' => 'var(--bs-navbar-light-hover-color)'
                ]
            ]
        ],
        'navbar_dark_color' => [
            'label'       => 'Navbar Dark Text Color',
            'type'        => 'color',
            'variable'    => '--bs-navbar-dark-color',
            'value'       => 'rgba(255, 255, 255, 0.55)',
            'css_rules'   => [
                '.navbar-dark .navbar-nav .nav-link' => [
                    'color' => 'var(--bs-navbar-dark-color)'
                ]
            ]
        ],
        'navbar_dark_hover_color' => [
            'label'       => 'Navbar Dark Hover Color',
            'type'        => 'color',
            'variable'    => '--bs-navbar-dark-hover-color',
            'value'       => 'rgba(255, 255, 255, 0.75)',
            'css_rules'   => [
                '.navbar-dark .navbar-nav .nav-link:hover' => [
                    'color' => 'var(--bs-navbar-dark-hover-color)'
                ]
            ]
        ],
    ]
];