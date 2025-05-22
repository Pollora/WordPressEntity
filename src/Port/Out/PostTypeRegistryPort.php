<?php

declare(strict_types=1);

namespace Pollora\Entity\Port\Out;

/**
 * Interface for post type registration in WordPress.
 */
interface PostTypeRegistryPort extends EntityRegistryPort
{
    /**
     * Registers a post type with WordPress.
     *
     * @param  string  $slug  The post type slug
     * @param  array  $args  Registration arguments
     * @param  array  $names  Post type names (singular, plural)
     */
    public function registerPostType(string $slug, array $args, array $names): void;
}
