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

namespace Qubus\Config;

use Qubus\Exception\Data\TypeException;
use Qubus\Exception\Exception;

interface ConfigContainer
{
    /**
     * Get an item from current configuration.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     * @throws Exception
     */
    public function getConfigKey(string $key, mixed $default = null): mixed;

    /**
     * Set an item in current configuration.
     *
     * @param string $key
     * @param mixed $value
     * @return void|self
     */
    public function setConfigKey(string $key, mixed $value);

    /**
     * Checks if a key exists.
     */
    public function hasConfigKey(string $key): bool;

    /**
     * Get the specified string configuration value.
     *
     * @param string $key
     * @param (\Closure():(string|null))|string|null  $default
     * @return string
     * @throws TypeException
     */
    public function string(string $key, mixed $default = null): string;

    /**
     * Get the specified integer configuration value.
     *
     * @param string $key
     * @param (\Closure():(int|null))|int|null  $default
     * @return int
     * @throws TypeException
     */
    public function integer(string $key, mixed $default = null): int;

    /**
     * Get the specified float configuration value.
     *
     * @param string $key
     * @param (\Closure():(float|null))|float|null  $default
     * @return float
     * @throws TypeException
     */
    public function float(string $key, mixed $default = null): float;

    /**
     * Get the specified boolean configuration value.
     *
     * @param string $key
     * @param (\Closure():(bool|null))|bool|null  $default
     * @return bool
     * @throws TypeException
     */
    public function boolean(string $key, mixed $default = null): bool;

    /**
     * Get the specified array configuration value.
     *
     * @param string $key
     * @param (\Closure():(array<array-key, mixed>|null))|array<array-key, mixed>|null  $default
     * @return array
     * @throws TypeException
     */
    public function array(string $key, mixed $default = null): array;
}
