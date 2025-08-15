<?php
// Card customization options

return [
    'cards' => [
        'card_border_radius' => [
            'label'       => 'Card Border Radius',
            'type'        => 'var-reference',
            'variable'    => '--bs-card-border-radius',
            'value'       => 'var(--bs-border-radius)',
            'options'     => [
                'var(--bs-border-radius)'   => 'Default',
                'var(--bs-border-radius-sm)' => 'Small',
                'var(--bs-border-radius-lg)' => 'Large',
                'var(--bs-border-radius-xl)' => 'Extra Large',
                '0'                         => 'None'
            ],
            'css_rules'   => [
                '.card' => [
                    'border-radius' => 'var(--bs-card-border-radius)'
                ]
            ]
        ],
        'card_border_color' => [
            'label'       => 'Card Border Color',
            'type'        => 'var-reference',
            'variable'    => '--bs-card-border-color',
            'value'       => 'var(--bs-border-color)',
            'options'     => [
                'var(--bs-border-color)' => 'Default Border',
                'var(--bs-primary)'      => 'Primary',
                'var(--bs-secondary)'    => 'Secondary',
                'transparent'           => 'Transparent'
            ],
            'css_rules'   => [
                '.card' => [
                    'border-color' => 'var(--bs-card-border-color)'
                ]
            ]
        ],
        'card_box_shadow' => [
            'label'       => 'Card Box Shadow',
            'type'        => 'var-reference',
            'variable'    => '--bs-card-box-shadow',
            'value'       => 'none',
            'options'     => [
                'none'                   => 'None',
                'var(--bs-box-shadow-sm)' => 'Small',
                'var(--bs-box-shadow)'   => 'Regular',
                'var(--bs-box-shadow-lg)' => 'Large'
            ],
            'css_rules'   => [
                '.card' => [
                    'box-shadow' => 'var(--bs-card-box-shadow)'
                ]
            ]
        ],
        'card_cap_bg' => [
            'label'       => 'Card Header Background',
            'type'        => 'var-reference',
            'variable'    => '--bs-card-cap-bg',
            'value'       => 'rgba(0, 0, 0, 0.03)',
            'options'     => [
                'rgba(0, 0, 0, 0.03)' => 'Default',
                'var(--bs-light)'     => 'Light',
                'transparent'        => 'Transparent'
            ],
            'css_rules'   => [
                '.card-header' => [
                    'background-color' => 'var(--bs-card-cap-bg)'
                ]
            ]
        ],
    ]
];