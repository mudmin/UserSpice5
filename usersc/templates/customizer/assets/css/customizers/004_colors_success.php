<?php
// Success color customization options

return [
    'colors_success' => [
        'success' => [
            'label'       => 'Success Color',
            'type'        => 'color',
            'variable'    => '--bs-success',
            'value'       => '#198754',
            'generates_rgb' => true,
            'css_rules'   => [
                '.bg-success'   => [
                    'background-color' => 'var(--bs-success) !important'
                ],
                '.text-success' => [
                    'color' => 'var(--bs-success) !important'
                ],
                '.border-success' => [
                    'border-color' => 'var(--bs-success) !important'
                ]
            ]
        ],
        'success_hover' => [
            'label'       => 'Success Hover Color',
            'description' => 'Hover state for success buttons',
            'type'        => 'color',
            'variable'    => '--bs-success-hover',
            'value'       => '#157347'
        ],
        'success_text_emphasis' => [
            'label'    => 'Success Alert Text Emphasis',
            'type'     => 'color',
            'variable' => '--bs-success-text-emphasis',
            'value'    => '#0f5132'
        ],
        'success_bg_subtle' => [
            'label'    => 'Success Alert Background (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-success-bg-subtle',
            'value'    => '#d1e7dd'
        ],
        'success_border_subtle' => [
            'label'    => 'Success Alert Border (Subtle)',
            'type'     => 'color',
            'variable' => '--bs-success-border-subtle',
            'value'    => '#badbcc'
        ],
    ]
];