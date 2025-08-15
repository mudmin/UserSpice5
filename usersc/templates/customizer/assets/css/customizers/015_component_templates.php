<?php
// Component templates and custom CSS options

return [
    'component_templates' => [
        // Templates for generating component styles
        'buttons' => [
            'colors' => ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'light', 'dark'],
            'templates' => [
                'regular' => [
                    'selector' => '.btn-{color}',
                    'properties' => [
                        '--bs-btn-color' => '{text_color}',
                        '--bs-btn-bg' => 'var(--bs-{color})',
                        '--bs-btn-border-color' => 'var(--bs-{color})',
                        '--bs-btn-hover-color' => '{text_color}',
                        '--bs-btn-hover-bg' => 'var(--bs-{color}-hover, {hover_fallback})',
                        '--bs-btn-hover-border-color' => 'var(--bs-{color}-hover, var(--bs-{color}))',
                        '--bs-btn-focus-shadow-rgb' => 'var(--bs-{color}-rgb)',
                        '--bs-btn-active-color' => '{text_color}',
                        '--bs-btn-active-bg' => 'var(--bs-{color}-hover, var(--bs-{color}))',
                        '--bs-btn-active-border-color' => 'var(--bs-{color}-hover, var(--bs-{color}))'
                    ],
                    'values' => [
                        'text_color' => [
                            'light' => 'var(--bs-dark)',
                            'default' => '#fff'
                        ],
                        'hover_fallback' => [
                            'light' => '#d3d4d5',
                            'default' => 'var(--bs-{color})'
                        ]
                    ]
                ],
                'outline' => [
                    'selector' => '.btn-outline-{color}',
                    'properties' => [
                        '--bs-btn-color' => 'var(--bs-{color})',
                        '--bs-btn-border-color' => 'var(--bs-{color})',
                        '--bs-btn-hover-color' => '{text_color}',
                        '--bs-btn-hover-bg' => 'var(--bs-{color}-hover, var(--bs-{color}))',
                        '--bs-btn-hover-border-color' => 'var(--bs-{color}-hover, var(--bs-{color}))',
                        '--bs-btn-focus-shadow-rgb' => 'var(--bs-{color}-rgb)',
                        '--bs-btn-active-color' => '{text_color}',
                        '--bs-btn-active-bg' => 'var(--bs-{color}-hover, var(--bs-{color}))',
                        '--bs-btn-active-border-color' => 'var(--bs-{color}-hover, var(--bs-{color}))'
                    ],
                    'values' => [
                        'text_color' => [
                            'light' => 'var(--bs-dark)',
                            'default' => '#fff'
                        ]
                    ]
                ]
            ]
        ],
        'alerts' => [
            'colors' => ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'light', 'dark'],
            'templates' => [
                'alert' => [
                    'selector' => '.alert-{color}',
                    'properties' => [
                        '--bs-alert-color'        => 'var(--bs-{color}-text-emphasis, var(--bs-{color}))',
                        '--bs-alert-bg'           => 'var(--bs-{color}-bg-subtle, rgba(var(--bs-{color}-rgb), 0.1))',
                        '--bs-alert-border-color' => 'var(--bs-{color}-border-subtle, rgba(var(--bs-{color}-rgb), 0.2))',
                        '--bs-alert-link-color'   => 'var(--bs-{color}-text-emphasis, var(--bs-{color}))'
                    ]
                ]
            ]
        ],
        'badges' => [
            'colors' => ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'light', 'dark'],
            'templates' => [
                'badge' => [
                    'selector' => '.badge.bg-{color}',
                    'properties' => [
                        'background-color' => 'var(--bs-{color}) !important',
                        'color' => '{text_color} !important'
                    ],
                    'values' => [
                        'text_color' => [
                            'light' => 'var(--bs-dark)',
                            'default' => '#fff'
                        ]
                    ]
                ]
            ]
        ],
        'list_groups' => [
            'colors' => ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'light', 'dark'],
            'templates' => [
                'item' => [
                    'selector' => '.list-group-item-{color}',
                    'properties' => [
                        'color' => 'var(--bs-{color})',
                        'background-color' => 'rgba(var(--bs-{color}-rgb), 0.1)'
                    ]
                ],
                'item_action' => [
                    'selector' => '.list-group-item-{color}.list-group-item-action:hover, .list-group-item-{color}.list-group-item-action:focus',
                    'properties' => [
                        'color' => 'var(--bs-{color})',
                        'background-color' => 'rgba(var(--bs-{color}-rgb), 0.2)'
                    ]
                ]
            ]
        ],
        'backgrounds' => [
            'colors' => ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'light', 'dark'],
            'templates' => [
                'bg' => [
                    'selector' => '.bg-{color}',
                    'properties' => [
                        'background-color' => 'var(--bs-{color}) !important'
                    ]
                ],
                'bg_subtle' => [
                    'selector' => '.bg-{color}-subtle',
                    'properties' => [
                        'background-color' => 'rgba(var(--bs-{color}-rgb), 0.1) !important'
                    ]
                ],
                'card_header' => [
                    'selector' => '.bg-{color}.card, .card.border-{color} .card-header',
                    'properties' => [
                        'background-color' => 'var(--bs-{color}) !important',
                        'color' => '{text_color}'
                    ],
                    'values' => [
                        'text_color' => [
                            'light' => 'var(--bs-dark)',
                            'default' => '#fff'
                        ]
                    ]
                ],
                'navbar' => [
                    'selector' => '.navbar.bg-{color}',
                    'properties' => [
                        'background-color' => 'var(--bs-{color}) !important',
                        'color' => '{text_color}'
                    ],
                    'values' => [
                        'text_color' => [
                            'light' => 'var(--bs-dark)',
                            'default' => '#fff'
                        ]
                    ]
                ]
            ]
        ]
    ]
];