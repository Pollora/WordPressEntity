<?php

declare(strict_types=1);

namespace Pollora\Entity\Application\Service;

use Pollora\Entity\Domain\Model\PostType;
use Pollora\Entity\Port\Out\PostTypeRegistryPort;

class PostTypeService
{
    private PostTypeRegistryPort $postTypeRegistry;

    private EntityRegistrationService $entityRegistrationService;

    public function __construct(
        PostTypeRegistryPort $postTypeRegistry,
        EntityRegistrationService $entityRegistrationService
    ) {
        $this->postTypeRegistry = $postTypeRegistry;
        $this->entityRegistrationService = $entityRegistrationService;
    }

    public function createPostType(string $slug, string $singular, string $plural): PostType
    {
        $postType = new PostType($slug, $singular, $plural);
        $this->entityRegistrationService->registerEntity($postType);

        return $postType;
    }

    public function register(PostType $postType): void
    {
        $this->entityRegistrationService->registerEntity($postType);
    }
}
