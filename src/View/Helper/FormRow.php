<?php

namespace Midnight\FormModule\View\Helper;

use Zend\Form\View\Helper\FormRow as ZendFormRow;

class FormRow extends ZendFormRow
{
    public function __construct()
    {
        $this->setPartial('midnight/form-module/form-row.phtml');
    }
}
