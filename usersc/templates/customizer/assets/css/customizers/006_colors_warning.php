<?php
// Warning color customization options

return [
    'colors_warning' => [
        'warning' => [
            'label'       => 'Warning Color',
            'type'        => 'color',
            'variable'    => '--bs-warning',
            'value'       => '#ffc107',
            'generates_rgb' => true,
            'css_rules'   => [
                '.bg-warning'   => [
                    'background-color' => 'var(--bs-warning) !important'
                ],
                '.text-warning' => [
                    'color' => 'var(--bs-warning) !important'
                ],
                '.border-warning' => [
                    'border-color' => 'var(--bs-warning) !important'
                ]
            ]
        ],
        'warning_hover' => [
            'label'       => 'Warning Hover Color',
            'description' => 'Hover state for warning buttons',
            'type'        => 'color',
            'variable'    => '--bs-warning-hover',
            'value'       => '#ffca2c'
        ],
        'warning_text_emphasis' => [
            'label'    => 'Warning Alert Text Emphasis',
            'type'     => 'color',
            'variable' => '--bs-warning-text-emphasis',
            'value'    => '#664d03'
        ],
        'warning_bg_subtle' => [
            'label'    => 'Warning Alert Background (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-warning-bg-subtle',
            'value'    => '#fff3cd'
        ],
        'warning_border_subtle' => [
            'label'    => 'Warning Alert Border (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-warning-border-subtle',
            'value'    => '#ffecb5'
        ],
    ]
];