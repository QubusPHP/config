<?php

declare(strict_types=1);

namespace Qubus\Tests\Config\Loader;

use PHPUnit\Framework\TestCase;
use Qubus\Config\Loader\PhpLoader;
use PHPUnit\Framework\Assert;

class PhpLoaderTest extends TestCase
{
    public function testPhpLoader()
    {
        $content = PhpLoader::load(__DIR__ . '/../files/app.php');
        Assert::assertEquals('America/Denver', $content['timezone']);
    }
}
