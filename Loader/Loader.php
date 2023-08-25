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

namespace Qubus\Config\Loader;

interface Loader
{
    /**
     * Loads the config file.
     *
     * @param string $file
     * @return mixed
     */
    public static function load($file);
}
