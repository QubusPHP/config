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

use function is_dir;
use function realpath;
use function sprintf;

class ConfigPath implements Path
{
    /** @var string */
    protected $path;

    /**
     * @throws PathNotFoundException
     */
    public function __construct(?string $path = null)
    {
        if ($path) {
            $this->setPath($path);
        }
    }

    /**
     * @return $this
     * @throws PathNotFoundException
     */
    public function setPath(?string $path = null): static
    {
        $path = realpath($path);
        if (! is_dir((string) $path)) {
            throw new PathNotFoundException(
                sprintf(
                    "Config path (%s) is not a valid directory",
                    $path
                )
            );
        }
        $this->path = $path;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function __toString(): string
    {
        return $this->getPath();
    }
}
