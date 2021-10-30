<?php

declare(strict_types=1);

namespace Midnight\FormModule\View\Helper;

use Laminas\Form\View\Helper\FormElement;
use Psr\Container\ContainerInterface;

class FormElementFactory
{
    public function __invoke(ContainerInterface $container): FormElement
    {
        $formElement = new FormElement();
        $this->injectHelpers($formElement, $container);
        return $formElement;
    }

    private function injectHelpers(FormElement $formElement, ContainerInterface $container): void
    {
        $config = $this->getConfig($container);
        foreach ($config as $className => $helper) {
            $formElement->addClass($className, $helper);
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function getConfig(ContainerInterface $container): array
    {
        return $container->get('config')['midnight']['form_module']['element_view_helpers'];
    }
}
