<?php

declare(strict_types=1);

namespace MidnightTest\FormModule;

use Midnight\FormModule\Form;
use PHPUnit\Framework\TestCase;

use function assert;
use function count;
use function explode;
use function is_string;
use function trim;

class FormTest extends TestCase
{
    /**
     * @return array<string, array<int,string|array>>
     */
    public function addClassData(): array
    {
        return [
            'single' => ['foo', ['foo']],
            'multiple' => ['foo bar', ['foo', 'bar']],
            'multiple with tab' => ["foo \tbar ", ['foo', 'bar']],
            'duplicate' => ['foo bar foo', ['foo', 'bar']],
            'duplicate 2' => ['foo bar foo', ['foo', 'bar'], 'bar foo'],
            'empty' => ['', []],
            'empty 2' => ['', ['foo'], 'foo'],
        ];
    }

    /**
     * @param list<string> $expectedClasses
     * @dataProvider addClassData
     */
    public function testAddClass(string $class, array $expectedClasses, ?string $initial = null): void
    {
        $form = new Form();
        $form->setAttribute('class', $initial);

        $form->addClass($class);

        $formClass = $form->getAttribute('class');
        assert(is_string($formClass));
        $this->assertClassCount(count($expectedClasses), $formClass);
        foreach ($expectedClasses as $expectedClass) {
            $this->assertHasClass($expectedClass, $formClass);
        }
    }

    private function assertHasClass(string $expected, string $classes): void
    {
        self::assertContains($expected, $this->classArrayFromString($classes));
    }

    private function assertClassCount(int $count, string $classes): void
    {
        self::assertCount($count, $this->classArrayFromString($classes));
    }

    /**
     * @return list<string>
     */
    private function classArrayFromString(string $classes): array
    {
        if (trim($classes) === '') {
            return [];
        }
        return explode(' ', $classes);
    }
}
