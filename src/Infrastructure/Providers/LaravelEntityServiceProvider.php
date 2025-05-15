<?php

declare(strict_types=1);

namespace Pollora\Entity\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Pollora\Entity\Application\Services\EntityFactoryService;
use Pollora\Entity\Application\Services\EntityRegistrationService;
use Pollora\Entity\Domain\Contracts\ArgumentTranslatorInterface;
use Pollora\Entity\Domain\Contracts\EntityRegistrarInterface;
use Pollora\Entity\Infrastructure\Repositories\WordPressPostTypeRegistrar;
use Pollora\Entity\Infrastructure\Repositories\WordPressTaxonomyRegistrar;
use Pollora\Entity\Infrastructure\Services\EntityMapperService;
use Pollora\Entity\Infrastructure\Services\LaravelArgumentTranslator;

/**
 * Laravel service provider for the Entity package.
 *
 * Registers all necessary services for using the Entity package in a Laravel application.
 */
class LaravelEntityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the entity mapper
        $this->app->singleton(EntityMapperService::class);

        // Register registrars
        $this->app->singleton('entity.post-type.registrar', function ($app) {
            return new WordPressPostTypeRegistrar(
                $app->make(EntityMapperService::class)
            );
        });

        $this->app->singleton('entity.taxonomy.registrar', function ($app) {
            return new WordPressTaxonomyRegistrar(
                $app->make(EntityMapperService::class)
            );
        });

        // Bind the registrars to the interface
        $this->app->when(EntityRegistrationService::class)
            ->needs(EntityRegistrarInterface::class)
            ->give(function ($app) {
                return $app->make('entity.post-type.registrar');
            });

        // Register the translator
        $this->app->singleton(ArgumentTranslatorInterface::class, function ($app) {
            return new LaravelArgumentTranslator;
        });

        // Register the application services
        $this->app->singleton(EntityFactoryService::class);
        $this->app->singleton(EntityRegistrationService::class, function ($app) {
            return new EntityRegistrationService(
                $app->make('entity.post-type.registrar'),
                $app->make('entity.taxonomy.registrar'),
                $app->make(ArgumentTranslatorInterface::class)
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish translations
        $this->publishes([
            __DIR__.'/../../../resources/lang' => resource_path('lang/vendor/entity'),
        ], 'entity-translations');
    }
}
