<?php

declare(strict_types=1);

namespace Pollora\Entity\Port\Out;

/**
 * Interface for entity registration in WordPress.
 *
 * This port defines how domain entities (post types and taxonomies)
 * will be registered with WordPress.
 */
interface EntityRegistryPort
{
    /**
     * Registers an entity with WordPress.
     *
     * @param  string  $slug  The entity slug
     * @param  array  $args  Registration arguments
     * @param  array  $names  Entity names (singular, plural)
     */
    public function register(string $slug, array $args, array $names): void;
}
