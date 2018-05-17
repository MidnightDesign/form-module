<?php declare(strict_types=1);

namespace Midnight\FormModule\View\Helper;

use Psr\Container\ContainerInterface;
use Zend\Form\View\Helper\FormElement;
use Zend\ServiceManager\AbstractPluginManager;

class FormElementFactory
{
    public function __invoke(ContainerInterface $container): FormElement
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
        if ($container instanceof AbstractPluginManager) {
            return $this->getConfig($container->getServiceLocator());
        }
        return $container->get('Config')['midnight']['form_module']['element_view_helpers'];
    }
}
