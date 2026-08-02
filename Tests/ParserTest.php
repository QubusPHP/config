<?php

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

    public function testFalseyValuesAreNotReplacedByDefault(): void
    {
        $config = [
            'zero' => 0,
            'false' => false,
            'empty' => '',
            'nested' => ['zero' => 0],
        ];

        Assert::assertSame(0, Parser::getValue($config, 'zero', null, 42));
        Assert::assertFalse(Parser::getValue($config, 'false', null, true));
        Assert::assertSame('', Parser::getValue($config, 'empty', null, 'fallback'));
        Assert::assertSame(0, Parser::getValue($config, 'nested', ['zero'], 42));
        Assert::assertSame('fallback', Parser::getValue($config, 'missing', null, 'fallback'));
    }
}
