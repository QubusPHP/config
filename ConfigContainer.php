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

namespace Qubus\Config;

use Qubus\Exception\Exception;

interface ConfigContainer
{
    /**
     * Get an item from current configuration.
     *
     * @param mixed $default
     * @return mixed
     * @throws Exception
     */
    public function getConfigKey(string $key, $default = null);

    /**
     * Set an item in current configuration.
     *
     * @param mixed $value
     * @return void|self
     */
    public function setConfigKey(string $key, $value);

    /**
     * Checks if a key exists.
     */
    public function hasConfigKey(string $key): bool;
}
