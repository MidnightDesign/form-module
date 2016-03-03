<?php

namespace MidnightTest\FormModule\View\Helper;

use Midnight\FormModule\Module;
use Midnight\FormModule\View\Helper\FormElementFactory;
use PHPUnit_Framework_TestCase;
use Zend\Form\View\Helper\FormElement;
use Zend\ServiceManager\ServiceManager;

class FormElementFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $factory = new FormElementFactory();
        $formElement = $factory->__invoke($this->createServiceManager(), 'formElement');

        $this->assertInstanceOf(FormElement::class, $formElement);
    }

    /**
     * @return ServiceManager
     */
    private function createServiceManager()
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('Config', (new Module)->getConfig());
        return $serviceManager;
    }
}
