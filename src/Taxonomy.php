<?php

declare(strict_types=1);

namespace Pollora\Entity;

use Pollora\Entity\Adapter\Out\WordPress\TaxonomyRegistryAdapter;
use Pollora\Entity\Application\Service\EntityRegistrationService;
use Pollora\Entity\Application\Service\TaxonomyService;
use Pollora\Entity\Domain\Model\Taxonomy as TaxonomyDomain;

/**
 * Facade class for the Taxonomy entity.
 *
 * This class provides a simple way to create and register taxonomies with WordPress
 * while using the hexagonal architecture internally.
 */
class Taxonomy
{
    /**
     * Create a new taxonomy.
     *
     * @param  string  $slug  The slug of the taxonomy.
     * @param  string|array  $objectType  The post type(s) to associate with this taxonomy.
     * @param  string|null  $singular  The singular label for the taxonomy.
     * @param  string|null  $plural  The plural label for the taxonomy.
     * @return TaxonomyDomain The created taxonomy domain model.
     */
    public static function make(string $slug, string|array $objectType, ?string $singular = null, ?string $plural = null): TaxonomyDomain
    {
        // Create the adapter and services
        $taxonomyRegistry = new TaxonomyRegistryAdapter;
        $registrationService = new EntityRegistrationService($taxonomyRegistry);
        $taxonomyService = new TaxonomyService($taxonomyRegistry, $registrationService);

        // Create and register the taxonomy
        return $taxonomyService->createTaxonomy($slug, $objectType, $singular, $plural);
    }
}
