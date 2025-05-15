<?php

declare(strict_types=1);

namespace Pollora\Entity\Domain\Contracts;

/**
 * Interface for mapping between domain models and infrastructure data.
 *
 * This provides a way to convert domain models to the format expected by infrastructure
 * components without exposing domain models to WordPress dependencies.
 */
interface EntityMapperInterface
{
    /**
     * Convert a domain entity to an infrastructure format.
     *
     * @param  object  $entity  The domain entity to convert
     * @return array The entity data in the format required by the infrastructure
     */
    public function toInfrastructure(object $entity): array;

    /**
     * Convert infrastructure data to a domain entity.
     *
     * @param  array  $data  The infrastructure data
     * @param  string  $entityType  The type of entity to create
     * @return object The domain entity
     */
    public function toDomain(array $data, string $entityType): object;
}
