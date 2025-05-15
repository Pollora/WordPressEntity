<?php

declare(strict_types=1);

namespace Pollora\Entity\Infrastructure\Repositories;

use Pollora\Entity\Domain\Contracts\EntityMapperInterface;
use Pollora\Entity\Domain\Contracts\EntityRegistrarInterface;
use Pollora\Entity\Domain\Models\Taxonomy;

/**
 * WordPress implementation of taxonomy registration.
 */
class WordPressTaxonomyRegistrar implements EntityRegistrarInterface
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
     * Register a taxonomy with WordPress.
     *
     * @param  object  $entity  The taxonomy entity to register
     * @return bool True if registration was successful
     *
     * @throws \InvalidArgumentException If the entity is not a Taxonomy
     */
    public function register(object $entity): bool
    {
        if (! $entity instanceof Taxonomy) {
            throw new \InvalidArgumentException(
                'Entity must be an instance of '.Taxonomy::class.', got '.get_class($entity)
            );
        }

        $data = $this->mapper->toInfrastructure($entity);
        $objectType = $data['object_type'] ?? '';
        $args = $data['args'] ?? [];
        $slug = $args['name'] ?? '';
        unset($args['name']);

        if (empty($slug)) {
            return false;
        }

        // Handle WordPress API
        $registerTaxonomy = function_exists('register_taxonomy') ? 'register_taxonomy' : null;
        if ($registerTaxonomy === null) {
            return false;
        }

        $result = $registerTaxonomy($slug, $objectType, $args);
        $isWpError = function_exists('is_wp_error') ? 'is_wp_error' : null;
        if ($isWpError === null) {
            return true; // Assume success if we can't check for errors
        }

        return ! $isWpError($result);
    }

    /**
     * Unregister a taxonomy from WordPress.
     *
     * @param  string  $slug  The slug of the taxonomy to unregister
     * @return bool True if unregistration was successful
     */
    public function unregister(string $slug): bool
    {
        if (! $this->exists($slug)) {
            return false;
        }

        $unregisterTaxonomy = function_exists('unregister_taxonomy') ? 'unregister_taxonomy' : null;
        if ($unregisterTaxonomy === null) {
            return false;
        }

        $result = $unregisterTaxonomy($slug);

        return $result === null; // WP returns null on success
    }

    /**
     * Check if a taxonomy is registered in WordPress.
     *
     * @param  string  $slug  The slug of the taxonomy to check
     * @return bool True if the taxonomy is registered
     */
    public function exists(string $slug): bool
    {
        $taxonomyExists = function_exists('taxonomy_exists') ? 'taxonomy_exists' : null;
        if ($taxonomyExists === null) {
            return false;
        }

        return $taxonomyExists($slug);
    }
}
