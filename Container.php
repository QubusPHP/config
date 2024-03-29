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

use Psr\Container\ContainerInterface;
use ReflectionClass;

use function in_array;
use function is_array;
use function is_callable;

class Container implements ContainerInterface
{
    public readonly ContainerInterface $diContainer;

    /** @var array $container */
    private array $container = [];

    /** @var array $instances */
    private array $instances = [];

    public function __construct(ContainerInterface $diContainer)
    {
        $this->diContainer = $diContainer ;
    }

    /**
     * @param mixed $id
     */
    public function get($id)
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        $className = $this->getContainerValue($id);
        if (is_callable($className)) {
            return $className($this->diContainer, $id);
        }
        $class = new $className();
        return $this->instances[$id] = $class($this->diContainer);
    }

    /**
     * @param mixed $id
     */
    public function has($id): bool
    {
        if (isset($this->instances[$id])) {
            return true;
        }
        return $this->getContainerValue($id) !== null;
    }

    protected function getContainerValue($id)
    {
        if (isset($this->container[$id])) {
            return $this->container[$id];
        }
        foreach ($this->container as $alias => $concrete) {
            $class = new ReflectionClass($id);
            if (false === $class) {
                return null;
            }
            do {
                $name = $class->getName();
                if ($alias === $name) {
                    return $concrete;
                }
                $interfaces = $class->getInterfaceNames();
                if (is_array($interfaces) && in_array($alias, $interfaces)) {
                    return $concrete;
                }
                $class = $class->getParentClass();
            } while (false !== $class);
            return null;
        }
        return null;
    }

    public function add($alias, $className, $target = null): void
    {
        if (null === $target) {
            $target = $className;
        } else {
            $this->container[$className] = $target;
        }
        $this->container[$alias] = $target;
    }
}
