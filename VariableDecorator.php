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

use function array_map;
use function is_array;
use function is_string;
use function strtr;

class VariableDecorator implements ConfigContainer
{
    /** @var ConfigInterface $config */
    public readonly ConfigContainer $config;

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
    public function getConfigKey(string $key, mixed $default = null): mixed
    {
        return $this->replaceVariables($this->config->getConfigKey($key));
    }

    /**
     * {@inheritdoc}
     */
    public function setConfigKey(string $key, mixed $value)
    {
        return $this->config->setConfigKey($key, $value);
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
    private function replaceVariables(mixed $value): mixed
    {
        if (is_string($value)) {
            return strtr($value, $this->variables);
        }

        if (is_array($value)) {
            return array_map(
                fn ($value) => $this->replaceVariables($value),
                $value
            );
        }

        return $value;
    }
}
