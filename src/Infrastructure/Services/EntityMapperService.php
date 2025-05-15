<?php

declare(strict_types=1);

namespace Pollora\Entity\Infrastructure\Services;

use Pollora\Entity\Domain\Contracts\EntityMapperInterface;
use Pollora\Entity\Domain\Exceptions\PostTypeException;
use Pollora\Entity\Domain\Exceptions\TaxonomyException;
use Pollora\Entity\Domain\Models\PostType;
use Pollora\Entity\Domain\Models\Taxonomy;

/**
 * Service for mapping between domain entities and WordPress data structures.
 */
class EntityMapperService implements EntityMapperInterface
{
    /**
     * Transforms a domain entity into a WordPress-compatible format.
     *
     * @param  object  $entity  The domain entity to convert
     * @return array The entity data in WordPress format
     *
     * @throws \InvalidArgumentException If the entity type is not supported
     */
    public function toInfrastructure(object $entity): array
    {
        if ($entity instanceof PostType) {
            return $this->postTypeToWordPress($entity);
        }

        if ($entity instanceof Taxonomy) {
            return $this->taxonomyToWordPress($entity);
        }

        throw new \InvalidArgumentException('Unsupported entity type: '.get_class($entity));
    }

    /**
     * Transforms WordPress data into a domain entity.
     *
     * @param  array  $data  The WordPress data
     * @param  string  $entityType  The type of entity to create
     * @return object The domain entity
     *
     * @throws \InvalidArgumentException If the entity type is not supported
     */
    public function toDomain(array $data, string $entityType): object
    {
        return match ($entityType) {
            'post-type' => $this->wordPressToPostType($data),
            'taxonomy' => $this->wordPressToTaxonomy($data),
            default => throw new \InvalidArgumentException("Unsupported entity type: {$entityType}"),
        };
    }

    /**
     * Convert a PostType domain entity to WordPress format.
     *
     * @param  PostType  $postType  The post type domain entity
     * @return array WordPress register_post_type compatible array
     */
    private function postTypeToWordPress(PostType $postType): array
    {
        $args = $postType->toArray();

        // Special handling for property name transformations
        $transformations = $this->getPostTypeTransformations();

        return $this->applyTransformations($args, $transformations);
    }

    /**
     * Convert a Taxonomy domain entity to WordPress format.
     *
     * @param  Taxonomy  $taxonomy  The taxonomy domain entity
     * @return array WordPress register_taxonomy compatible array
     */
    private function taxonomyToWordPress(Taxonomy $taxonomy): array
    {
        $args = $taxonomy->toArray();
        $objectType = $args['objectType'] ?? null;
        unset($args['objectType']); // Remove as it's not an arg for register_taxonomy

        // Special handling for property name transformations
        $transformations = $this->getTaxonomyTransformations();

        $wpArgs = $this->applyTransformations($args, $transformations);

        // Return both the object type and args
        return [
            'object_type' => $objectType,
            'args' => $wpArgs,
        ];
    }

    /**
     * Convert WordPress data to a PostType domain entity.
     *
     * @param  array  $data  The WordPress data
     *
     * @throws PostTypeException If the required data is missing
     */
    private function wordPressToPostType(array $data): PostType
    {
        if (! isset($data['name'])) {
            throw new PostTypeException('Post type name is required');
        }

        $slug = $data['name'];
        $singular = $data['labels']['singular_name'] ?? null;
        $plural = $data['labels']['name'] ?? null;

        $postType = new PostType($slug, $singular, $plural);

        // Map WordPress properties to domain properties
        $transformations = array_flip($this->getPostTypeTransformations());
        $domainData = $this->applyTransformations($data, $transformations);

        // Set properties using reflection
        $this->setEntityProperties($postType, $domainData);

        return $postType;
    }

    /**
     * Convert WordPress data to a Taxonomy domain entity.
     *
     * @param  array  $data  The WordPress data
     *
     * @throws TaxonomyException If the required data is missing
     */
    private function wordPressToTaxonomy(array $data): Taxonomy
    {
        if (! isset($data['name'])) {
            throw new TaxonomyException('Taxonomy name is required');
        }

        if (! isset($data['object_type'])) {
            throw new TaxonomyException('Taxonomy object type is required');
        }

        $slug = $data['name'];
        $objectType = $data['object_type'];
        $singular = $data['labels']['singular_name'] ?? null;
        $plural = $data['labels']['name'] ?? null;

        $taxonomy = new Taxonomy($slug, $objectType, $singular, $plural);

        // Map WordPress properties to domain properties
        $transformations = array_flip($this->getTaxonomyTransformations());
        $domainData = $this->applyTransformations($data, $transformations);

        // Set properties using reflection
        $this->setEntityProperties($taxonomy, $domainData);

        return $taxonomy;
    }

    /**
     * Set entity properties using reflection.
     *
     * @param  object  $entity  The entity to modify
     * @param  array  $properties  The properties to set
     */
    private function setEntityProperties(object $entity, array $properties): void
    {
        $reflection = new \ReflectionClass($entity);

        foreach ($properties as $property => $value) {
            if (property_exists($entity, $property)) {
                $reflectionProperty = $reflection->getProperty($property);
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($entity, $value);
            }
        }
    }

    /**
     * Apply transformations to property names.
     *
     * @param  array  $data  The data to transform
     * @param  array  $transformations  Map of property names to transform
     * @return array The transformed data
     */
    private function applyTransformations(array $data, array $transformations): array
    {
        $result = [];

        foreach ($data as $key => $value) {
            $transformedKey = $transformations[$key] ?? $key;
            $result[$transformedKey] = $value;
        }

        return $result;
    }

    /**
     * Get the property name transformations for post types.
     *
     * Maps from domain model property names to WordPress property names.
     */
    private function getPostTypeTransformations(): array
    {
        return [
            'slug' => 'name',
            'menuPosition' => 'menu_position',
            'menuIcon' => 'menu_icon',
            'showInAdminBar' => 'show_in_admin_bar',
            'capabilityType' => 'capability_type',
            'mapMetaCap' => 'map_meta_cap',
            'registerMetaBoxCb' => 'register_meta_box_cb',
            'hasArchive' => 'has_archive',
            'canExport' => 'can_export',
            'deleteWithUser' => 'delete_with_user',
            'templateLock' => 'template_lock',
            'excludeFromSearch' => 'exclude_from_search',
            'publiclyQueryable' => 'publicly_queryable',
            'showUi' => 'show_ui',
            'showInMenu' => 'show_in_menu',
            'showInNavMenus' => 'show_in_nav_menus',
            'queryVar' => 'query_var',
            'showInRest' => 'show_in_rest',
            'restBase' => 'rest_base',
            'restNamespace' => 'rest_namespace',
            'restControllerClass' => 'rest_controller_class',
            'dashboardGlance' => 'dashboard_glance',
            'adminCols' => 'admin_cols',
        ];
    }

    /**
     * Get the property name transformations for taxonomies.
     *
     * Maps from domain model property names to WordPress property names.
     */
    private function getTaxonomyTransformations(): array
    {
        return [
            'slug' => 'name',
            'showTagcloud' => 'show_tagcloud',
            'showInQuickEdit' => 'show_in_quick_edit',
            'showAdminColumn' => 'show_admin_column',
            'metaBoxCb' => 'meta_box_cb',
            'metaBoxSanitizeCb' => 'meta_box_sanitize_cb',
            'updateCountCallback' => 'update_count_callback',
            'defaultTerm' => 'default_term',
            'publiclyQueryable' => 'publicly_queryable',
            'showUi' => 'show_ui',
            'showInMenu' => 'show_in_menu',
            'showInNavMenus' => 'show_in_nav_menus',
            'queryVar' => 'query_var',
            'showInRest' => 'show_in_rest',
            'restBase' => 'rest_base',
            'restNamespace' => 'rest_namespace',
            'restControllerClass' => 'rest_controller_class',
            'dashboardGlance' => 'dashboard_glance',
            'adminCols' => 'admin_cols',
            'checkedOntop' => 'checked_ontop',
            'allowHierarchy' => 'allow_hierarchy',
        ];
    }
}
