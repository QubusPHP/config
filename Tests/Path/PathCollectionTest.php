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

namespace Qubus\Tests\Config\Path;

use PHPUnit\Framework\TestCase;
use Qubus\Config\Configuration;
use Qubus\Config\Path\PathCollection;
use PHPUnit\Framework\Assert;

class PathCollectionTest extends TestCase
{
    public function testAdd()
    {
        $pathCollection = new PathCollection();
        $pathCollection->add(__DIR__ . "/../files");
        Assert::assertEquals(realpath(__DIR__ . "/../files"), $pathCollection->get(0)->getPath());
    }

    /**
     * @expectedException \Qubus\Config\Path\PathNotFoundException
     */
    public function testAddBadPath()
    {
        $this->expectException(\Qubus\Config\Path\PathNotFoundException::class);

        $pathCollection = new PathCollection();
        $pathCollection->add("this/path/does/not/exists");
    }

    public function testRemoveAll()
    {
        $pathCollection = new PathCollection();
        $pathCollection->add(__DIR__ . "/../files");
        $pathCollection->add(__DIR__ . "/../files/testdev1");
        $pathCollection->removeAll();
        Assert::assertCount(0, $pathCollection);
    }

    public function testConfigConstructor()
    {
        $config = new Configuration([
            'paths' => [
                __DIR__ . "/../files",
                __DIR__ . "/../files/testdev1",
            ]
        ]);
        Assert::assertCount(2, $config->getPaths());
        Assert::assertEquals(realpath(__DIR__ . "/../files"), $config->getPaths()->get(0)->getPath());
        Assert::assertEquals(realpath(__DIR__ . "/../files/testdev1"), $config->getPaths()->get(1)->getPath());
    }
}
