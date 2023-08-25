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

namespace Qubus\Config\Path;

use Qubus\Config\ArrayCollection;

/**
 * @method Path get(string $key)
 */
class PathCollection extends ArrayCollection
{
    /**
     * @param mixed $value
     */
    public function add(mixed $value): bool
    {
        if (! $value instanceof Path) {
            $value = new ConfigPath($value);
        }
        $this->container[] = $value;
        return true;
    }
}
