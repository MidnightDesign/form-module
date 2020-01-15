<?php

declare(strict_types=1);

namespace Midnight\FormModule\View\Helper;

use Laminas\Form\View\Helper\FormRow as LaminasFormRow;

class FormRow extends LaminasFormRow
{
    public function __construct()
    {
        $this->setPartial('midnight/form-module/form-row.phtml');
    }
}
