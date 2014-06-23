<?php

namespace Midnight\Form\View\Helper;

use Zend\Form\View\Helper\FormRow as ZendFormRow;

class FormRow extends ZendFormRow
{
    public function __construct()
    {
        $this->setPartial('midnight/form/form-row.phtml');
    }
}
