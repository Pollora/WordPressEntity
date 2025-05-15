<?php

declare(strict_types=1);

namespace Pollora\Entity\Domain\Contracts;

use Pollora\Entity\Domain\Models\PostType;

/**
 * Interface for post type registration.
 */
interface PostTypeRegistrarInterface
{
    /**
     * Register a post type with the system.
     *
     * @param  PostType  $postType  The post type to register
     * @return bool True if registration was successful
     */
    public function register(PostType $postType): bool;

    /**
     * Unregister a post type from the system.
     *
     * @param  string  $slug  The slug of the post type to unregister
     * @return bool True if unregistration was successful
     */
    public function unregister(string $slug): bool;

    /**
     * Check if a post type is registered.
     *
     * @param  string  $slug  The slug of the post type to check
     * @return bool True if the post type is registered
     */
    public function exists(string $slug): bool;
}
