<?php
// Secondary color customization options

return [
    'colors_secondary' => [
        'secondary' => [
            'label'       => 'Secondary Color',
            'type'        => 'color',
            'variable'    => '--bs-secondary',
            'value'       => '#6c757d',
            'generates_rgb' => true,
            'css_rules'   => [
                '.bg-secondary'   => [
                    'background-color' => 'var(--bs-secondary) !important'
                ],
                '.text-secondary' => [
                    'color' => 'var(--bs-secondary) !important'
                ],
                '.border-secondary' => [
                    'border-color' => 'var(--bs-secondary) !important'
                ]
            ]
        ],
        'secondary_hover' => [
            'label'       => 'Secondary Hover Color',
            'description' => 'Hover state for secondary buttons',
            'type'        => 'color',
            'variable'    => '--bs-secondary-hover',
            'value'       => '#5c636a'
        ],
        'secondary_text_emphasis' => [
            'label'    => 'Secondary Alert Text Emphasis',
            'type'     => 'color',
            'variable' => '--bs-secondary-text-emphasis',
            'value'    => '#41464b'
        ],
        'secondary_bg_subtle' => [
            'label'    => 'Secondary Alert Background (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-secondary-bg-subtle',
            'value'    => '#e2e3e5'
        ],
        'secondary_border_subtle' => [
            'label'    => 'Secondary Alert Border (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-secondary-border-subtle',
            'value'    => '#d3d4d5'
        ],
    ]
];