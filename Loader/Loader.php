<?php

declare(strict_types=1);

namespace Qubus\Config\Loader;

interface Loader
{
    /**
     * Loads the config file.
     *
     * @param string $file
     * @return mixed
     */
    public static function load($file);
}
