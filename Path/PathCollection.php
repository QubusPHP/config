<?php

declare(strict_types=1);

namespace Qubus\Config\Path;

use Qubus\Config\ArrayCollection;
use Qubus\Exception\Exception;

/**
 * @method Path get($key)
 */
class PathCollection extends ArrayCollection
{
    /**
     * @param string|Path $path
     * @throws Exception
     */
    public function add($path): bool
    {
        if (! $path instanceof Path) {
            $path = new ConfigPath($path);
        }
        $this->container[] = $path;
        return true;
    }
}
