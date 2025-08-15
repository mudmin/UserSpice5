<?php
// Primary color customization options

return [
    'colors_primary' => [
        'primary' => [
            'label'       => 'Primary Color',
            'description' => 'Main brand color',
            'type'        => 'color',
            'variable'    => '--bs-primary',
            'value'       => '#0d6efd',
            'generates_rgb' => true,
            'css_rules'   => [
                '.bg-primary'   => [
                    'background-color' => 'var(--bs-primary) !important'
                ],
                '.text-primary' => [
                    'color' => 'var(--bs-primary) !important'
                ],
                '.border-primary' => [
                    'border-color' => 'var(--bs-primary) !important'
                ]
            ]
        ],
        'primary_hover' => [
            'label'       => 'Primary Hover Color',
            'description' => 'Hover state for primary buttons',
            'type'        => 'color',
            'variable'    => '--bs-primary-hover',
            'value'       => '#0b5ed7'
        ],
        'primary_text_emphasis' => [
            'label'    => 'Primary Alert Text Emphasis',
            'type'     => 'color',
            'variable' => '--bs-primary-text-emphasis',
            'value'    => '#084298'
        ],
        'primary_bg_subtle' => [
            'label'    => 'Primary Alert Background (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-primary-bg-subtle',
            'value'    => '#cfe2ff'
        ],
        'primary_border_subtle' => [
            'label'    => 'Primary Alert Border (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-primary-border-subtle',
            'value'    => '#b6d4fe'
        ],
    ]
];