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
