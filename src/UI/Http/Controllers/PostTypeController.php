<?php

declare(strict_types=1);

namespace Pollora\Entity\UI\Http\Controllers;

use Pollora\Entity\Application\Services\EntityFactoryService;
use Pollora\Entity\Application\Services\EntityRegistrationService;
use Pollora\Entity\Domain\Models\PostType;

/**
 * Controller for managing post types.
 */
class PostTypeController
{
    /**
     * Constructor.
     *
     * @param  EntityFactoryService  $factoryService  Service for creating entities
     * @param  EntityRegistrationService  $registrationService  Service for registering entities
     */
    public function __construct(
        private EntityFactoryService $factoryService,
        private EntityRegistrationService $registrationService
    ) {}

    /**
     * Create a new post type.
     *
     * @param  string  $slug  The slug for the post type
     * @param  string|null  $singular  The singular name
     * @param  string|null  $plural  The plural name
     */
    public function create(string $slug, ?string $singular = null, ?string $plural = null): PostType
    {
        return $this->factoryService->createPostType($slug, $singular, $plural);
    }

    /**
     * Register a post type with the system.
     *
     * @param  PostType  $postType  The post type to register
     * @return bool True if registration was successful
     */
    public function register(PostType $postType): bool
    {
        return $this->registrationService->registerPostType($postType);
    }

    /**
     * Check if a post type exists.
     *
     * @param  string  $slug  The slug of the post type to check
     * @return bool True if the post type exists
     */
    public function exists(string $slug): bool
    {
        return $this->registrationService->postTypeExists($slug);
    }

    /**
     * Unregister a post type.
     *
     * @param  string  $slug  The slug of the post type to unregister
     * @return bool True if unregistration was successful
     */
    public function unregister(string $slug): bool
    {
        return $this->registrationService->unregisterPostType($slug);
    }
}
