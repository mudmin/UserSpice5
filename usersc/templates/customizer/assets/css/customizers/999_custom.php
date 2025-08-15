<?php
// Custom CSS options

return [
    'custom_css' => [
        'custom_css_code' => [
            'label'       => 'Custom CSS Code',
            'description' => 'Add your own custom CSS that will be appended to the end of the stylesheet. This is ideal for small snippets of CSS. For more complicated things, you may want to consider adding a template_name.css file to the usersc/templates folder.',
            'type'        => 'textarea',
            'variable'    => '--bs-custom-css',
            'value'       => '',
            'is_raw_css'  => true
        ],
    ] 
];