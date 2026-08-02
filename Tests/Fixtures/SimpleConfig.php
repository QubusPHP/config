<?php

declare(strict_types=1);

namespace Qubus\Tests\Config\Fixtures;

class SimpleConfig
{
    public function __invoke(): array
    {
        return [
            'database' => [
                'host' => 'localhost',
                'port'    => 443,
            ],
            'application' => [
                'name'   => 'configuration',
                'secret' => 's3cr3t',
            ],
        ];
    }
}
