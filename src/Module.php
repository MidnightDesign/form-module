<?php

namespace Midnight\Form;

class Module
{
    public function getConfig()
    {
        return include dirname(__DIR__) . '/config/module.config.php';
    }
} 
