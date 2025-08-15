<?php
// Light and Dark color customization options

return [
    'colors_light_dark' => [
        'light' => [
            'label'       => 'Light Color',
            'type'        => 'color',
            'variable'    => '--bs-light',
            'value'       => '#f8f9fa',
            'generates_rgb' => true,
            'css_rules'   => [
                '.bg-light'   => [
                    'background-color' => 'var(--bs-light) !important'
                ],
                '.text-light' => [
                    'color' => 'var(--bs-light) !important'
                ],
                '.border-light' => [
                    'border-color' => 'var(--bs-light) !important'
                ]
            ]
        ],
        'light_hover' => [
            'label'       => 'Light Hover Color',
            'description' => 'Hover state for light buttons',
            'type'        => 'color',
            'variable'    => '--bs-light-hover',
            'value'       => '#d3d4d5'
        ],
        'light_text_emphasis' => [
            'label'    => 'Light Alert Text Emphasis',
            'type'     => 'color',
            'variable' => '--bs-light-text-emphasis',
            'value'    => '#636464'
        ],
        'light_bg_subtle' => [
            'label'    => 'Light Alert Background (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-light-bg-subtle',
            'value'    => '#fefefe'
        ],
        'light_border_subtle' => [
            'label'    => 'Light Alert Border (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-light-border-subtle',
            'value'    => '#fdfdfe'
        ],
        
        'dark' => [
            'label'       => 'Dark Color',
            'type'        => 'color',
            'variable'    => '--bs-dark',
            'value'       => '#212529',
            'generates_rgb' => true,
            'css_rules'   => [
                '.bg-dark'   => [
                    'background-color' => 'var(--bs-dark) !important'
                ],
                '.text-dark' => [
                    'color' => 'var(--bs-dark) !important'
                ],
                '.border-dark' => [
                    'border-color' => 'var(--bs-dark) !important'
                ]
            ]
        ],
        'dark_hover' => [
            'label'       => 'Dark Hover Color',
            'description' => 'Hover state for dark buttons',
            'type'        => 'color',
            'variable'    => '--bs-dark-hover',
            'value'       => '#1c1f23'
        ],
        'dark_text_emphasis' => [
            'label'    => 'Dark Alert Text Emphasis',
            'type'     => 'color',
            'variable' => '--bs-dark-text-emphasis',
            'value'    => '#141619'
        ],
        'dark_bg_subtle' => [
            'label'    => 'Dark Alert Background (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-dark-bg-subtle',
            'value'    => '#d3d3d4'
        ],
        'dark_border_subtle' => [
            'label'    => 'Dark Alert Border (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-dark-border-subtle',
            'value'    => '#bcbebf'
        ],
    ]
];