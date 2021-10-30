<?php

declare(strict_types=1);

namespace Midnight\FormModule;

use Laminas\Form\Form as LaminasForm;

use function array_merge;
use function array_unique;
use function explode;
use function implode;
use function trim;

class Form extends LaminasForm
{
    public function addClass(string $class): void
    {
        $classes = explode(' ', (string)$this->getAttribute('class'));
        $classes = array_merge($classes, explode(' ', $class));
        $classes = $this->cleanupClasses($classes);
        $this->setAttribute('class', implode(' ', $classes));
    }

    /**
     * Removes unnecessary spaces and duplicates
     *
     * @param array<array-key, string> $classes
     * @return array<array-key, string>
     */
    private function cleanupClasses(array $classes): array
    {
        foreach ($classes as $index => &$class) {
            $class = trim($class);
            if ($class !== '') {
                continue;
            }
            unset($classes[$index]);
        }
        unset($class);
        $classes = array_unique($classes);
        return $classes;
    }
}
