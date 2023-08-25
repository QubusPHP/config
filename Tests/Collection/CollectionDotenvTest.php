<?php

declare(strict_types=1);

namespace Qubus\Tests\Config\Collection;

use PHPUnit\Framework\TestCase;
use Qubus\Config\Collection;
use PHPUnit\Framework\Assert;

class CollectionDotenvTest extends TestCase
{
    public function testDotenv()
    {
        $config = Collection::factory([
            'path' => __DIR__ . "/../files",
            'dotenv' => __DIR__ . "/../files"
        ]);

        Assert::assertEquals('bye', $config->getConfigKey('dotenv.test_var'));
    }
}
