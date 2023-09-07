<?php

namespace App\Helpers;

class ObjectHelpers
{
    /**
     * getMethods function
     *
     * @param object|string|callable $classOrInstance
     * @param boolean $sort
     * @param int $sortFlags
     *
     * @return array
     */
    public static function getMethods(
        object|string|callable $classOrInstance,
        bool $sort = true,
        int $sortFlags = SORT_REGULAR,
    ): array {
        if (!is_object($classOrInstance)) {
            $classOrInstance = is_callable($classOrInstance) ? call_user_func($classOrInstance) : $classOrInstance;

            if (is_string($classOrInstance) && class_exists($classOrInstance)) {
                $classOrInstance = app($classOrInstance);
            }

            if (!is_object($classOrInstance)) {
                return [];
            }
        }

        $methods = get_class_methods($classOrInstance);

        if ($sort) {
            asort($methods, $sortFlags);
        }

        return array_values($methods);
    }
}
