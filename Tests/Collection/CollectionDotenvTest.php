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
