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

namespace Qubus\Config;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

use function array_key_exists;
use function count;

class ArrayCollection implements Countable, IteratorAggregate, ArrayAccess
{
    /** @var array $container */
    protected array $container = [];

    /**
     * @param array $elements
     */
    public function __construct(array $elements = [])
    {
        $this->container = $elements;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->container;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->container;
    }

    /**
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]) || array_key_exists($offset, $this->container);
    }

    /**
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @param string $offset
     * @return null
     */
    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }

    public function count(): int
    {
        return count($this->container);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->container);
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return null|mixed
     */
    public function get($key, $default = null)
    {
        if (isset($this->container[$key])) {
            return $this->container[$key];
        }
        return $default;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->container[$key] = $value;
    }

    /**
     * @param mixed $value
     */
    public function add($value): bool
    {
        $this->container[] = $value;
        return true;
    }

    /**
     * @return null|mixed
     */
    public function remove(string $key)
    {
        if (isset($this->container[$key]) || array_key_exists($key, $this->container)) {
            $removed = $this->container[$key];
            unset($this->container[$key]);

            return $removed;
        }
        return null;
    }

    public function removeAll()
    {
        $this->container = [];
    }
}
