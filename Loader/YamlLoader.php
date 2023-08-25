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

use Symfony\Component\Yaml\Parser;

use function file_get_contents;

class YamlLoader implements Loader
{
    public const EXTENSION = 'yaml';

    protected static ?Parser $parser = null;

    /**
     * Gets the parser to parse yaml strings to PHP arrays.
     */
    protected static function getParser(): Parser
    {
        if (null === self::$parser) {
            self::$parser = new Parser();
        }
        return self::$parser;
    }

    /**
     * {@inheritdoc}
     */
    public static function load($file)
    {
        return self::getParser()->parse(file_get_contents($file));
    }
}
