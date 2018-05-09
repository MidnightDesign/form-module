<?php

namespace Midnight\FormModule\View\Helper;

use Psr\Container\ContainerInterface;
use Zend\Form\View\Helper\FormElement;

class FormElementFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): FormElement
    {
        $formElement = new FormElement();
        $this->injectHelpers($formElement, $container);
        return $formElement;
    }

    private function injectHelpers(FormElement $formElement, ContainerInterface $container)
    {
        $config = $this->getConfig($container);
        foreach ($config as $className => $helper) {
            $formElement->addClass($className, $helper);
        }
    }

    private function getConfig(ContainerInterface $container): array
    {
        return $container->get('Config')['midnight']['form_module']['element_view_helpers'];
    }
}
