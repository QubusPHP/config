<?php

/**
 * Qubus\Config
 *
 * @link       https://github.com/QubusPHP/config
 * @copyright  2020 Joshua Parker
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\Config\Helpers;

use Qubus\Config\Configuration;

function env($key, $default = null)
{
    $dotenv = Configuration::$env;
    if (is_array($dotenv) && isset($dotenv[$key])) {
        return $dotenv[$key];
    }
    return $default;
}
