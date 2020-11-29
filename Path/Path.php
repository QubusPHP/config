<?php

declare(strict_types=1);

namespace Qubus\Config\Path;

interface Path
{
    /**
     * @return $this
     */
    public function setPath(string $path);

    public function getPath(): string;

    public function __toString(): string;
}
