<?php

declare(strict_types=1);

namespace Pollora\Entity\Adapter\Out\WordPress;

use Pollora\Entity\Port\Out\PostTypeRegistryPort;

/**
 * WordPress adapter for registering post types.
 *
 * This adapter implements the PostTypeRegistryPort interface and registers
 * post types with WordPress using either the extended or standard registration functions.
 */
class PostTypeRegistryAdapter implements PostTypeRegistryPort
{
    /**
     * Registers an entity with WordPress.
     *
     * This is a generic method that delegates to the specific post type registration method.
     *
     * @param  string  $slug  The entity slug
     * @param  array  $args  Registration arguments
     * @param  array  $names  Entity names (singular, plural)
     */
    public function register(string $slug, array $args, array $names): void
    {
        $this->registerPostType($slug, $args, $names);
    }

    /**
     * Registers a post type with WordPress.
     *
     * Uses register_extended_post_type if available, or falls back to register_post_type.
     *
     * @param  string  $slug  The post type slug
     * @param  array  $args  Registration arguments
     * @param  array  $names  Post type names (singular, plural)
     */
    public function registerPostType(string $slug, array $args, array $names): void
    {
        // Check if required WordPress functions exist
        if (! function_exists('\\register_post_type') && ! function_exists('\\register_extended_post_type')) {
            return;
        }

        // Use global namespace for the function
        if (function_exists('\\register_extended_post_type')) {
            try {
                \register_extended_post_type($slug, $args, $names);
            } catch (\Exception $e) {
                // Fallback to standard WordPress function
                $this->fallbackToStandardPostTypeRegistration($slug, $args, $names);
            }
        } else {
            $this->fallbackToStandardPostTypeRegistration($slug, $args, $names);
        }
    }

    /**
     * Fallback to standard WordPress post type registration if extended registration fails
     *
     * @param  string  $slug  Post type slug
     * @param  array  $args  Arguments for post type
     * @param  array  $names  Names for post type
     */
    protected function fallbackToStandardPostTypeRegistration(string $slug, array $args, array $names): void
    {
        if (function_exists('\\register_post_type')) {
            try {
                // Merge names into args
                if (! empty($names)) {
                    if (isset($names['singular'])) {
                        $args['labels']['singular_name'] = $names['singular'];
                    }
                    if (isset($names['plural'])) {
                        $args['labels']['name'] = $names['plural'];
                    }
                    if (isset($names['slug'])) {
                        // Use the slug from names if provided
                        $customSlug = $names['slug'];
                    } else {
                        $customSlug = $slug;
                    }
                } else {
                    $customSlug = $slug;
                }

                \register_post_type($customSlug, $args);
            } catch (\Exception $e) {
            }
        }
    }
}
