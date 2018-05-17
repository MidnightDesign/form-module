<?php declare(strict_types=1);

namespace MidnightTest\FormModule\View\Helper;

use Midnight\FormModule\View\Helper\FormElementFactory;
use MidnightTest\FormModule\AbstractTestCase;
use ReflectionObject;
use Zend\Form\View\Helper\FormElement;
use Zend\ServiceManager\ServiceManager;

class FormElementFactoryTest extends AbstractTestCase
{
    /** @var FormElementFactory */
    private $factory;

    public function setUp()
    {
        parent::setUp();
        $this->factory = new FormElementFactory();
    }

    public function testCreate()
    {
        $formElement = ($this->factory)($this->createServiceManager());

        $this->assertInstanceOf(FormElement::class, $formElement);
    }

    public function testViewHelperIsInjected()
    {
        $sm = $this->createServiceManager();
        $this->injectDummyElement($sm);

        /** @var FormElement $formElement */
        $formElement = ($this->factory)($sm);

        $classMap = $this->getProperty($formElement, 'classMap');
        $this->assertArrayHasKey(DummyElement::class, $classMap);
    }

    private function injectDummyElement(ServiceManager $serviceManager)
    {
        $serviceManager->setAllowOverride(true);
        $config = $serviceManager->get('Config');
        $config = array_merge(
            $config,
            [
                'midnight' => [
                    'form_module' => [
                        'element_view_helpers' => [
                            DummyElement::class => 'forminput',
                        ],
                    ],
                ],
            ]
        );
        $serviceManager->setService('Config', $config);
    }

    private function getProperty($object, string $property)
    {
        $reflectionObject = new ReflectionObject($object);
        $reflectionProperty = $reflectionObject->getProperty($property);
        $reflectionProperty->setAccessible(true);
        $value = $reflectionProperty->getValue($object);
        $reflectionProperty->setAccessible(false);
        return $value;
    }
}
