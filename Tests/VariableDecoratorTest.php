<?php

declare(strict_types=1);

namespace Qubus\Tests\Config;

use PHPUnit\Framework\TestCase;
use Qubus\Config\VariableDecorator;
use Qubus\Config\Collection;
use PHPUnit\Framework\Assert;

class VariableDecoratorTest extends TestCase
{
    private $config;

    private $decorator;

    public function setUp(): void
    {
        $this->config = Collection::factory([
            'path' =>  __DIR__ . "/files",
            'environment' => 'production',
            'dotenv' => __DIR__ . "/files"
        ]);

        $this->decorator = new VariableDecorator($this->config);
        $this->decorator->setVariables(['%vendorDir%' => __DIR__ . "/files"]);
    }

    public function testDecorator()
    {
        Assert::assertSame(__DIR__ . '/files/testdev1', $this->decorator->getConfigKey('app.test_dir'));
    }
}
