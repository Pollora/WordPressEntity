<?php

declare(strict_types=1);

namespace Pollora\WordPressArgs {
    if (! function_exists('Pollora\\WordPressArgs\\wp_parse_args')) {
        function wp_parse_args($args, $defaults = [])
        {
            if (is_object($args)) {
                $args = get_object_vars($args);
            }

            if (is_array($args) && is_array($defaults)) {
                return array_merge($defaults, $args);
            }

            // Fallback for non-array inputs, though WordPress core usually errors or warns.
            // For testing, returning defaults might be safer than erroring.
            if (is_array($defaults)) {
                return $defaults;
            }

            return [];
        }
    }
}