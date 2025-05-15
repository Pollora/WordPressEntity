# Taxonomy Documentation

This document details how to work with taxonomies in the Pollora Entity package.

## Basic Usage

### Creating a Taxonomy

The most straightforward way to create a taxonomy is with the static `make()` method:

```php
<?php

use Pollora\Entity\UI\Resources\Taxonomy;

$genreTaxonomy = Taxonomy::make('genre', 'book', 'Genre', 'Genres');
```

The parameters are:
1. `$slug`: The taxonomy slug (required)
2. `$objectType`: The post type(s) to associate this taxonomy with (required)
3. `$singular`: The singular label (optional)
4. `$plural`: The plural label (optional)

### Registering a Taxonomy

After configuring your taxonomy, register it with WordPress:

```php
$genreTaxonomy->register();
```

Typically, you'll want to do this during the WordPress `init` action:

```php
add_action('init', function() {
    Taxonomy::make('genre', 'book', 'Genre', 'Genres')
        ->hierarchical()
        ->showInRest()
        ->register();
});
```

## Taxonomy Configuration

The package provides a fluent API to configure all aspects of a taxonomy:

### Visibility and Access

```php
// Make taxonomy public
$taxonomy->public();

// Make taxonomy private
$taxonomy->private();

// Allow in publicly queryable URLs
$taxonomy->publiclyQueryable();

// Set whether to allow in navigation menus
$taxonomy->setShowInNavMenus(true);

// Show in admin UI
$taxonomy->showUi();

// Show in admin menu
$taxonomy->showInMenu(); // Default is true
$taxonomy->showInMenu('custom-menu'); // Custom menu location
```

### Structure and Organization

```php
// Enable hierarchical structure (like categories)
$taxonomy->hierarchical();

// Allow hierarchy
$taxonomy->allowHierarchy();

// Make taxonomy exclusive (only one term can be selected)
$taxonomy->exclusive();

// Keep checked terms on top
$taxonomy->checkedOntop();

// Enable term sorting
$taxonomy->sort();
```

### UI Customization

```php
// Show in quick edit
$taxonomy->showInQuickEdit();

// Show in tag cloud
$taxonomy->showTagcloud();

// Show admin column
$taxonomy->showAdminColumn();

// Set admin columns
$taxonomy->setAdminCols([
    'description' => [
        'title' => 'Description',
        'function' => function() {
            return 'Description';
        }
    ]
]);
```

### REST API

```php
// Enable in REST API
$taxonomy->showInRest();

// Customize REST base
$taxonomy->setRestBase('genres');

// Set REST namespace
$taxonomy->setRestNamespace('my-api/v1');

// Set REST controller class
$taxonomy->setRestControllerClass(MyCustomRestController::class);
```

### Advanced Configuration

```php
// Set custom capabilities
$taxonomy->setCapabilities([
    'manage_terms' => 'manage_genres',
    'edit_terms' => 'edit_genres',
    'delete_terms' => 'delete_genres',
    'assign_terms' => 'assign_genres'
]);

// Set default term
$taxonomy->setDefaultTerm('Fiction');
// Or with more details
$taxonomy->setDefaultTerm([
    'name' => 'Fiction',
    'slug' => 'fiction',
    'description' => 'Fiction books'
]);

// Configure permalink rewriting
$taxonomy->setRewrite([
    'slug' => 'genres',
    'with_front' => false
]);

// Set custom meta box callback
$taxonomy->setMetaBoxCb(function($post, $box) {
    // Custom meta box implementation
});

// Set meta box sanitize callback
$taxonomy->setMetaBoxSanitizeCb(function($term_id, $tt_id) {
    // Custom sanitization
});

// Set update count callback
$taxonomy->setUpdateCountCallback(function($terms, $taxonomy) {
    // Custom count update logic
});
```

### Using Raw Arguments

For advanced use cases or when you need to set multiple arguments at once, you can use the `rawArgs` method to directly set WordPress register_taxonomy arguments:

```php
$taxonomy = Taxonomy::make('genre', 'book', 'Genre', 'Genres')
    ->hierarchical()
    ->showInRest()
    ->rawArgs([
        'show_admin_column' => true,
        'show_tagcloud' => false,
        'show_in_quick_edit' => true,
        'meta_box_cb' => 'my_custom_meta_box'
    ]);
```

This approach is useful when:
- You want to combine the fluent API with direct WordPress arguments
- You need to set multiple arguments at once
- You want to use WordPress-specific arguments not covered by the fluent API
- You're migrating existing code and want to maintain the same argument structure

Note that when using `rawArgs`, the arguments are merged with any individual properties you've set. If the same argument is set both ways, the raw argument takes precedence.

## Working with the Domain Model Directly

If you need more control, you can work with the domain model directly:

```php
<?php

use Pollora\Entity\Domain\Models\Taxonomy;
use Pollora\Entity\Application\Services\EntityRegistrationService;
use Pollora\Entity\Infrastructure\Services\EntityMapperService;
use Pollora\Entity\Infrastructure\Repositories\WordPressTaxonomyRegistrar;

// Create taxonomy domain model
$taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
$taxonomy->hierarchical()->showInRest();

// Set up the infrastructure
$mapper = new EntityMapperService();
$registrar = new WordPressTaxonomyRegistrar($mapper);

// Register via application service
$service = new EntityRegistrationService($registrar, $registrar);
$service->registerTaxonomy($taxonomy);
```

## Laravel Integration

For Laravel projects, you can define a Laravel-specific service provider:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Pollora\Entity\Domain\Contracts\EntityMapperInterface;
use Pollora\Entity\Domain\Contracts\EntityRegistrarInterface;
use Pollora\Entity\Infrastructure\Services\EntityMapperService;
use Pollora\Entity\Infrastructure\Repositories\WordPressTaxonomyRegistrar;
use Pollora\Entity\Application\Services\EntityRegistrationService;
use Pollora\Entity\Application\Services\EntityFactoryService;

class EntityServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind the entity mapper
        $this->app->singleton(EntityMapperInterface::class, EntityMapperService::class);
        
        // Bind the registrars
        $this->app->singleton('entity.taxonomy.registrar', function ($app) {
            return new WordPressTaxonomyRegistrar(
                $app->make(EntityMapperInterface::class)
            );
        });
        
        // Bind the entity registration service
        $this->app->singleton(EntityRegistrationService::class, function ($app) {
            return new EntityRegistrationService(
                $app->make('entity.taxonomy.registrar'),
                $app->make('entity.taxonomy.registrar')
            );
        });
        
        // Bind the entity factory service
        $this->app->singleton(EntityFactoryService::class);
    }
}
```

And define a Laravel Facade for easier access:

```php
<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Pollora\Entity\Domain\Models\Taxonomy as TaxonomyModel;

/**
 * @method static TaxonomyModel make(string $slug, string|array $objectType, ?string $singular = null, ?string $plural = null)
 * @method static bool register(TaxonomyModel $taxonomy)
 * @method static bool exists(string $slug)
 * @method static bool unregister(string $slug)
 */
class Taxonomy extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'taxonomy';
    }
}
```

Then in a service provider:

```php
public function register()
{
    $this->app->singleton('taxonomy', function ($app) {
        return new \App\Services\TaxonomyService(
            $app->make(EntityFactoryService::class),
            $app->make(EntityRegistrationService::class)
        );
    });
}
```

Now you can use the facade throughout your Laravel application:

```php
use App\Facades\Taxonomy;

Taxonomy::make('genre', 'book', 'Genre', 'Genres')
    ->hierarchical()
    ->showInRest()
    ->register();
```

## Testing

Because the package follows Hexagonal Architecture principles, you can easily test your taxonomy logic:

```php
<?php

use PHPUnit\Framework\TestCase;
use Pollora\Entity\Domain\Models\Taxonomy;
use Pollora\Entity\Application\Services\EntityRegistrationService;

class TaxonomyTest extends TestCase
{
    public function testTaxonomyCreation()
    {
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $taxonomy->hierarchical()->showInRest();
        
        $this->assertEquals('genre', $taxonomy->getSlug());
        $this->assertEquals('book', $taxonomy->getObjectType());
        $this->assertEquals(true, $taxonomy->isHierarchical());
    }
    
    public function testTaxonomyRegistration()
    {
        // Mock the registrar
        $registrar = $this->createMock(EntityRegistrarInterface::class);
        $registrar->expects($this->once())
            ->method('register')
            ->willReturn(true);
            
        $service = new EntityRegistrationService($registrar, $registrar);
        
        $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
        $result = $service->registerTaxonomy($taxonomy);
        
        $this->assertTrue($result);
    }
}
``` 