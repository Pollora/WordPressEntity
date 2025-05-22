<?php

declare(strict_types=1);

namespace ExtCPTs;

if (! function_exists('ExtCPTs\\apply_filters')) {
    function apply_filters($tag, $value, ...$args)
    {
        return $value; // Return the value without modification
    }
}

if (! function_exists('ExtCPTs\\add_filter')) {
    function add_filter($tag, $callback, $priority = 10, $accepted_args = 1)
    {
        // Do nothing in tests
        return true;
    }
}

if (! function_exists('ExtCPTs\\get_post_type_object')) {
    function get_post_type_object($post_type)
    {
        return null; // Simulate the absence of the post type object
    }
}

if (! function_exists('ExtCPTs\\get_taxonomies')) {
    function get_taxonomies($args = [], $output = 'names', $operator = 'and')
    {
        return []; // Return an empty array
    }
}

if (! function_exists('ExtCPTs\\get_post_types')) {
    function get_post_types($args = [], $output = 'names', $operator = 'and')
    {
        return []; // Return an empty array
    }
}

if (! function_exists('ExtCPTs\\add_action')) {
    function add_action($hook, $callback, $priority = 10, $accepted_args = 1)
    {
        // Do nothing in tests
        return true;
    }
}

if (! function_exists('ExtCPTs\\register_post_type')) {
    function register_post_type($post_type, $args = [])
    {
        return true; // Simulate successful registration
    }
}

if (! function_exists('ExtCPTs\\register_taxonomy')) {
    function register_taxonomy($taxonomy, $object_type, $args = [])
    {
        return true; // Simulate successful registration
    }
}

if (! function_exists('ExtCPTs\\is_wp_error')) {
    function is_wp_error($thing)
    {
        return false; // Simulate that it's not an error
    }
}

if (! function_exists('ExtCPTs\\do_action')) {
    function do_action($tag, ...$args)
    {
        // Do nothing in tests
    }
}

if (! function_exists('ExtCPTs\\esc_html')) {
    function esc_html($text)
    {
        return $text;
    }
}
