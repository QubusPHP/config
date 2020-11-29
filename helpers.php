<?php

declare(strict_types=1);

namespace Qubus\Config;

use Qubus\Config\Configuration;

if (!function_exists('Qubus\Config\env')) {
    function env($key, $default = null)
    {
        $dotenv = Configuration::$env;
        if (is_array($dotenv) && isset($dotenv[$key])) {
            return $dotenv[$key];
        }
        return $default;
    }
}
