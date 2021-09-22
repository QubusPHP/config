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

namespace Qubus\Tests\Config;

use Dotenv\Dotenv;
use Qubus\Config\Collection;
use PHPUnit\Framework\TestCase;
use Qubus\Config\Configuration;
use Qubus\Config\Factory;
use Qubus\Config\Path\PathCollection;
use Qubus\Config\Parser;
use PHPUnit\Framework\Assert;

class ConfigurationTest extends TestCase
{
    public function testArray()
    {
        $configuration = new Configuration([
            'path' =>  __DIR__ . "/files",
            'environment' => 'production',
            'dotenv' => __DIR__ . "/files"
        ]);

        Assert::assertInstanceOf(PathCollection::class, $configuration->getPaths());
        Assert::assertCount(1, $configuration->getPaths());
        Assert::assertEquals('production', $configuration->getEnvironment());
        Assert::assertInstanceOf(Dotenv::class, $configuration->getDotenv());
    }

    public function testInstance()
    {
        $configuration = new Configuration(new Configuration([
            'path' =>  __DIR__ . "/files",
            'environment' => 'production',
            'dotenv' => __DIR__ . "/files"
        ]));

        Assert::assertInstanceOf(PathCollection::class, $configuration->getPaths());
        Assert::assertCount(1, $configuration->getPaths());
        Assert::assertEquals('production', $configuration->getEnvironment());
        Assert::assertInstanceOf(Dotenv::class, $configuration->getDotenv());
    }

    public function testConfigAsClassFunctionWithParserNumber1()
    {
        $config = new SimpleConfig();

        [$file, $key, $sub] = Parser::getKey('file.database.port');

        $port = Parser::getValue($config(), $key, $sub);

        Assert::assertEquals(443, $port);
    }

    public function testConfigAsClassFunctionWithParserNumber2()
    {
        $config = new SimpleConfig();

        [$file, $key, $sub] = Parser::getKey('file.application.secret');

        $port = Parser::getValue($config(), $key, $sub);

        Assert::assertEquals('s3cr3t', $port);
    }
}

class SimpleConfig
{
    public function __invoke()
    {
        return [
            'database' => [
                'host' => 'localhost',
                'port'    => 443,
            ],
            'application' => [
                'name'   => 'configuration',
                'secret' => 's3cr3t',
            ],
        ];
    }
}
