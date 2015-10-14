<?php

namespace Midnight\Form;

use Midnight\FormModule\View\Helper\FormElementFactory;

return [
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'formRow' => 'Midnight\FormModule\View\Helper\FormRow',
        ],
        'factories' => [
            'formElement' => FormElementFactory::class,
        ],
    ],
    'midnight' => [
        'form_module' => [
            'element_view_helpers' => [],
        ],
    ],
];
