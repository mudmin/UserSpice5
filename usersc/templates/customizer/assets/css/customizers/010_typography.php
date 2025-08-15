<?php
// Typography customization options

return [
    'typography' => [
        'font_sans_serif' => [
            'label'       => 'Sans-Serif Font Family',
            'description' => 'Primary font family for the site',
            'type'        => 'font-family',
            'variable'    => '--bs-font-sans-serif',
            'value'       => 'system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
            'css_rules'   => [
                'body' => [
                    'font-family' => 'var(--bs-font-sans-serif)'
                ]
            ]
        ],
        'font_monospace' => [
            'label'       => 'Monospace Font Family',
            'type'        => 'font-family',
            'variable'    => '--bs-font-monospace',
            'value'       => 'SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace',
            'css_rules'   => [
                'code, pre, kbd, .font-monospace' => [
                    'font-family' => 'var(--bs-font-monospace)'
                ]
            ]
        ],
        'font_size_base' => [
            'label'       => 'Base Font Size',
            'description' => 'Default font size',
            'type'        => 'size',
            'variable'    => '--bs-font-size-base',
            'value'       => '1rem',
            'css_rules'   => [
                'body' => [
                    'font-size' => 'var(--bs-font-size-base, 1rem)'
                ]
            ]
        ],
        'font_weight_normal' => [
            'label'       => 'Normal Font Weight',
            'description' => 'Default font weight',
            'type'        => 'number',
            'variable'    => '--bs-font-weight-normal',
            'value'       => '400',
            'css_rules'   => [
                'body' => [
                    'font-weight' => 'var(--bs-font-weight-normal, 400)'
                ]
            ]
        ],
        'font_weight_bold' => [
            'label'       => 'Bold Font Weight',
            'type'        => 'number',
            'variable'    => '--bs-font-weight-bold',
            'value'       => '700',
            'css_rules'   => [
                'strong, b, .fw-bold' => [
                    'font-weight' => 'var(--bs-font-weight-bold, 700)'
                ]
            ]
        ],
        'line_height_base' => [
            'label'       => 'Base Line Height',
            'description' => 'Default line height',
            'type'        => 'number',
            'variable'    => '--bs-line-height-base',
            'value'       => '1.5',
            'css_rules'   => [
                'body' => [
                    'line-height' => 'var(--bs-line-height-base, 1.5)'
                ]
            ]
        ],
        'headings_font_family' => [
            'label'       => 'Headings Font Family',
            'description' => 'Font family for h1-h6 elements',
            'type'        => 'var-reference',
            'variable'    => '--bs-headings-font-family',
            'value'       => 'var(--bs-font-sans-serif)',
            'options'     => [
                'var(--bs-font-sans-serif)' => 'Use Sans-Serif Font',
                'inherit'                  => 'Inherit from Parent'
            ],
            'css_rules'   => [
                'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6' => [
                    'font-family' => 'var(--bs-headings-font-family, var(--bs-font-sans-serif))'
                ]
            ]
        ],
        'headings_font_weight' => [
            'label'       => 'Headings Font Weight',
            'type'        => 'number',
            'variable'    => '--bs-headings-font-weight',
            'value'       => '500',
            'css_rules'   => [
                'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6' => [
                    'font-weight' => 'var(--bs-headings-font-weight, 500)'
                ]
            ]
        ],
        'headings_line_height' => [
            'label'       => 'Headings Line Height',
            'type'        => 'number',
            'variable'    => '--bs-headings-line-height',
            'value'       => '1.2',
            'css_rules'   => [
                'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6' => [
                    'line-height' => 'var(--bs-headings-line-height, 1.2)'
                ]
            ]
        ],
        'headings_color' => [
            'label'       => 'Headings Color',
            'type'        => 'var-reference',
            'variable'    => '--bs-headings-color',
            'value'       => 'inherit',
            'options'     => [
                'inherit'            => 'Inherit from Body',
                'var(--bs-primary)'   => 'Primary Color',
                'var(--bs-secondary)' => 'Secondary Color',
                'var(--bs-dark)'      => 'Dark Color'
            ],
            'css_rules'   => [
                'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6' => [
                    'color' => 'var(--bs-headings-color, var(--bs-body-color))'
                ]
            ]
        ],
        'h1_font_size' => [
            'label'       => 'H1 Font Size',
            'type'        => 'size',
            'variable'    => '--bs-h1-font-size',
            'value'       => 'calc(1.375rem + 1.5vw)',
            'css_rules'   => [
                'h1, .h1' => [
                    'font-size' => 'var(--bs-h1-font-size, calc(1.375rem + 1.5vw))'
                ]
            ]
        ],
        'h2_font_size' => [
            'label'       => 'H2 Font Size',
            'type'        => 'size',
            'variable'    => '--bs-h2-font-size',
            'value'       => 'calc(1.325rem + 0.9vw)',
            'css_rules'   => [
                'h2, .h2' => [
                    'font-size' => 'var(--bs-h2-font-size, calc(1.325rem + 0.9vw))'
                ]
            ]
        ],
        'h3_font_size' => [
            'label'       => 'H3 Font Size',
            'type'        => 'size',
            'variable'    => '--bs-h3-font-size',
            'value'       => 'calc(1.3rem + 0.6vw)',
            'css_rules'   => [
                'h3, .h3' => [
                    'font-size' => 'var(--bs-h3-font-size, calc(1.3rem + 0.6vw))'
                ]
            ]
        ],
        'h4_font_size' => [
            'label'       => 'H4 Font Size',
            'type'        => 'size',
            'variable'    => '--bs-h4-font-size',
            'value'       => 'calc(1.275rem + 0.3vw)',
            'css_rules'   => [
                'h4, .h4' => [
                    'font-size' => 'var(--bs-h4-font-size, calc(1.275rem + 0.3vw))'
                ]
            ]
        ],
        'h5_font_size' => [
            'label'       => 'H5 Font Size',
            'type'        => 'size',
            'variable'    => '--bs-h5-font-size',
            'value'       => '1.25rem',
            'css_rules'   => [
                'h5, .h5' => [
                    'font-size' => 'var(--bs-h5-font-size, 1.25rem)'
                ]
            ]
        ],
        'h6_font_size' => [
            'label'       => 'H6 Font Size',
            'type'        => 'size',
            'variable'    => '--bs-h6-font-size',
            'value'       => '1rem',
            'css_rules'   => [
                'h6, .h6' => [
                    'font-size' => 'var(--bs-h6-font-size, 1rem)'
                ]
            ]
        ],
    ]
];