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

use ArrayAccess;
use Qubus\Exception\Data\TypeException;

use function array_merge;
use function is_string;
use function sprintf;

class Collection extends Configuration implements ArrayAccess, ConfigContainer
{
    /** @var array $container */
    private array $container = [];

    /**
     * @param array|Configuration $config
     */
    public static function factory($config): Collection
    {
        $factory = new Factory();
        return $factory($config);
    }

    /**
     * Set a config
     *
     * @param array $config
     * @return void|self
     */
    public function setConfigKey(string $key, $config)
    {
        if (! isset($this->container[$key])) {
            $this->container[$key] = $config;
        } else {
            $this->container[$key] = array_merge($this->container[$key], $config);
        }
        return $this;
    }

    /**
     * Checks if a key exists.
     */
    public function hasConfigKey(string $key): bool
    {
        return isset($this->container[$key]);
    }

    public function removeConfigKey(string $key): void
    {
        unset($this->container[$key]);
    }

    /**
     * Get a config
     *
     * @param mixed $default
     * @throws TypeException
     * @return mixed
     */
    public function getConfigKey(string $key, $default = null)
    {
        if (! is_string($key) || empty($key)) {
            throw new TypeException(
                sprintf('Parameter %s passed to Config::get() is not a valid string resource.'),
                $key
            );
        }

        [$file, $configKey, $sub] = Parser::getKey($key);

        if (! isset($this->container[$file])) {
            $this->container[$file] = ConfigLoader::load(
                $this->paths,
                $this->environment,
                $file
            );
        }

        return Parser::getValue($this->container[$file], $configKey, $sub, $default);
    }

    /**
     * @return $this
     */
    public function reset()
    {
        $this->container = [];
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->offsetGet($key);
    }

    /**
     * @param string $key
     * @param array|null $args
     * @return mixed
     */
    public function __call($key, $args = null)
    {
        return $this->offsetGet($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * @param int $offset
     */
    public function offsetExists($offset): bool
    {
        $item = $this->getConfigKey($offset);
        return isset($item);
    }

    /**
     * @param int $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->getConfigKey($offset);
    }

    /**
     * @param int $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->setConfigKey($offset, $value);
    }

    /**
     * @param int $offset
     */
    public function offsetUnset($offset): void
    {
        $this->removeConfigKey($offset);
    }
}
