<?php

namespace Midnight\FormModule\View\Helper;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Form\View\Helper\FormElement;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class FormElementFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
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

    /**
     * @param ContainerInterface $container
     * @return array
     */
    private function getConfig(ContainerInterface $container)
    {
        return $container->get('Config')['midnight']['form_module']['element_view_helpers'];
    }
}
