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
        // Check if WordPress functions are available
        if (! function_exists('\\add_action')) {
            if (function_exists('\\error_log')) {
                \error_log('Cannot register entity: add_action function not available');
            }

            return;
        }

        // Hook the actual registration to WordPress init hook
        \add_action('init', function () use ($entity) {
            $entityType = $entity->getEntity() ?? 'unknown';
            $slug = $entity->getSlug() ?? 'unknown';

            if (function_exists('\\error_log')) {
                \error_log("WordPress init hook triggered for: {$entityType} - {$slug}");
            }

            try {
                $args = $entity->buildArguments();
                $args['names'] = $entity->getNames();

                $args = $entity->translateArguments($args, $entity->getEntity());
                $names = $args['names'] ?? [];
                unset($args['names']);

                if (function_exists('\\error_log')) {
                    \error_log('Registration args: '.json_encode($args));
                    \error_log('Registration names: '.json_encode($names));
                }

                $this->entityRegistry->register($entity->getSlug(), $args, $names);
            } catch (\Exception $e) {
                if (function_exists('\\error_log')) {
                    \error_log('Error during entity registration: '.$e->getMessage());
                }
            }
        }, 99);
    }
}
