<?php declare(strict_types=1);

namespace MidnightTest\FormModule;

use Midnight\FormModule\Module;
use PHPUnit\Framework\TestCase;
use Zend\ServiceManager\ServiceManager;

class AbstractTestCase extends TestCase
{
    protected function createServiceManager(): ServiceManager
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('Config', (new Module)->getConfig());
        return $serviceManager;
    }
}
