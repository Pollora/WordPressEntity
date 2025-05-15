# Post Type Documentation

This document details how to work with post types in the Pollora Entity package.

## Basic Usage

### Creating a Post Type

The most straightforward way to create a post type is with the static `make()` method:

```php
<?php

use Pollora\Entity\UI\Resources\PostType;

$bookPostType = PostType::make('book', 'Book', 'Books');
```

The parameters are:
1. `$slug`: The post type slug (required)
2. `$singular`: The singular label (optional)
3. `$plural`: The plural label (optional)

### Registering a Post Type

After configuring your post type, register it with WordPress:

```php
$bookPostType->register();
```

Typically, you'll want to do this during the WordPress `init` action:

```php
add_action('init', function() {
    PostType::make('book', 'Book', 'Books')
        ->public()
        ->supports(['title', 'editor', 'thumbnail'])
        ->register();
});
```

## Post Type Configuration

The package provides a fluent API to configure all aspects of a post type:

### Visibility and Access

```php
// Make post type public
$postType->public();

// Make post type private
$postType->private();

// Allow in publicly queryable URLs
$postType->publiclyQueryable();

// Set whether to allow in navigation menus
$postType->showInNavMenus();

// Show in admin UI
$postType->showUi();

// Show in admin menu
$postType->showInMenu(); // Default is true
$postType->showInMenu('edit.php?post_type=page'); // As submenu of pages

// Show in admin bar
$postType->showInAdminBar();
```

### Content Support

```php
// Add support for specific features
$postType->supports(['title', 'editor', 'thumbnail', 'excerpt', 'comments']);

// Enable/disable block editor
$postType->enableBlockEditor();
$postType->setBlockEditor(false);

// Enable hierarchical structure (like pages)
$postType->hierarchical();

// Change the "Enter title here" placeholder
$postType->titlePlaceholder('Enter book title here');
```

### UI Customization

```php
// Set menu icon (dashicons or URL)
$postType->setMenuIcon('dashicons-book-alt');

// Set position in admin menu
$postType->setMenuPosition(5);

// Customize featured image text
$postType->setFeaturedImage('Book Cover Image');

// Enable or disable quick edit
$postType->enableQuickEdit();
$postType->setQuickEdit(false);
```

### Archives and Permalinks

```php
// Enable post type archives
$postType->hasArchive();
$postType->hasArchive('books'); // Custom archive slug

// Configure permalink rewriting
$postType->setRewrite(['slug' => 'books', 'with_front' => false]);
```

### REST API

```php
// Enable in REST API
$postType->showInRest();

// Customize REST base
$postType->setRestBase('books');

// Set REST namespace
$postType->setRestNamespace('my-api/v1');

// Set REST controller class
$postType->setRestControllerClass(MyCustomRestController::class);
```

### Admin Features

```php
// Show in dashboard activity widget
$postType->enableDashboardActivity();

// Show in "At a Glance" dashboard widget
$postType->setDashboardGlance(true);

// Set admin columns
$postType->setAdminCols([
    'featured_image' => [
        'title' => 'Cover',
        'width' => 80,
        'height' => 80
    ],
    'published' => [
        'title' => 'Published',
        'meta_key' => 'published_date'
    ]
]);

// Set admin filters
$postType->adminFilters([
    'genre' => [
        'title' => 'Genre',
        'taxonomy' => 'genre'
    ]
]);
```

### Advanced Configuration

```php
// Set custom capability type
$postType->setCapabilityType('book');

// Enable meta capabilities
$postType->mapMetaCap();

// Custom register meta box callback
$postType->setRegisterMetaBoxCb(function($post) {
    add_meta_box('book-details', 'Book Details', 'my_book_details_callback', null, 'side');
});

// Set associated taxonomies
$postType->setTaxonomies(['genre', 'author']);

// Set if post type can be exported
$postType->canExport();

// Control behavior when a user is deleted
$postType->setDeleteWithUser(true);

// Set custom capabilities
$postType->setCapabilities([
    'edit_post' => 'edit_book',
    'read_post' => 'read_book',
    'delete_post' => 'delete_book',
    'edit_posts' => 'edit_books',
    'edit_others_posts' => 'edit_others_books',
    'publish_posts' => 'publish_books',
    'read_private_posts' => 'read_private_books'
]);
```

### Using Raw Arguments

For advanced use cases or when you need to set multiple arguments at once, you can use the `rawArgs` method to directly set WordPress register_post_type arguments. These arguments will be merged with any individual properties you've set:

```php
$postType = PostType::make('book', 'Book', 'Books')
    ->public()
    ->setMenuIcon('dashicons-book-alt')
    ->rawArgs([
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
        'rewrite' => [
            'slug' => 'books',
            'with_front' => false
        ]
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

use Pollora\Entity\Domain\Models\PostType;
use Pollora\Entity\Application\Services\EntityRegistrationService;
use Pollora\Entity\Infrastructure\Services\EntityMapperService;
use Pollora\Entity\Infrastructure\Repositories\WordPressPostTypeRegistrar;

// Create post type domain model
$postType = new PostType('book', 'Book', 'Books');
$postType->public()->setMenuIcon('dashicons-book');

// Set up the infrastructure
$mapper = new EntityMapperService();
$registrar = new WordPressPostTypeRegistrar($mapper);

// Register via application service
$service = new EntityRegistrationService($registrar, $registrar);
$service->registerPostType($postType);
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
use Pollora\Entity\Infrastructure\Repositories\WordPressPostTypeRegistrar;
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
        $this->app->singleton('entity.post-type.registrar', function ($app) {
            return new WordPressPostTypeRegistrar(
                $app->make(EntityMapperInterface::class)
            );
        });
        
        $this->app->singleton('entity.taxonomy.registrar', function ($app) {
            return new WordPressTaxonomyRegistrar(
                $app->make(EntityMapperInterface::class)
            );
        });
        
        // Bind the entity registration service
        $this->app->singleton(EntityRegistrationService::class, function ($app) {
            return new EntityRegistrationService(
                $app->make('entity.post-type.registrar'),
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
use Pollora\Entity\Domain\Models\PostType as PostTypeModel;

/**
 * @method static PostTypeModel make(string $slug, ?string $singular = null, ?string $plural = null)
 * @method static bool register(PostTypeModel $postType)
 * @method static bool exists(string $slug)
 * @method static bool unregister(string $slug)
 */
class PostType extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'post-type';
    }
}
```

Then in a service provider:

```php
public function register()
{
    $this->app->singleton('post-type', function ($app) {
        return new \App\Services\PostTypeService(
            $app->make(EntityFactoryService::class),
            $app->make(EntityRegistrationService::class)
        );
    });
}
```

Now you can use the facade throughout your Laravel application:

```php
use App\Facades\PostType;

PostType::make('book', 'Book', 'Books')
    ->public()
    ->supports(['title', 'editor'])
    ->register();
```

## Testing

Because the package follows Hexagonal Architecture principles, you can easily test your post type logic:

```php
<?php

use PHPUnit\Framework\TestCase;
use Pollora\Entity\Domain\Models\PostType;
use Pollora\Entity\Application\Services\EntityRegistrationService;

class PostTypeTest extends TestCase
{
    public function testPostTypeCreation()
    {
        $postType = new PostType('book', 'Book', 'Books');
        $postType->public()->setMenuIcon('dashicons-book');
        
        $this->assertEquals('book', $postType->getSlug());
        $this->assertEquals('Book', $postType->getSingular());
        $this->assertEquals(true, $postType->isPublic());
    }
    
    public function testPostTypeRegistration()
    {
        // Mock the registrar
        $registrar = $this->createMock(EntityRegistrarInterface::class);
        $registrar->expects($this->once())
            ->method('register')
            ->willReturn(true);
            
        $service = new EntityRegistrationService($registrar, $registrar);
        
        $postType = new PostType('book', 'Book', 'Books');
        $result = $service->registerPostType($postType);
        
        $this->assertTrue($result);
    }
}
``` 