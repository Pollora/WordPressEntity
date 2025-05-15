<?php

declare(strict_types=1);

namespace Pollora\Entity\Infrastructure\Providers;

use Pollora\Entity\Application\Services\EntityFactoryService;
use Pollora\Entity\Application\Services\EntityRegistrationService;
use Pollora\Entity\Domain\Contracts\EntityMapperInterface;
use Pollora\Entity\Infrastructure\Repositories\WordPressPostTypeRegistrar;
use Pollora\Entity\Infrastructure\Repositories\WordPressTaxonomyRegistrar;
use Pollora\Entity\Infrastructure\Services\EntityMapperService;
use Pollora\Entity\Domain\Contracts\ArgumentFormatterInterface;
use Pollora\Entity\Infrastructure\Services\ArgumentFormatterService;

/**
 * Service provider for entity-related services.
 *
 * This provider creates and manages entity services for WordPress.
 */
class EntityServiceProvider
{
    /**
     * The container for services.
     */
    private array $container = [];

    /**
     * Register all service dependencies.
     */
    public function register(): void
    {
        // Register the entity mapper
        $this->container[EntityMapperInterface::class] = new EntityMapperService;

        // Register the registrars
        $mapper = $this->container[EntityMapperInterface::class];
        $this->container['entity.post-type.registrar'] = new WordPressPostTypeRegistrar($mapper);
        $this->container['entity.taxonomy.registrar'] = new WordPressTaxonomyRegistrar($mapper);

        // Register the application services
        $this->container[EntityRegistrationService::class] = new EntityRegistrationService(
            $this->container['entity.post-type.registrar'],
            $this->container['entity.taxonomy.registrar']
        );

        $this->container[EntityFactoryService::class] = new EntityFactoryService;

        $this->container[ArgumentFormatterInterface::class] = new ArgumentFormatterService;
    }

    /**
     * Initialize and hook into WordPress.
     */
    public function boot(): void
    {
        // Nothing to boot directly
    }

    /**
     * Get a service from the container.
     *
     * @param  string  $id  Service identifier
     * @return mixed The requested service
     *
     * @throws \InvalidArgumentException If the service doesn't exist
     */
    public function get(string $id): mixed
    {
        if (! $this->has($id)) {
            throw new \InvalidArgumentException("Service '{$id}' not found in container");
        }

        return $this->container[$id];
    }

    /**
     * Check if a service exists in the container.
     *
     * @param  string  $id  Service identifier
     * @return bool True if the service exists
     */
    public function has(string $id): bool
    {
        return isset($this->container[$id]);
    }
}
