<?php

declare(strict_types=1);

namespace Midnight\FormModule\View\Helper;

use Laminas\Form\View\Helper\FormElement;
use Laminas\ServiceManager\AbstractPluginManager;
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
     * @return mixed[]
     */
    private function getConfig(ContainerInterface $container): array
    {
        if ($container instanceof AbstractPluginManager) {
            return $this->getConfig($container->getServiceLocator());
        }
        return $container->get('Config')['midnight']['form_module']['element_view_helpers'];
    }
}
