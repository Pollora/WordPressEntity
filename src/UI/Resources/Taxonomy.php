<?php

declare(strict_types=1);

namespace Pollora\Entity\UI\Resources;

use Pollora\Entity\Domain\Models\Taxonomy as TaxonomyModel;
use Pollora\Entity\Infrastructure\Providers\EntityServiceProvider;
use Pollora\Entity\UI\Http\Controllers\TaxonomyController;

/**
 * Facade for working with taxonomies in WordPress.
 *
 * This class provides a static interface for creating and registering taxonomies.
 */
class Taxonomy
{
    /**
     * Service provider instance.
     */
    private static ?EntityServiceProvider $provider = null;

    /**
     * Controller instance.
     */
    private static ?TaxonomyController $controller = null;

    /**
     * Initialize the provider and controller.
     */
    private static function init(): void
    {
        if (self::$provider === null) {
            self::$provider = new EntityServiceProvider;
            self::$provider->register();
        }

        if (self::$controller === null) {
            self::$controller = new TaxonomyController(
                self::$provider->get('Pollora\Entity\Application\Services\EntityFactoryService'),
                self::$provider->get('Pollora\Entity\Application\Services\EntityRegistrationService')
            );
        }
    }

    /**
     * Create a new taxonomy.
     *
     * @param  string  $slug  The slug for the taxonomy
     * @param  string|array  $objectType  The post type(s) to associate with
     * @param  string|null  $singular  The singular name
     * @param  string|null  $plural  The plural name
     */
    public static function make(string $slug, string|array $objectType, ?string $singular = null, ?string $plural = null): TaxonomyModel
    {
        self::init();

        return self::$controller->create($slug, $objectType, $singular, $plural);
    }

    /**
     * Check if a taxonomy exists.
     *
     * @param  string  $slug  The slug of the taxonomy to check
     * @return bool True if the taxonomy exists
     */
    public static function exists(string $slug): bool
    {
        self::init();

        return self::$controller->exists($slug);
    }

    /**
     * Unregister a taxonomy.
     *
     * @param  string  $slug  The slug of the taxonomy to unregister
     * @return bool True if unregistration was successful
     */
    public static function unregister(string $slug): bool
    {
        self::init();

        return self::$controller->unregister($slug);
    }
}
