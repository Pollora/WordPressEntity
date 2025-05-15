<?php

declare(strict_types=1);

namespace Pollora\Entity\Domain\Contracts;

/**
 * Interface for entity registration.
 *
 * Provides a common contract for different types of entity registrars.
 */
interface EntityRegistrarInterface
{
    /**
     * Register an entity with the system.
     *
     * @param  object  $entity  The entity to register
     * @return bool True if registration was successful
     */
    public function register(object $entity): bool;

    /**
     * Unregister an entity from the system.
     *
     * @param  string  $slug  The slug of the entity to unregister
     * @return bool True if unregistration was successful
     */
    public function unregister(string $slug): bool;

    /**
     * Check if an entity is registered.
     *
     * @param  string  $slug  The slug of the entity to check
     * @return bool True if the entity is registered
     */
    public function exists(string $slug): bool;
}
