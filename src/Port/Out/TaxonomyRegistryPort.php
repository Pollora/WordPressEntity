<?php

declare(strict_types=1);

namespace Pollora\Entity\Port\Out;

/**
 * Interface for taxonomy registration in WordPress.
 */
interface TaxonomyRegistryPort extends EntityRegistryPort
{
    /**
     * Registers a taxonomy with WordPress.
     *
     * @param  string  $slug  The taxonomy slug
     * @param  string|array<array-key, mixed>  $objectType  The post type(s) the taxonomy is associated with
     * @param  array<array-key, mixed>  $args  Registration arguments
     * @param  array<array-key, mixed>  $names  Taxonomy names (singular, plural)
     */
    public function registerTaxonomy(string $slug, string|array $objectType, array $args, array $names): void;
}
