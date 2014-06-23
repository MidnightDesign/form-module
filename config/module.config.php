<?php

namespace Midnight\Form;

return array(
    'view_manager' => array(
        'template_path_stack' => array(
            dirname(__DIR__) . '/view',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'formRow' => 'Midnight\Form\View\Helper\FormRow',
        ),
    ),
);
