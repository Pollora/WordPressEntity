<?php

declare(strict_types=1);

namespace Pollora\Entity\UI\Resources;

use Pollora\Entity\Domain\Models\PostType as PostTypeModel;
use Pollora\Entity\Infrastructure\Providers\EntityServiceProvider;
use Pollora\Entity\UI\Http\Controllers\PostTypeController;

/**
 * Facade for working with post types in WordPress.
 *
 * This class provides a static interface for creating and registering post types.
 */
class PostType
{
    /**
     * Service provider instance.
     */
    private static ?EntityServiceProvider $provider = null;

    /**
     * Controller instance.
     */
    private static ?PostTypeController $controller = null;

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
            self::$controller = new PostTypeController(
                self::$provider->get('Pollora\Entity\Application\Services\EntityFactoryService'),
                self::$provider->get('Pollora\Entity\Application\Services\EntityRegistrationService')
            );
        }
    }

    /**
     * Create a new post type.
     *
     * @param  string  $slug  The slug for the post type
     * @param  string|null  $singular  The singular name
     * @param  string|null  $plural  The plural name
     */
    public static function make(string $slug, ?string $singular = null, ?string $plural = null): PostTypeModel
    {
        self::init();

        return self::$controller->create($slug, $singular, $plural);
    }

    /**
     * Check if a post type exists.
     *
     * @param  string  $slug  The slug of the post type to check
     * @return bool True if the post type exists
     */
    public static function exists(string $slug): bool
    {
        self::init();

        return self::$controller->exists($slug);
    }

    /**
     * Unregister a post type.
     *
     * @param  string  $slug  The slug of the post type to unregister
     * @return bool True if unregistration was successful
     */
    public static function unregister(string $slug): bool
    {
        self::init();

        return self::$controller->unregister($slug);
    }
}
