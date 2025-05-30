<?php

declare(strict_types=1);

namespace Pollora\Entity;

use Pollora\Entity\Adapter\Out\WordPress\PostTypeRegistryAdapter;
use Pollora\Entity\Application\Service\EntityRegistrationService;
use Pollora\Entity\Domain\Model\PostType as PostTypeDomain;

/**
 * Facade class for the PostType entity.
 *
 * This class provides a simple way to create and register post types with WordPress
 * while using the hexagonal architecture internally.
 */
class PostType
{
    /**
     * Create a new post type.
     *
     * @param  string  $slug  The slug of the post type.
     * @param  string|null  $singular  The singular label for the post type.
     * @param  string|null  $plural  The plural label for the post type.
     * @return PostTypeDomain The created post type domain model.
     */
    public static function make(string $slug, ?string $singular = null, ?string $plural = null): PostTypeDomain
    {
        // Create the domain model directly with the slug
        $postType = new PostTypeDomain($slug, $singular, $plural);

        // Initialize the post type (this sets defaults)
        $postType->init();

        // Auto-register with WordPress using the entity registration service
        $registry = new PostTypeRegistryAdapter;
        $registrationService = new EntityRegistrationService($registry);
        $registrationService->registerEntity($postType);

        return $postType;
    }
}
