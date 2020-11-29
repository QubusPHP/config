<?php

declare(strict_types=1);

namespace Qubus\Config;

use function array_slice;
use function count;
use function current;
use function explode;
use function is_array;

class Parser
{
    /**
     * @return array
     */
    public static function getKey(string $name): array
    {
        $file = $key = $sub = null;
        $parts = explode('.', $name);
        if (isset($parts[0])) {
            $file = $parts[0];
        }
        if (isset($parts[1])) {
            $key = $parts[1];
        }
        if (isset($parts[2])) {
            $sub = [];
            foreach (array_slice($parts, 2) as $subkey) {
                $sub[] = $subkey;
            }
        }

        return [$file, $key, $sub];
    }

    /**
     * @param array $haystack
     * @param null|array $sub
     * @param null|mixed $default
     * @return mixed
     */
    public static function getValue(
        ?array $haystack = null,
        ?string $key = null,
        ?array $sub = null,
        $default = null
    ) {
        if (empty($key) && ! isset($haystack)) {
            return $default;
        } elseif (empty($key)) {
            if (! isset($haystack) && null !== $default) {
                return $default;
            } elseif (isset($haystack)) {
                return $haystack;
            }
            return null;
        } elseif (! empty($key) && empty($sub)) {
            if (empty($haystack[$key]) && null !== $default) {
                return $default;
            } elseif (isset($haystack[$key])) {
                return $haystack[$key];
            }
            return null;
        } elseif (is_array($sub)) {
            $array = $haystack[$key] ?? [];
            $value = self::findInMultiArray($sub, $array);
            if (empty($value) && null !== $default) {
                return $default;
            } elseif (isset($value)) {
                return $value;
            }
            return null;
        }
        return null;
    }

    /**
     * @param array $needle
     * @param array $haystack
     * @return mixed
     */
    private static function findInMultiArray(array $needle, array $haystack)
    {
        $currentNeedle = current($needle);
        $needle = array_slice($needle, 1);
        if (isset($haystack[$currentNeedle]) && is_array($haystack[$currentNeedle]) && count($needle)) {
            return self::findInMultiArray($needle, $haystack[$currentNeedle]);
        } elseif (isset($haystack[$currentNeedle]) && ! is_array($haystack[$currentNeedle]) && count($needle)) {
            return null;
        } elseif (isset($haystack[$currentNeedle])) {
            return $haystack[$currentNeedle];
        }
        return null;
    }
}
