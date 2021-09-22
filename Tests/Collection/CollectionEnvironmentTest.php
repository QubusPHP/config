<?php

/**
 * Qubus\Config
 *
 * @link       https://github.com/QubusPHP/config
 * @copyright  2020 Joshua Parker <josh@joshuaparker.blog>
 * @copyright  2016 Sinergi
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\Tests\Config\Collection;

use PHPUnit\Framework\TestCase;
use Qubus\Config\Collection;
use PHPUnit\Framework\Assert;

class CollectionEnvironmentTest extends TestCase
{
    /**
     * @var Collection
     */
    private $config;

    public function setUp(): void
    {
        $this->config = Collection::factory([
            'path' => __DIR__ . "/../files",
            'environment' => 'testdev2'
        ]);
    }

    public function testSetEnvironment()
    {
        $env = $this->config->getEnvironment();
        Assert::assertEquals("testdev2", $env);
    }

    public function testConfigGetWholeFile()
    {
        $test = $this->config->getConfigKey('database');
        Assert::assertEquals("pdo_mysql", $test['connections']['default']['driver']);
        Assert::assertEquals("xxxxxxxxxxxxxxxxxxx", $test['connections']['default']['password']);
    }

    public function testEGetter()
    {
        $test = $this->config->getConfigKey('app.timezone');
        Assert::assertEquals("Europe/Berlin", $test);
    }

    public function testConfigGetterDefault()
    {
        $test = $this->config->getConfigKey('app.test', "this a test");
        Assert::assertEquals("this a test", $test);
    }

    public function testConfigGetterDefaultExists()
    {
        $test = $this->config->getConfigKey('app.timezone', "this a test");
        Assert::assertEquals("Europe/Berlin", $test);
    }

    public function testConfigGetterArray()
    {
        $test = $this->config->getConfigKey('database.connections.default');
        Assert::assertEquals("127.0.0.1", $test['host']);
        Assert::assertEquals("xxxxxxxxxxxxxxxxxxx", $test['password']);
    }

    public function testConfigGetterArrayDefault()
    {
        $test = $this->config->getConfigKey('database.connections.default.persistent', true);
        Assert::assertTrue($test);
    }

    public function testConfigGetterArrayDefaultExists()
    {
        $test = $this->config->getConfigKey('database.connections.default.host', 'localhost');
        Assert::assertEquals("127.0.0.1", $test);
    }
}
