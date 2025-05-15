<?php

declare(strict_types=1);

if (!function_exists('absint')) {
    function absint($maybeint) {
        return abs((int) $maybeint);
    }
}

if (!function_exists('checked')) {
    function checked($checked, $current = true, $echo = true) {
        return $checked === $current;
    }
}

if (!function_exists('has_term')) {
    function has_term($term_id, $taxonomy, $post) {
        return true;
    }
} 