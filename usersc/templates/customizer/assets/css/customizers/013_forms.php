<?php
// Forms customization options

return [
    'forms' => [
        'input_bg' => [
            'label'       => 'Input Background',
            'type'        => 'var-reference',
            'variable'    => '--bs-input-bg',
            'value'       => 'var(--bs-body-bg)',
            'options'     => [
                'var(--bs-body-bg)' => 'Default Background',
                'var(--bs-light)'   => 'Light',
                'transparent'      => 'Transparent'
            ],
            'css_rules'   => [
                '.form-control, .form-select' => [
                    'background-color' => 'var(--bs-input-bg, var(--bs-body-bg)) !important'
                ],
                '.form-check-input:not(:checked)' => [
                    'background-color' => 'var(--bs-input-bg, var(--bs-body-bg)) !important'
                ]
            ]
        ],
        'input_color' => [
            'label'       => 'Input Text Color',
            'type'        => 'var-reference',
            'variable'    => '--bs-input-color',
            'value'       => 'var(--bs-body-color)',
            'options'     => [
                'var(--bs-body-color)' => 'Default Text',
                'var(--bs-dark)'       => 'Dark',
                'var(--bs-primary)'    => 'Primary'
            ],
            'css_rules'   => [
                '.form-control' => [
                    'color' => 'var(--bs-input-color, var(--bs-body-color))'
                ]
            ]
        ],
        'input_border_color' => [
            'label'       => 'Input Border Color',
            'type'        => 'var-reference',
            'variable'    => '--bs-input-border-color',
            'value'       => 'var(--bs-border-color)',
            'options'     => [
                'var(--bs-border-color)' => 'Default Border',
                'var(--bs-primary)'      => 'Primary',
                'var(--bs-secondary)'    => 'Secondary'
            ],
            'css_rules'   => [
                '.form-control, .form-select, .form-check-input' => [
                    'border-color' => 'var(--bs-input-border-color, var(--bs-border-color))'
                ]
            ]
        ],
        'input_focus_border_color' => [
            'label'       => 'Input Focus Border Color',
            'type'        => 'var-reference',
            'variable'    => '--bs-input-focus-border-color',
            'value'       => 'var(--bs-primary)',
            'options'     => [
                'var(--bs-primary)'   => 'Primary',
                'var(--bs-secondary)' => 'Secondary',
                'var(--bs-info)'      => 'Info'
            ],
            'css_rules'   => [
                '.form-control:focus, .form-select:focus, .form-check-input:focus' => [
                    'border-color' => 'var(--bs-input-focus-border-color)'
                ]
            ]
        ],
        'input_focus_box_shadow' => [
            'label'       => 'Input Focus Box Shadow',
            'type'        => 'shadow',
            'variable'    => '--bs-input-focus-box-shadow',
            'value'       => '0 0 0 0.25rem rgba(13, 110, 253, 0.25)',
            'css_rules'   => [
                '.form-control:focus, .form-select:focus, .form-check-input:focus' => [
                    'box-shadow' => 'var(--bs-input-focus-box-shadow)'
                ]
            ]
        ],
        'input_focus_bg' => [
            'label'       => 'Input Focus Background',
            'type'        => 'color',
            'variable'    => '--bs-input-focus-bg',
            'value'       => '#ffffff',
            'css_rules'   => [
                '.form-control:focus, .form-select:focus, .form-check-input:focus:not(:checked)' => [
                    'background-color' => 'var(--bs-input-focus-bg, var(--bs-form-control-bg)) !important'
                ],
                '.form-check-input:checked:focus' => [
                    'background-color' => 'var(--bs-primary) !important'
                ]
            ]
        ],
        'input_focus_color' => [
            'label'       => 'Input Focus Text Color',
            'type'        => 'color',
            'variable'    => '--bs-input-focus-color',
            'value'       => '#212529',
            'css_rules'   => [
                '.form-control:focus' => [
                    'color' => 'var(--bs-input-focus-color, var(--bs-body-color))'
                ]
            ]
        ],
    ]
];