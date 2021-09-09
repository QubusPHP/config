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
use Qubus\Config\Loader\YamlLoader;

class YamlLoaderTest extends TestCase
{
    public function testYamlLoader()
    {
        $content = YamlLoader::load(__DIR__ . '/../files/yml.yaml');
        $this->assertEquals('Hello', $content['string']);
    }

    public function testYamlLoaderArray()
    {
        $content = YamlLoader::load(__DIR__ . '/../files/yml.yaml');
        $this->assertEquals('Hi', $content['array']['key1']);
        $this->assertEquals('Yesterday', $content['array']['key2']);
    }
}
