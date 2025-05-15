<?php

declare(strict_types=1);

namespace Pollora\Entity\UI\Http\Controllers;

use Pollora\Entity\Application\Services\EntityFactoryService;
use Pollora\Entity\Application\Services\EntityRegistrationService;
use Pollora\Entity\Domain\Models\Taxonomy;

/**
 * Controller for managing taxonomies.
 */
class TaxonomyController
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
     * Create a new taxonomy.
     *
     * @param  string  $slug  The slug for the taxonomy
     * @param  string|array  $objectType  The post type(s) to associate this taxonomy with
     * @param  string|null  $singular  The singular name
     * @param  string|null  $plural  The plural name
     */
    public function create(string $slug, string|array $objectType, ?string $singular = null, ?string $plural = null): Taxonomy
    {
        return $this->factoryService->createTaxonomy($slug, $objectType, $singular, $plural);
    }

    /**
     * Register a taxonomy with the system.
     *
     * @param  Taxonomy  $taxonomy  The taxonomy to register
     * @return bool True if registration was successful
     */
    public function register(Taxonomy $taxonomy): bool
    {
        return $this->registrationService->registerTaxonomy($taxonomy);
    }

    /**
     * Check if a taxonomy exists.
     *
     * @param  string  $slug  The slug of the taxonomy to check
     * @return bool True if the taxonomy exists
     */
    public function exists(string $slug): bool
    {
        return $this->registrationService->taxonomyExists($slug);
    }

    /**
     * Unregister a taxonomy.
     *
     * @param  string  $slug  The slug of the taxonomy to unregister
     * @return bool True if unregistration was successful
     */
    public function unregister(string $slug): bool
    {
        return $this->registrationService->unregisterTaxonomy($slug);
    }
}
