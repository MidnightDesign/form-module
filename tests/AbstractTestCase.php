<?php

declare(strict_types=1);

namespace MidnightTest\FormModule;

use Laminas\ServiceManager\ServiceManager;
use Midnight\FormModule\Module;
use PHPUnit\Framework\TestCase;

class AbstractTestCase extends TestCase
{
    protected function createServiceManager(): ServiceManager
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('config', (new Module())->getConfig());
        return $serviceManager;
    }
}
