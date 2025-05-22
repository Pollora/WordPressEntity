<?php

declare(strict_types=1);

namespace Pollora\Entity\Application\Service;

use Pollora\Entity\Domain\Model\Taxonomy;
use Pollora\Entity\Port\Out\TaxonomyRegistryPort;

/**
 * Service class for managing taxonomies.
 *
 * This service provides methods to register taxonomies with WordPress.
 */
class TaxonomyService
{
    private TaxonomyRegistryPort $taxonomyRegistry;

    private EntityRegistrationService $registrationService;

    /**
     * TaxonomyService constructor.
     *
     * @param  TaxonomyRegistryPort  $taxonomyRegistry  The taxonomy registry port implementation
     * @param  EntityRegistrationService  $registrationService  The entity registration service
     */
    public function __construct(
        TaxonomyRegistryPort $taxonomyRegistry,
        EntityRegistrationService $registrationService
    ) {
        $this->taxonomyRegistry = $taxonomyRegistry;
        $this->registrationService = $registrationService;
    }

    /**
     * Register a taxonomy with WordPress.
     *
     * This method registers a taxonomy with WordPress through the registration service.
     *
     * @param  Taxonomy  $taxonomy  The taxonomy to register
     */
    public function register(Taxonomy $taxonomy): void
    {
        $this->registrationService->registerEntity($taxonomy);
    }

    /**
     * Create and register a new taxonomy.
     *
     * This method creates a new taxonomy and registers it with WordPress.
     *
     * @param  string  $slug  The taxonomy slug
     * @param  string|array  $objectType  The post type(s) the taxonomy is associated with
     * @param  string|null  $singular  The singular label for the taxonomy
     * @param  string|null  $plural  The plural label for the taxonomy
     * @return Taxonomy The created taxonomy
     */
    public function createTaxonomy(string $slug, string|array $objectType, ?string $singular = null, ?string $plural = null): Taxonomy
    {
        $taxonomy = Taxonomy::make($slug, $objectType, $singular, $plural);
        $this->register($taxonomy);

        return $taxonomy;
    }
}
