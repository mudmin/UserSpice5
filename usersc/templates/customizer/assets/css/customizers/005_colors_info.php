<?php
// Info color customization options

return [
    'colors_info' => [
        'info' => [
            'label'       => 'Info Color',
            'type'        => 'color',
            'variable'    => '--bs-info',
            'value'       => '#0dcaf0',
            'generates_rgb' => true,
            'css_rules'   => [
                '.bg-info'   => [
                    'background-color' => 'var(--bs-info) !important'
                ],
                '.text-info' => [
                    'color' => 'var(--bs-info) !important'
                ],
                '.border-info' => [
                    'border-color' => 'var(--bs-info) !important'
                ]
            ]
        ],
        'info_hover' => [
            'label'       => 'Info Hover Color',
            'description' => 'Hover state for info buttons',
            'type'        => 'color',
            'variable'    => '--bs-info-hover',
            'value'       => '#31d2f2'
        ],
        'info_text_emphasis' => [
            'label'    => 'Info Alert Text Emphasis',
            'type'     => 'color',
            'variable' => '--bs-info-text-emphasis',
            'value'    => '#055160'
        ],
        'info_bg_subtle' => [
            'label'    => 'Info Alert Background (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-info-bg-subtle',
            'value'    => '#cff4fc'
        ],
        'info_border_subtle' => [
            'label'    => 'Info Alert Border (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-info-border-subtle',
            'value'    => '#b6effb'
        ],
    ]
];