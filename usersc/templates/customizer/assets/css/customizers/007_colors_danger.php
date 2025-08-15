<?php
// Danger color customization options

return [
    'colors_danger' => [
        'danger' => [
            'label'       => 'Danger Color',
            'type'        => 'color',
            'variable'    => '--bs-danger',
            'value'       => '#dc3545',
            'generates_rgb' => true,
            'css_rules'   => [
                '.bg-danger'   => [
                    'background-color' => 'var(--bs-danger) !important'
                ],
                '.text-danger' => [
                    'color' => 'var(--bs-danger) !important'
                ],
                '.border-danger' => [
                    'border-color' => 'var(--bs-danger) !important'
                ]
            ]
        ],
        'danger_hover' => [
            'label'       => 'Danger Hover Color',
            'description' => 'Hover state for danger buttons',
            'type'        => 'color',
            'variable'    => '--bs-danger-hover',
            'value'       => '#bb2d3b'
        ],
        'danger_text_emphasis' => [
            'label'    => 'Danger Alert Text Emphasis',
            'type'     => 'color',
            'variable' => '--bs-danger-text-emphasis',
            'value'    => '#842029'
        ],
        'danger_bg_subtle' => [
            'label'    => 'Danger Alert Background (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-danger-bg-subtle',
            'value'    => '#f8d7da'
        ],
        'danger_border_subtle' => [
            'label'    => 'Danger Alert Border (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-danger-border-subtle',
            'value'    => '#f5c2c7'
        ],
    ]
];