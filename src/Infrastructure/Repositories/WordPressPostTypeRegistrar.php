<?php

declare(strict_types=1);

namespace Pollora\Entity\Infrastructure\Repositories;

use Pollora\Entity\Domain\Contracts\EntityMapperInterface;
use Pollora\Entity\Domain\Contracts\EntityRegistrarInterface;
use Pollora\Entity\Domain\Models\PostType;

/**
 * WordPress implementation of post type registration.
 */
class WordPressPostTypeRegistrar implements EntityRegistrarInterface
{
    /**
     * Constructor.
     *
     * @param  EntityMapperInterface  $mapper  The entity mapper service
     */
    public function __construct(
        private EntityMapperInterface $mapper
    ) {}

    /**
     * Register a post type with WordPress.
     *
     * @param  object  $entity  The post type entity to register
     * @return bool True if registration was successful
     *
     * @throws \InvalidArgumentException If the entity is not a PostType
     */
    public function register(object $entity): bool
    {
        if (! $entity instanceof PostType) {
            throw new \InvalidArgumentException(
                'Entity must be an instance of '.PostType::class.', got '.get_class($entity)
            );
        }

        $args = $this->mapper->toInfrastructure($entity);
        $slug = $args['name'] ?? '';
        unset($args['name']);

        if (empty($slug)) {
            return false;
        }

        // Handle WordPress API
        $registerPostType = function_exists('register_post_type') ? 'register_post_type' : null;
        if ($registerPostType === null) {
            return false;
        }

        $result = $registerPostType($slug, $args);
        $isWpError = function_exists('is_wp_error') ? 'is_wp_error' : null;
        if ($isWpError === null) {
            return true; // Assume success if we can't check for errors
        }

        return ! $isWpError($result);
    }

    /**
     * Unregister a post type from WordPress.
     *
     * @param  string  $slug  The slug of the post type to unregister
     * @return bool True if unregistration was successful
     */
    public function unregister(string $slug): bool
    {
        if (! $this->exists($slug)) {
            return false;
        }

        $unregisterPostType = function_exists('unregister_post_type') ? 'unregister_post_type' : null;
        if ($unregisterPostType === null) {
            return false;
        }

        $result = $unregisterPostType($slug);

        return $result === null; // WP returns null on success
    }

    /**
     * Check if a post type is registered in WordPress.
     *
     * @param  string  $slug  The slug of the post type to check
     * @return bool True if the post type is registered
     */
    public function exists(string $slug): bool
    {
        $postTypeExists = function_exists('post_type_exists') ? 'post_type_exists' : null;
        if ($postTypeExists === null) {
            return false;
        }

        return $postTypeExists($slug);
    }
}
