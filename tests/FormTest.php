<?php declare(strict_types=1);

namespace MidnightTest\FormModule;

use Midnight\FormModule\Form;
use PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{
    public function addClassData(): array
    {
        return [
            'single' => ['foo', ['foo']],
            'multiple' => ['foo bar', ['foo', 'bar']],
            'duplicate' => ['foo bar foo', ['foo', 'bar']],
            'duplicate 2' => ['foo bar foo', ['foo', 'bar'], 'bar foo'],
            'empty' => ['', []],
            'empty 2' => ['', ['foo'], 'foo'],
        ];
    }

    /**
     * @param string[] $expectedClasses
     * @dataProvider addClassData
     */
    public function testAddClass(string $class, array $expectedClasses, string $initial = null)
    {
        $form = new Form();
        $form->setAttribute('class', $initial);

        $form->addClass($class);

        $formClass = $form->getAttribute('class');
        \assert(\is_string($formClass));
        $this->assertClassCount(count($expectedClasses), $formClass);
        foreach ($expectedClasses as $expectedClass) {
            $this->assertHasClass($expectedClass, $formClass);
        }
    }

    /**
     * @param string $expected
     * @param string $classes
     */
    private function assertHasClass($expected, $classes)
    {
        $this->assertContains($expected, $this->classArrayFromString($classes));
    }

    private function assertClassCount(int $count, string $classes)
    {
        $this->assertCount($count, $this->classArrayFromString($classes));
    }

    /**
     * @return string[]
     */
    private function classArrayFromString(string $classes): array
    {
        if (trim($classes) === '') {
            return [];
        }
        return explode(' ', $classes);
    }
}
