<?php

declare(strict_types=1);

namespace Qubus\Config;

use Qubus\Exception\Exception;

interface ConfigContainer
{
    /**
     * Get an item from current configuration.
     *
     * @param mixed $default
     * @return mixed
     * @throws Exception
     */
    public function getConfigKey(string $key, $default = null);

    /**
     * Set an item in current configuration.
     *
     * @param mixed $value
     * @return void|self
     */
    public function setConfigKey(string $key, $value);
}
