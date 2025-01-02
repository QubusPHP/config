<?php

/**
 * Qubus\Config
 *
 * @link       https://github.com/QubusPHP/config
 * @copyright  2020 Joshua Parker <josh@joshuaparker.blog>
 * @copyright  2016 Sinergi
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 */

declare(strict_types=1);

namespace Qubus\Config\Helpers;

use function getenv;

/**
 * Retrieve values from the environment variables
 * that have been set. Especially useful for
 * retrieving values set from the .env file for
 * use in config files.
 *
 * @param string $key
 * @param string|null $default
 * @return bool|string|null
 */
function env(string $key, mixed $default = null): bool|string|null
{
    $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
    // Not found? Return the default value.
    if ($value === false) {
        return $default;
    }
    // Handle any boolean values
    return match (strtolower($value)) {
        'true' => true,
        'false' => false,
        'empty' => '',
        'null' => null,
        default => $value,
    };
}
