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
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]) || array_key_exists($offset, $this->container);
    }

    /**
     * @param string $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * @param string $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->remove($offset);
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
     * @param mixed $key
     * @param mixed|null $default
     * @return null|mixed
     */
    public function get(mixed $key, mixed $default = null): mixed
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
    public function set(string $key, mixed $value): void
    {
        $this->container[$key] = $value;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function add(mixed $value): bool
    {
        $this->container[] = $value;
        return true;
    }

    /**
     * @return null|mixed
     */
    public function remove(string $key): mixed
    {
        if (isset($this->container[$key]) || array_key_exists($key, $this->container)) {
            $removed = $this->container[$key];
            unset($this->container[$key]);

            return $removed;
        }
        return null;
    }

    public function removeAll(): void
    {
        $this->container = [];
    }
}
