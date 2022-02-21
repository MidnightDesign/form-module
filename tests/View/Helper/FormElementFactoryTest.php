<?php

declare(strict_types=1);

namespace MidnightTest\FormModule\View\Helper;

use Laminas\Form\View\Helper\FormElement;
use Laminas\ServiceManager\ServiceManager;
use Midnight\FormModule\View\Helper\FormElementFactory;
use MidnightTest\FormModule\AbstractTestCase;
use ReflectionObject;

use function array_merge;

class FormElementFactoryTest extends AbstractTestCase
{
    private FormElementFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new FormElementFactory();
    }

    public function testCreate(): void
    {
        $formElement = ($this->factory)($this->createServiceManager());

        /** @phpstan-ignore-next-line smoke test */
        self::assertInstanceOf(FormElement::class, $formElement);
    }

    public function testViewHelperIsInjected(): void
    {
        $sm = $this->createServiceManager();
        $this->injectDummyElement($sm);

        $formElement = ($this->factory)($sm);

        $classMap = $this->getProperty($formElement, 'classMap');
        self::assertIsArray($classMap);
        self::assertArrayHasKey(DummyElement::class, $classMap);
    }

    private function injectDummyElement(ServiceManager $serviceManager): void
    {
        $serviceManager->setAllowOverride(true);
        /** @var array<string, mixed> $config */
        $config = $serviceManager->get('config');
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
        $serviceManager->setService('config', $config);
    }

    /**
     * @return mixed
     */
    private function getProperty(object $object, string $property)
    {
        $reflectionObject = new ReflectionObject($object);
        $reflectionProperty = $reflectionObject->getProperty($property);
        $reflectionProperty->setAccessible(true);
        $value = $reflectionProperty->getValue($object);
        $reflectionProperty->setAccessible(false);
        return $value;
    }
}
