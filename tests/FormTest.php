<?php

namespace MidnightTest\FormModule;

use Midnight\FormModule\Form;
use PHPUnit_Framework_TestCase;

class FormTest extends PHPUnit_Framework_TestCase
{
    public function addClassData()
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
     * @param string $class
     * @param string[] $expectedClasses
     * @param string|null $initial
     * @dataProvider addClassData
     */
    public function testAddClass($class, $expectedClasses, $initial = null)
    {
        $form = new Form();
        $form->setAttribute('class', $initial);

        $form->addClass($class);

        $this->assertClassCount(count($expectedClasses), $form->getAttribute('class'));
        foreach ($expectedClasses as $expectedClass) {
            $this->assertHasClass($expectedClass, $form->getAttribute('class'));
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

    /**
     * @param int $count
     * @param string $classes
     */
    private function assertClassCount($count, $classes)
    {
        $this->assertCount($count, $this->classArrayFromString($classes));
    }

    /**
     * @param string $classes
     * @return string[]
     */
    private function classArrayFromString($classes)
    {
        if (trim($classes) === '') {
            return [];
        }
        return explode(' ', $classes);
    }
}
