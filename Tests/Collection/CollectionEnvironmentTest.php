<?php

declare(strict_types=1);

namespace Qubus\Tests\Config\Collection;

use PHPUnit\Framework\TestCase;
use Qubus\Config\Collection;

class CollectionEnvironmentTest extends TestCase
{
    /**
     * @var Collection
     */
    private $config;

    public function setUp()
    {
        $this->config = Collection::factory([
            'path' => __DIR__ . "/../files",
            'environment' => 'testdev2'
        ]);
    }

    public function testSetEnvironment()
    {
        $env = $this->config->getEnvironment();
        $this->assertEquals("testdev2", $env);
    }

    public function testConfigGetWholeFile()
    {
        $test = $this->config->getConfigKey('database');
        $this->assertEquals("pdo_mysql", $test['connections']['default']['driver']);
        $this->assertEquals("xxxxxxxxxxxxxxxxxxx", $test['connections']['default']['password']);
    }

    public function testEGetter()
    {
        $test = $this->config->getConfigKey('app.timezone');
        $this->assertEquals("Europe/Berlin", $test);
    }

    public function testConfigGetterDefault()
    {
        $test = $this->config->getConfigKey('app.test', "this a test");
        $this->assertEquals("this a test", $test);
    }

    public function testConfigGetterDefaultExists()
    {
        $test = $this->config->getConfigKey('app.timezone', "this a test");
        $this->assertEquals("Europe/Berlin", $test);
    }

    public function testConfigGetterArray()
    {
        $test = $this->config->getConfigKey('database.connections.default');
        $this->assertEquals("127.0.0.1", $test['host']);
        $this->assertEquals("xxxxxxxxxxxxxxxxxxx", $test['password']);
    }

    public function testConfigGetterArrayDefault()
    {
        $test = $this->config->getConfigKey('database.connections.default.persistent', true);
        $this->assertTrue($test);
    }

    public function testConfigGetterArrayDefaultExists()
    {
        $test = $this->config->getConfigKey('database.connections.default.host', 'localhost');
        $this->assertEquals("127.0.0.1", $test);
    }
}
