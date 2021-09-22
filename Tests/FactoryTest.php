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
