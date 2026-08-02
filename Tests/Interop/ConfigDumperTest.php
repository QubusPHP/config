<?php

declare(strict_types=1);

namespace Qubus\Tests\Config\Interop;

use PHPUnit\Framework\TestCase;
use Qubus\Config\Interop\Tool\ConfigDumper;

class ConfigDumperTest extends TestCase
{
    public function testDumpEscapesKeysAsValidPhp(): void
    {
        $dump = new ConfigDumper()->dumpConfigFile(["quote'key" => 'value']);

        self::assertStringContainsString("'quote\\'key' => 'value'", $dump);
    }
}
