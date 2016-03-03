<?php

namespace Midnight\FormModule;

use Zend\Form\Form as ZendForm;

class Form extends ZendForm
{
    /**
     * @param string $class
     */
    public function addClass($class)
    {
        $classes = explode(' ', $this->getAttribute('class'));
        $classes = array_merge($classes, explode(' ', $class));
        $classes = $this->cleanupClasses($classes);
        $this->setAttribute('class', join(' ', $classes));
    }

    /**
     * Removes unnecessary spaces and duplicates
     *
     * @param string[] $classes
     *
     * @return string[]
     */
    private function cleanupClasses($classes)
    {
        foreach ($classes as $index => &$class) {
            $class = trim($class);
            if (empty($class)) {
                unset($classes[$index]);
            }
        }
        $classes = array_unique($classes);
        return $classes;
    }
} 
