<?php

declare(strict_types=1);

namespace Midnight\Form;

use Laminas\Form\View\Helper\FormElement;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Midnight\FormModule\View\Helper\FormElementFactory;
use Midnight\FormModule\View\Helper\FormRow;

return [
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'formElement' => FormElement::class,
            'formRow' => FormRow::class,
        ],
        'factories' => [
            FormElement::class => FormElementFactory::class,
            FormRow::class => InvokableFactory::class,
        ],
    ],
    'midnight' => [
        'form_module' => [
            'element_view_helpers' => [],
        ],
    ],
];
