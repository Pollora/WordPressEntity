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
            if (function_exists('\\error_log')) {
                \error_log('Cannot register post type: Neither register_post_type nor register_extended_post_type functions are available');
            }

            return;
        }

        // Use global namespace for the function
        if (function_exists('\\register_extended_post_type')) {
            try {
                if (function_exists('\\error_log')) {
                    \error_log("Calling register_extended_post_type for {$slug} with args: ".json_encode($args));
                    \error_log('Names: '.json_encode($names));
                }

                \register_extended_post_type($slug, $args, $names);

                if (function_exists('\\error_log')) {
                    \error_log("Successfully registered extended post type: {$slug}");
                }
            } catch (\Exception $e) {
                if (function_exists('\\error_log')) {
                    \error_log('Error registering extended post type: '.$e->getMessage());
                }

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

                if (function_exists('\\error_log')) {
                    \error_log("Falling back to standard register_post_type for {$customSlug}");
                }

                \register_post_type($customSlug, $args);

                if (function_exists('\\error_log')) {
                    \error_log("Successfully registered standard post type: {$customSlug}");
                }
            } catch (\Exception $e) {
                if (function_exists('\\error_log')) {
                    \error_log('Error in fallback post type registration: '.$e->getMessage());
                }
            }
        } elseif (function_exists('\\error_log')) {
            \error_log('Cannot register post type: register_post_type function not available');
        }
    }
}
