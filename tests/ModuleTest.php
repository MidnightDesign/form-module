<?php declare(strict_types=1);

namespace MidnightTest\FormModule;

use Midnight\FormModule\Module;
use Midnight\FormModule\View\Helper\FormElementFactory;
use Midnight\FormModule\View\Helper\FormRow;
use Zend\Form\View\Helper\FormElement;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\View\HelperPluginManager;

class ModuleTest extends AbstractTestCase
{
    public function testConfig()
    {
        $module = new Module();

        $config = $module->getConfig();

        $this->assertSame(realpath(__DIR__ . '/../view'), realpath($config['view_manager']['template_path_stack'][0]));
        $viewHelpersConfig = $config['view_helpers'];
        $this->assertSame(FormElement::class, $viewHelpersConfig['aliases']['formElement']);
        $this->assertSame(FormRow::class, $viewHelpersConfig['aliases']['formRow']);
        $this->assertSame(FormElementFactory::class, $viewHelpersConfig['factories'][FormElement::class]);
        $this->assertSame(InvokableFactory::class, $viewHelpersConfig['factories'][FormRow::class]);
        $elementViewHelpersConfig = $config['midnight']['form_module']['element_view_helpers'];
        $this->assertInternalType('array', $elementViewHelpersConfig);
        $this->assertCount(0, $elementViewHelpersConfig);
    }

    /**
     * @dataProvider helpersDataProvider
     */
    public function testViewHelpersAreRegisteredCorrectly($requested, $expected)
    {
        $helperManager = $this->createHelperPluginManager();

        $helper = $helperManager->get($requested);

        $this->assertInstanceOf($expected, $helper);
    }

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
        $config = $sm->get('Config');
        foreach ($config['view_helpers']['factories'] as $helper => $factory) {
            $pluginManager->setFactory($helper, $factory);
        }
        foreach ($config['view_helpers']['aliases'] as $alias => $target) {
            $pluginManager->setAlias($alias, $target);
        }
        return $pluginManager;
    }
}
