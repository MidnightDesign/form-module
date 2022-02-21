<?php

declare(strict_types=1);

namespace MidnightTest\FormModule\View\Helper;

use Laminas\Form\ConfigProvider;
use Laminas\Form\Element\Text;
use Laminas\ServiceManager\ServiceManager;
use Laminas\View\HelperPluginManager;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\Resolver\TemplatePathStack;
use Midnight\FormModule\Module;
use Midnight\FormModule\View\Helper\FormRow;
use PHPUnit\Framework\TestCase;

final class FormRowTest extends TestCase
{
    private FormRow $helper;

    protected function setUp(): void
    {
        parent::setUp();
        $pluginManager = new HelperPluginManager(new ServiceManager(), (new ConfigProvider())()['view_helpers']);
        /** @var array{view_manager: array{template_path_stack: list<string>}} $moduleConfig */
        $moduleConfig = (new Module())->getConfig();
        $resolver = new TemplatePathStack();
        $resolver->addPaths($moduleConfig['view_manager']['template_path_stack']);
        $renderer = (new PhpRenderer())
            ->setResolver($resolver)
            ->setHelperPluginManager($pluginManager);
        $this->helper = new FormRow();
        $this->helper->setView($renderer);
    }

    public function testRenderElement(): void
    {
        $element = new Text('foo', ['label' => 'MyLabel']);
        $element->setValue('bar');

        $rendered = ($this->helper)($element);

        self::assertIsString($rendered);
        self::assertStringContainsString('<div class="form-row">', $rendered);
        self::assertStringContainsString('<input type="text" name="foo" value="bar">', $rendered);
        self::assertStringContainsString('<label for="foo">MyLabel</label>', $rendered);
    }
}
