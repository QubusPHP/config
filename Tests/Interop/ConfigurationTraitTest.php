<?php

declare(strict_types=1);

namespace Qubus\Tests\Config\Interop;

use ArrayIterator;
use PHPUnit\Framework\TestCase;
use Qubus\Config\Interop\ConfigurationTrait;
use Qubus\Config\Interop\Exception\MandatoryOptionNotFoundException;
use Qubus\Config\Interop\ProvidesDefaultOptions;
use Qubus\Config\Interop\RequiresConfig;
use Qubus\Config\Interop\RequiresConfigId;
use Qubus\Config\Interop\RequiresMandatoryOptions;

class ConfigurationTraitTest extends TestCase
{
    public function testGeneratorDimensionsSupportConfigIds(): void
    {
        $factory = new class implements RequiresConfigId {
            use ConfigurationTrait;

            public function dimensions(): iterable
            {
                yield 'services';
            }
        };

        self::assertTrue($factory->canRetrieveOptions(['services' => ['worker' => ['threads' => 2]]], 'worker'));
        self::assertSame(
            ['threads' => 2],
            $factory->options(['services' => ['worker' => ['threads' => 2]]], 'worker')
        );
    }

    public function testAllNestedMandatoryBranchesAreChecked(): void
    {
        $factory = new class implements RequiresConfig, RequiresMandatoryOptions {
            use ConfigurationTrait;

            public function dimensions(): iterable
            {
                return [];
            }

            public function mandatoryOptions(): iterable
            {
                return ['database' => ['host'], 'cache' => ['host']];
            }
        };

        $this->expectException(MandatoryOptionNotFoundException::class);
        $factory->options(['database' => ['host' => 'localhost'], 'cache' => []]);
    }

    public function testIteratorAggregateDefaultsAreMergedAndReturnedAsArrays(): void
    {
        $factory = new class implements RequiresConfig, ProvidesDefaultOptions {
            use ConfigurationTrait;

            public function dimensions(): iterable
            {
                return ['service'];
            }

            public function defaultOptions(): iterable
            {
                return new ArrayIterator(['enabled' => true, 'retries' => 3]);
            }
        };

        self::assertSame(
            ['enabled' => true, 'retries' => 5],
            $factory->options(['service' => ['retries' => 5]])
        );
        self::assertSame(['enabled' => true, 'retries' => 3], $factory->optionsWithFallback([]));
    }
}
