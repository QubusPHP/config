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

use Qubus\Config\Loader\Loader;
use Qubus\Config\Loader\PhpLoader;
use Qubus\Config\Loader\YamlLoader;
use Qubus\Config\Path\PathCollection;

use function file_exists;
use function is_array;
use function is_string;

use const DIRECTORY_SEPARATOR;

class ConfigLoader
{
    protected static array $loaders = [
        PhpLoader::EXTENSION  => PhpLoader::class,
        YamlLoader::EXTENSION => YamlLoader::class,
    ];

    /**
     * @return array
     */
    public static function load(PathCollection $paths, ?string $env, string $file): array
    {
        $retval = [];
        foreach ($paths as $path) {
            $array1 = self::loadFile($path, null, $file);
            $array2 = self::loadFile($path, $env, $file);
            $retval = self::mergeArrays($retval, $array1, $array2);
        }
        return $retval;
    }

    /**
     * @param string|PathCollection $path
     * @return array
     */
    public static function loadFile($path, ?string $env, string $file): array
    {
        $retval = [];
        foreach (self::$loaders as $fileType => $loader) {
            $file = "{$file}.{$fileType}";

            if ($env) {
                $path .= DIRECTORY_SEPARATOR . $env . DIRECTORY_SEPARATOR . $file;
            } else {
                $path .= DIRECTORY_SEPARATOR . $file;
            }

            if (file_exists($path)) {
                if (is_string($loader)) {
                    $loader = self::$loaders[$fileType] = new $loader();
                }
                if ($loader instanceof Loader) {
                    $retval = $loader::load($path);
                    if (! is_array($retval)) {
                        $retval = [];
                    }
                }
            }
        }
        return $retval;
    }

    /**
     * @param array $array1
     * @param array $array2
     * @param array $array3
     * @return array
     */
    public static function mergeArrays(array $array1, array $array2, ?array $array3 = null): array
    {
        $retval = $array1;
        foreach ($array2 as $key => $value) {
            if (is_array($value) && isset($retval[$key])) {
                $retval[$key] = self::mergeArrays($retval[$key], $value);
            } else {
                $retval[$key] = $value;
            }
        }
        if (null !== $array3) {
            $retval = self::mergeArrays($retval, $array3);
        }
        return $retval;
    }
}
