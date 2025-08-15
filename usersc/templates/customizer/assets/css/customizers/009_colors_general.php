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
    ]
];
