<?php

declare(strict_types=1);

namespace Pollora\Entity\Application\Service;

use Pollora\Entity\Domain\Model\PostType;
use Pollora\Entity\Port\Out\PostTypeRegistryPort;

/**
 * Service class for managing post types.
 *
 * This service provides methods to register post types with WordPress.
 */
class PostTypeService
{
    private PostTypeRegistryPort $postTypeRegistry;

    private EntityRegistrationService $registrationService;

    /**
     * PostTypeService constructor.
     *
     * @param  PostTypeRegistryPort  $postTypeRegistry  The post type registry port implementation
     * @param  EntityRegistrationService  $registrationService  The entity registration service
     */
    public function __construct(
        PostTypeRegistryPort $postTypeRegistry,
        EntityRegistrationService $registrationService
    ) {
        $this->postTypeRegistry = $postTypeRegistry;
        $this->registrationService = $registrationService;
    }

    /**
     * Register a post type with WordPress.
     *
     * This method registers a post type with WordPress through the registration service.
     *
     * @param  PostType  $postType  The post type to register
     */
    public function register(PostType $postType): void
    {
        $this->registrationService->registerEntity($postType);
    }

    /**
     * Create and register a new post type.
     *
     * This method creates a new post type and registers it with WordPress.
     *
     * @param  string  $slug  The post type slug
     * @param  string|null  $singular  The singular label for the post type
     * @param  string|null  $plural  The plural label for the post type
     * @return PostType The created post type
     */
    public function createPostType(string $slug, ?string $singular = null, ?string $plural = null): PostType
    {
        $postType = PostType::make($slug, $singular, $plural);
        $this->register($postType);

        return $postType;
    }
}
