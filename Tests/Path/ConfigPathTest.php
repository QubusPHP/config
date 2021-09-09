<?php

/**
 * Qubus\Config
 *
 * @link       https://github.com/QubusPHP/config
 * @copyright  2020 Joshua Parker
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\Tests\Config\Path;

use PHPUnit\Framework\TestCase;
use Qubus\Config\Configuration;
use Qubus\Config\Path\ConfigPath;

class ConfigPathTest extends TestCase
{
    public function testConfigConstructor()
    {
        $config = new Configuration(['path' => __DIR__ . "/../files"]);
        $path = $config->getPaths()->get(0)->getPath();
        $this->assertEquals(realpath(__DIR__ . "/../files"), $path);
    }

    /**
     * @expectedException \Qubus\Config\Path\PathNotFoundException
     */
    public function testConfigConstructorBadPath()
    {
        $this->expectException(\Qubus\Config\Path\PathNotFoundException::class);

        new ConfigPath("/this/path/does/not/exists");
    }
}
