<?php

namespace MidnightTest\FormModule;

use Midnight\FormModule\Module;
use Midnight\FormModule\View\Helper\FormElementFactory;
use Midnight\FormModule\View\Helper\FormRow;
use PHPUnit_Framework_TestCase;
use Zend\Form\View\Helper\FormElement;
use Zend\ServiceManager\Factory\InvokableFactory;

class ModuleTest extends PHPUnit_Framework_TestCase
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
}
