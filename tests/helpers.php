<?php

declare(strict_types=1);

// Simulation of global WordPress functions
if (! function_exists('add_action')) {
    function add_action($hook, $callback, $priority = 10, $accepted_args = 1)
    {
        // Execute the callback immediately to simulate WordPress hook
        if ($hook === 'init') {
            $callback();
        }
    }
}

if (! function_exists('did_action')) {
    function did_action($hook)
    {
        return true; // Simulate that the action has already been triggered
    }
}

if (! function_exists('apply_filters')) {
    function apply_filters($tag, $value, ...$args)
    {
        return $value; // Return the value without modification
    }
}

if (! function_exists('error_log')) {
    function error_log($message)
    {
        // Do nothing in tests
    }
}

if (! function_exists('esc_html__')) {
    function esc_html__($text, $domain = 'default')
    {
        return $text;
    }
}

if (! function_exists('register_post_type')) {
    function register_post_type($slug, $args)
    {
        return true;
    }
}

if (! function_exists('register_taxonomy')) {
    function register_taxonomy($slug, $object_type, $args)
    {
        return true;
    }
}

// Mocked functions for Extended CPTs
if (! function_exists('register_extended_post_type')) {
    function register_extended_post_type($slug, $args = [], $names = [])
    {
        return new \Pollora\Entity\Domain\Model\PostType($slug, $names['singular'] ?? null, $names['plural'] ?? null);
    }
}

if (! function_exists('register_extended_taxonomy')) {
    function register_extended_taxonomy($slug, $object_type, $args = [], $names = [])
    {
        return new \Pollora\Entity\Domain\Model\Taxonomy($slug, $object_type, $names['singular'] ?? null, $names['plural'] ?? null);
    }
}

// Test helpers
if (! function_exists('getMethodFromMock')) {
    function getMethodFromMock($mock, $methodName)
    {
        return $mock->shouldReceive($methodName);
    }
}

// is_admin function
if (! function_exists('is_admin')) {
    function is_admin()
    {
        return false; // Simulate that we are not in the admin area
    }
}

if (! function_exists('wp_parse_args')) {
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

if (! function_exists('sanitize_text_field')) {
    function sanitize_text_field($str)
    {
        return $str;
    }
}

// Load the file with functions in the ExtCPTs namespace
require_once __DIR__.'/ext_cpts_helpers.php';
