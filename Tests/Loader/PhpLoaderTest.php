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

namespace Qubus\Tests\Config\Loader;

use PHPUnit\Framework\TestCase;
use Qubus\Config\Loader\PhpLoader;

class PhpLoaderTest extends TestCase
{
    public function testPhpLoader()
    {
        $content = PhpLoader::load(__DIR__ . '/../files/app.php');
        $this->assertEquals('America/Denver', $content['timezone']);
    }
}
