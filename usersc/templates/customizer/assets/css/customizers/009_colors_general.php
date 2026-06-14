<?php
// General color customization options

return [
    'colors_general' => [
        'body_color' => [
            'label'       => 'Body Text Color',
            'type'        => 'color',
            'variable'    => '--bs-body-color',
            'value'       => '#212529',
            'css_rules'   => [
                'body' => [
                    'color' => 'var(--bs-body-color)'
                ]
            ]
        ],
        'body_bg' => [
            'label'       => 'Body Background',
            'type'        => 'color',
            'variable'    => '--bs-body-bg',
            'value'       => '#ffffff',
            'css_rules'   => [
                'body' => [
                    'background-color' => 'var(--bs-body-bg)'
                ]
            ]
        ],
        'border_color' => [
            'label'    => 'Border Color',
            'type'     => 'color',
            'variable' => '--bs-border-color',
            'value'    => '#dee2e6'
        ],
        'form_control_bg' => [
            'label'       => 'Form Control Background',
            'type'        => 'color',
            'variable'    => '--bs-form-control-bg',
            'value'       => '#ffffff',
            'css_rules'   => [
                '.form-control, .form-select, input.form-control, select.form-select, textarea.form-control' => [
                    'background-color' => 'var(--bs-form-control-bg, var(--bs-body-bg)) !important'
                ],
                '.form-check-input:not(:checked)' => [
                    'background-color' => 'var(--bs-form-control-bg, var(--bs-body-bg)) !important'
                ]
            ]
        ],
        // Bootstrap 5.3 theme-aware text & surface colors. These drive .text-muted,
        // .text-secondary, subtle backgrounds, etc. Bootstrap leaves them at light-mode
        // defaults, so dark themes MUST override them or muted text becomes invisible.
        'secondary_color' => [
            'label'       => 'Muted Text Color',
            'description' => 'Color of .text-muted and .text-secondary text. On dark themes set this to a light gray or muted text disappears against the background.',
            'type'        => 'color',
            'variable'    => '--bs-secondary-color',
            'value'       => '#5e646b',
        ],
        'tertiary_color' => [
            'label'       => 'Faint Text Color',
            'description' => 'Color for the faintest text — placeholders and disabled hints.',
            'type'        => 'color',
            'variable'    => '--bs-tertiary-color',
            'value'       => '#9aa0a6',
        ],
        'emphasis_color' => [
            'label'       => 'Emphasis Text Color',
            'description' => 'High-contrast text color used by .text-emphasis. Usually black on light themes, white on dark.',
            'type'        => 'color',
            'variable'    => '--bs-emphasis-color',
            'value'       => '#000000',
        ],
        'secondary_bg' => [
            'label'       => 'Secondary Surface',
            'description' => 'Background for secondary surfaces — .bg-body-secondary and default table stripes.',
            'type'        => 'color',
            'variable'    => '--bs-secondary-bg',
            'value'       => '#e9ecef',
        ],
        'tertiary_bg' => [
            'label'       => 'Tertiary Surface',
            'description' => 'Background for the faintest surfaces — .bg-body-tertiary.',
            'type'        => 'color',
            'variable'    => '--bs-tertiary-bg',
            'value'       => '#f8f9fa',
        ],
    ]
];
