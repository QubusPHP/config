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

use Interop\Config\ConfigurationTrait;
use Interop\Config\RequiresConfig;
use Interop\Config\RequiresMandatoryOptions;

use function is_array;

class Factory implements RequiresMandatoryOptions, RequiresConfig
{
    use ConfigurationTrait;

    public const VENDOR_NAME = 'qubus';
    public const PACKAGE_NAME = 'config';

    /**
     * @param array|Configuration $config
     * @return Collection
     */
    public function __invoke(array|Configuration $config): Collection
    {
        if (is_array($config)) {
            $config = new Configuration($config);
        }

        return new Collection($config);
    }

    /**
     * @return string
     */
    public function vendorName(): string
    {
        return self::VENDOR_NAME;
    }

    /**
     * @return string
     */
    public function packageName(): string
    {
        return self::PACKAGE_NAME;
    }

    /**
     * @return string[] List with mandatory options
     */
    public function mandatoryOptions(): iterable
    {
        return [];
    }

    /**
     * @return string[] List with optional options
     */
    public function optionalOptions(): array
    {
        return [
            'path',
            'paths',
            'environment',
            'dotenv',
        ];
    }

    public function dimensions(): iterable
    {
        return [];
    }
}
