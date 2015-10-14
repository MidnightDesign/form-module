<?php

namespace Midnight\FormModule\View\Helper;

use InvalidArgumentException;
use Zend\Form\View\Helper\FormElement;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\HelperPluginManager;

class FormElementFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return FormElement
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if (!$serviceLocator instanceof HelperPluginManager) {
            throw new InvalidArgumentException;
        }
        $sl = $serviceLocator->getServiceLocator();
        $formElement = new FormElement();
        $this->injectHelpers($formElement, $sl);
        return $formElement;
    }

    private function injectHelpers(FormElement $formElement, ServiceLocatorInterface $sl)
    {
        $config = $this->getConfig($sl);
        foreach ($config as $className => $helper) {
            $formElement->addClass($className, $helper);
        }
    }

    /**
     * @param ServiceLocatorInterface $sl
     * @return array
     */
    private function getConfig(ServiceLocatorInterface $sl)
    {
        return $sl->get('Config')['midnight']['form_module']['element_view_helpers'];
    }
}
