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

class PhpLoader implements Loader
{
    public const string EXTENSION = 'php';

    /**
     * {@inheritdoc}
     */
    public static function load(string $file): mixed
    {
        return require $file;
    }
}
