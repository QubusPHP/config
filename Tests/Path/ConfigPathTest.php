<?php

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
        new ConfigPath("/this/path/does/not/exists");
    }
}
