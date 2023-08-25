<?php

declare(strict_types=1);

namespace Qubus\Tests\Config;

use Qubus\Config\Collection;
use PHPUnit\Framework\TestCase;
use Qubus\Config\Factory;
use PHPUnit\Framework\Assert;

class FactoryTest extends TestCase
{
    public function testFactory()
    {
        $factory = new Factory();
        /** @var Collection $collection */
        $collection = $factory([]);
        Assert::assertInstanceOf(Collection::class, $collection);
    }
}
