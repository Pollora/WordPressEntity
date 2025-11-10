<?php

declare(strict_types=1);

namespace Pollora\Entity\Application\Service;

use Pollora\Entity\Domain\Model\Entity;
use Pollora\Entity\Port\Out\EntityRegistryPort;

/**
 * Application service that manages the registration of entities with WordPress.
 *
 * This service is responsible for coordinating the process of preparing entity
 * arguments and delegating the actual registration to the appropriate adapter.
 */
class EntityRegistrationService
{
    /**
     * @var EntityRegistryPort The entity registry port implementation
     */
    private EntityRegistryPort $entityRegistry;

    /**
     * EntityRegistrationService constructor.
     *
     * @param  EntityRegistryPort  $entityRegistry  The entity registry port implementation
     */
    public function __construct(EntityRegistryPort $entityRegistry)
    {
        $this->entityRegistry = $entityRegistry;
    }

    /**
     * Register an entity with WordPress.
     *
     * This method prepares the arguments for the entity and registers it with WordPress
     * using the entity registry adapter.
     *
     * @param  Entity  $entity  The entity to register
     */
    public function registerEntity(Entity $entity): void
    {
        // Hook the actual registration to WordPress init hook
        \add_action('init', function () use ($entity) {
            $entityType = $entity->getEntity() ?? 'unknown';
            $slug = $entity->getSlug() ?? 'unknown';

            $args = $entity->getArgs();

            $args['names'] = $entity->getNames();

            $args = $entity->translateArguments($args, $entity->getEntity());
            $names = $args['names'] ?? [];
            unset($args['names']);

            $this->entityRegistry->register($entity->getSlug(), $args, $names);

        }, 5);
    }
}
