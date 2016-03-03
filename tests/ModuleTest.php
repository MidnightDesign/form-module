<?php

namespace MidnightTest\FormModule;

use Midnight\FormModule\Module;
use Midnight\FormModule\View\Helper\FormElementFactory;
use Midnight\FormModule\View\Helper\FormRow;
use PHPUnit_Framework_TestCase;

class ModuleTest extends PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        $module = new Module();

        $config = $module->getConfig();

        $this->assertSame(realpath(__DIR__ . '/../view'), realpath($config['view_manager']['template_path_stack'][0]));
        $viewHelpersConfig = $config['view_helpers'];
        $this->assertSame(FormRow::class, $viewHelpersConfig['invokables']['formRow']);
        $this->assertSame(FormElementFactory::class, $viewHelpersConfig['factories']['formElement']);
        $elementViewHelpersConfig = $config['midnight']['form_module']['element_view_helpers'];
        $this->assertInternalType('array', $elementViewHelpersConfig);
        $this->assertCount(0, $elementViewHelpersConfig);
    }
}
