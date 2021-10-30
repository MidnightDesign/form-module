<?php

declare(strict_types=1);

namespace MidnightTest\FormModule;

use Laminas\Form\View\Helper\FormElement;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\View\HelperPluginManager;
use Midnight\FormModule\Module;
use Midnight\FormModule\View\Helper\FormElementFactory;
use Midnight\FormModule\View\Helper\FormRow;

use function realpath;

class ModuleTest extends AbstractTestCase
{
    public function testConfig(): void
    {
        $module = new Module();

        $config = $module->getConfig();

        self::assertSame(realpath(__DIR__ . '/../view'), realpath($config['view_manager']['template_path_stack'][0]));
        $viewHelpersConfig = $config['view_helpers'];
        self::assertSame(FormElement::class, $viewHelpersConfig['aliases']['formElement']);
        self::assertSame(FormRow::class, $viewHelpersConfig['aliases']['formRow']);
        self::assertSame(FormElementFactory::class, $viewHelpersConfig['factories'][FormElement::class]);
        self::assertSame(InvokableFactory::class, $viewHelpersConfig['factories'][FormRow::class]);
        $elementViewHelpersConfig = $config['midnight']['form_module']['element_view_helpers'];
        self::assertIsArray($elementViewHelpersConfig);
        self::assertCount(0, $elementViewHelpersConfig);
    }

    /**
     * @psalm-param class-string<object> $expected
     * @dataProvider helpersDataProvider
     */
    public function testViewHelpersAreRegisteredCorrectly(string $requested, string $expected): void
    {
        $helperManager = $this->createHelperPluginManager();

        $helper = $helperManager->get($requested);

        self::assertInstanceOf($expected, $helper);
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function helpersDataProvider(): array
    {
        return [
            [FormElement::class, FormElement::class],
            [FormRow::class, FormRow::class],
            ['formElement', FormElement::class],
            ['formRow', FormRow::class],
        ];
    }

    private function createHelperPluginManager(): HelperPluginManager
    {
        $sm = $this->createServiceManager();
        $pluginManager = new HelperPluginManager($sm);
        $config = $sm->get('config');
        foreach ($config['view_helpers']['factories'] as $helper => $factory) {
            $pluginManager->setFactory($helper, $factory);
        }
        foreach ($config['view_helpers']['aliases'] as $alias => $target) {
            $pluginManager->setAlias($alias, $target);
        }
        return $pluginManager;
    }
}
