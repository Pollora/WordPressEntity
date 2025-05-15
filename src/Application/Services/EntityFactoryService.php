<?php

declare(strict_types=1);

namespace Pollora\Entity\Application\Services;

use Pollora\Entity\Domain\Models\PostType;
use Pollora\Entity\Domain\Models\Taxonomy;

/**
 * Service for creating entity instances.
 *
 * This service provides factory methods for creating domain entities
 * with a fluent interface.
 */
class EntityFactoryService
{
    /**
     * Create a new post type.
     *
     * @param  string  $slug  The slug for the post type
     * @param  string|null  $singular  The singular name
     * @param  string|null  $plural  The plural name
     */
    public function createPostType(string $slug, ?string $singular = null, ?string $plural = null): PostType
    {
        return PostType::make($slug, $singular, $plural);
    }

    /**
     * Create a new taxonomy.
     *
     * @param  string  $slug  The slug for the taxonomy
     * @param  string|array  $objectType  The post type(s) to associate with
     * @param  string|null  $singular  The singular name
     * @param  string|null  $plural  The plural name
     */
    public function createTaxonomy(string $slug, string|array $objectType, ?string $singular = null, ?string $plural = null): Taxonomy
    {
        return Taxonomy::make($slug, $objectType, $singular, $plural);
    }
}
