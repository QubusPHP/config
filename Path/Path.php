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

interface Path
{
    /**
     * @return $this
     */
    public function setPath(string $path): static;

    public function getPath(): string;

    public function __toString(): string;
}
