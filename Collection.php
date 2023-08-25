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
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function setConfigKey(string $key, mixed $value): static
    {
        if (! isset($this->container[$key])) {
            $this->container[$key] = $value;
        } else {
            $this->container[$key] = array_merge($this->container[$key], $value);
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
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     * @throws TypeException
     */
    public function getConfigKey(string $key, mixed $default = null): mixed
    {
        if (! is_string($key) || empty($key)) {
            throw new TypeException(
                sprintf('Parameter %s passed to Config::get() is not a valid string resource.', $key),
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
    public function reset(): static
    {
        $this->container = [];
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws TypeException
     */
    public function __get($key)
    {
        return $this->offsetGet($key);
    }

    /**
     * @param mixed $key
     * @param array|null $args
     * @return mixed
     * @throws TypeException
     */
    public function __call(mixed $key, array $args = null)
    {
        return $this->offsetGet($key);
    }

    /**
     * @param mixed $key
     * @return bool
     * @throws TypeException
     */
    public function __isset(mixed $key)
    {
        return $this->offsetExists($key);
    }

    /**
     * @param mixed $offset
     * @return bool
     * @throws TypeException
     */
    public function offsetExists(mixed $offset): bool
    {
        $item = $this->getConfigKey($offset);
        return isset($item);
    }

    /**
     * @param mixed $offset
     * @return mixed
     * @throws TypeException
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->getConfigKey($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->setConfigKey($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->removeConfigKey($offset);
    }
}
