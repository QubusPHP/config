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

use Dotenv\Dotenv;
use Qubus\Config\Path\PathCollection;

use function explode;
use function getenv;
use function is_array;
use function method_exists;

class Configuration
{
    /** @var array $env */
    public static $env;

    protected PathCollection $paths;

    protected ?Dotenv $dotenv = null;

    protected ?string $environment = null;

    /**
     * @param array|Configuration $config
     */
    public function __construct(array|Configuration $config)
    {
        $this->paths = new PathCollection();
        if (is_array($config)) {
            if (isset($config['path'])) {
                $this->paths->add($config['path']);
            }
            if (isset($config['paths'])) {
                foreach ($config['paths'] as $path) {
                    $this->paths->add($path);
                }
            }
            if (isset($config['environment'])) {
                $this->setEnvironment($config['environment']);
            }
            if (isset($config['dotenv'])) {
                $this->setDotenv(Dotenv::createImmutable($config['dotenv']));
            }
        } elseif ($config instanceof Configuration) {
            $this->setPaths($config->getPaths());
            $this->setEnvironment($config->getEnvironment());
            if ($config->getDotenv()) {
                $this->setDotenv($config->getDotenv());
            }
        }
    }

    public function getPaths(): PathCollection
    {
        return $this->paths;
    }

    /**
     * @return $this
     */
    public function setPaths(PathCollection $pathCollection): static
    {
        $this->paths = $pathCollection;
        return $this;
    }

    /**
     * @return $this
     */
    public function setEnvironment(?string $environment = null): static
    {
        if ($this->environment !== $environment) {
            if (method_exists($this, 'reset')) {
                $this->reset();
            }
        }
        $this->environment = $environment;
        return $this;
    }

    /**
     * @return $this
     */
    public function removeEnvironment(): static
    {
        if ($this->environment !== null) {
            if (method_exists($this, 'reset')) {
                $this->reset();
            }
        }
        $this->environment = null;
        return $this;
    }

    public function getEnvironment(): ?string
    {
        return $this->environment;
    }

    public function getDotenv(): ?Dotenv
    {
        return $this->dotenv;
    }

    /**
     * @return $this
     */
    public function setDotenv(Dotenv $dotenv): static
    {
        $this->dotenv = $dotenv;
        $this->loadDotenv();
        return $this;
    }

    private function loadDotenv(): array
    {
        $retval = [];
        $values = $this->dotenv->load();
        foreach ($values as $value) {
            $parts = explode("=", $value, 2);
            $retval[$parts[0]] = getenv($parts[0]);
        }
        return self::$env = $retval;
    }
}
