<?php

declare(strict_types=1);

namespace Pollora\Entity\Domain\Contracts;

use Pollora\Entity\Domain\Models\Taxonomy;

/**
 * Interface for taxonomy registration.
 */
interface TaxonomyRegistrarInterface
{
    /**
     * Register a taxonomy with the system.
     *
     * @param  Taxonomy  $taxonomy  The taxonomy to register
     * @return bool True if registration was successful
     */
    public function register(Taxonomy $taxonomy): bool;

    /**
     * Unregister a taxonomy from the system.
     *
     * @param  string  $slug  The slug of the taxonomy to unregister
     * @return bool True if unregistration was successful
     */
    public function unregister(string $slug): bool;

    /**
     * Check if a taxonomy is registered.
     *
     * @param  string  $slug  The slug of the taxonomy to check
     * @return bool True if the taxonomy is registered
     */
    public function exists(string $slug): bool;
}
