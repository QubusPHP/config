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

use function array_map;
use function is_array;
use function is_string;
use function strtr;

class VariableDecorator implements ConfigContainer
{
    /** @var ConfigInterface $config */
    private ConfigContainer $config;

    /** @var array $variables */
    private array $variables = [];

    public function __construct(ConfigContainer $configContainer)
    {
        $this->config = $configContainer;
    }

    public function setVariables(array $map): self
    {
        $this->variables = $map;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigKey(string $dotPath, $default = null)
    {
        return $this->replaceVariables($this->config->getConfigKey($dotPath));
    }

    /**
     * {@inheritdoc}
     */
    public function setConfigKey(string $dotPath, $value)
    {
        return $this->config->setConfigKey($dotPath, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function hasConfigKey(string $key): bool
    {
        return $this->config->hasConfigKey($key);
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    private function replaceVariables($value)
    {
        if (is_string($value)) {
            return strtr($value, $this->variables);
        }

        if (is_array($value)) {
            return array_map(
                function ($value) {
                    return $this->replaceVariables($value);
                },
                $value
            );
        }

        return $value;
    }
}
