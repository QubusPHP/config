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

use PHPUnit\Framework\TestCase;
use Qubus\Config\Parser;
use PHPUnit\Framework\Assert;

class ParserTest extends TestCase
{
    public function testGetKey()
    {
        $key = Parser::getKey('this.is.file');
        Assert::assertCount(3, $key);
        Assert::assertCount(1, $key[2]);
        Assert::assertEquals('this', $key[0]);
        Assert::assertEquals('is', $key[1]);
        Assert::assertEquals('file', $key[2][0]);
    }

    public function testGetKeyArray()
    {
        $key = Parser::getKey('this.is.an.array');
        Assert::assertCount(3, $key);
        Assert::assertCount(2, $key[2]);
        Assert::assertEquals('this', $key[0]);
        Assert::assertEquals('is', $key[1]);
        Assert::assertEquals('an', $key[2][0]);
        Assert::assertEquals('array', $key[2][1]);
    }

    public function testGetValue()
    {
        $kaystack = [
            'hi' => [
                'find' => [
                    'this' => 'Hello'
                ]
            ]
        ];
        [$file, $key, $sub] = Parser::getKey('file.hi.find.this');
        Assert::assertEquals('Hello', Parser::getValue($kaystack, $key, $sub));
    }
}
