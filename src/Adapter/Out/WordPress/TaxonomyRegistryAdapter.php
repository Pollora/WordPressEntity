<?php

declare(strict_types=1);

namespace Pollora\Entity\Adapter\Out\WordPress;

use Pollora\Entity\Port\Out\TaxonomyRegistryPort;

/**
 * WordPress adapter for registering taxonomies.
 *
 * This adapter implements the TaxonomyRegistryPort interface and registers
 * taxonomies with WordPress using either the extended or standard registration functions.
 */
class TaxonomyRegistryAdapter implements TaxonomyRegistryPort
{
    /**
     * Registers an entity with WordPress.
     *
     * This is a generic method that delegates to the specific taxonomy registration method.
     *
     * @param  string  $slug  The entity slug
     * @param  array<array-key, mixed>  $args  Registration arguments
     * @param  array<array-key, mixed>  $names  Entity names (singular, plural)
     */
    public function register(string $slug, array $args, array $names): void
    {
        // This is a simplified implementation as we need the objectType parameter
        // for taxonomy registration. In practice, you would pass the objectType
        // through a separate setter or extract it from the args.
        if (isset($args['object_type'])) {
            $this->registerTaxonomy($slug, $args['object_type'], $args, $names);
            unset($args['object_type']);
        }
    }

    /**
     * Registers a taxonomy with WordPress.
     *
     * Uses register_extended_taxonomy if available, or falls back to register_taxonomy.
     *
     * @param  string  $slug  The taxonomy slug
     * @param  string|array<array-key, mixed>  $objectType  The post type(s) the taxonomy is associated with
     * @param  array<array-key, mixed>  $args  Registration arguments
     * @param  array<array-key, mixed>  $names  Taxonomy names (singular, plural)
     */
    public function registerTaxonomy(string $slug, string|array $objectType, array $args, array $names): void
    {
        // Use global namespace for the function
        if (function_exists('\\register_extended_taxonomy')) {
            \register_extended_taxonomy($slug, $objectType, $args, $names);
        } else {
            $this->fallbackToStandardTaxonomyRegistration($slug, $objectType, $args, $names);
        }
    }

    /**
     * Fallback to standard WordPress taxonomy registration if extended registration fails
     *
     * @param  string  $slug  Taxonomy slug
     * @param  string|array<array-key, mixed>  $objectType  Post type(s) to register the taxonomy for
     * @param  array<array-key, mixed>  $args  Arguments for taxonomy
     * @param  array<array-key, mixed>  $names  Names for taxonomy
     */
    protected function fallbackToStandardTaxonomyRegistration(string $slug, string|array $objectType, array $args, array $names): void
    {
        if (! function_exists('\\register_taxonomy')) {
            throw new WordPressFunctionMissingException('The register_taxonomy function is not available.');
        }

        // Merge names into args
        if ($names !== []) {
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

        \register_taxonomy($customSlug, $objectType, $args);
    }
}
