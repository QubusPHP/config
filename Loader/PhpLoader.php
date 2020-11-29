<?php

declare(strict_types=1);

namespace Qubus\Config\Loader;

class PhpLoader implements Loader
{
    public const EXTENSION = 'php';

    /**
     * {@inheritdoc}
     */
    public static function load($file)
    {
        return require $file;
    }
}
