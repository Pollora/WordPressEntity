# Pollora Entity

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pollora/entity.svg)](https://packagist.org/packages/pollora/entity)
[![Tests](https://github.com/pollora/entity/workflows/Tests/badge.svg)](https://github.com/pollora/entity/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/pollora/entity.svg)](https://packagist.org/packages/pollora/entity)

A modern, fluent and type-safe API for registering WordPress post types and taxonomies.

## Features

- 🚀 Domain-driven design with Hexagonal Architecture
- 💪 Fully typed with PHP 8.2+ features
- 🧩 Fluent builder API for post types and taxonomies
- 🔄 Easy integration with both WordPress and Laravel
- 🧪 Testable design with dependency injection
- 🔒 Type-safe capabilities and permissions
- 🎨 Customizable admin UI and REST API endpoints

## Requirements

- PHP 8.2 or higher
- WordPress 5.8 or higher
- Composer

## Installation

You can install the package via composer:

```bash
composer require pollora/entity
```

## Quick Start

### Register a Post Type

```php
<?php

use Pollora\Entity\UI\Resources\PostType;

// Create and register a post type
PostType::make('book', 'Book', 'Books')
    ->public()
    ->supports(['title', 'editor', 'thumbnail'])
    ->menuIcon('dashicons-book-alt')
    ->register();

// Or use raw arguments
PostType::make('book', 'Book', 'Books')
    ->rawArgs([
        'public' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'menu_icon' => 'dashicons-book-alt'
    ])
    ->register();
```

### Register a Taxonomy

```php
<?php

use Pollora\Entity\UI\Resources\Taxonomy;

// Create and register a taxonomy
Taxonomy::make('genre', 'book', 'Genre', 'Genres')
    ->hierarchical()
    ->showInRest()
    ->register();

// Or use raw arguments
Taxonomy::make('genre', 'book', 'Genre', 'Genres')
    ->rawArgs([
        'hierarchical' => true,
        'show_in_rest' => true,
        'show_admin_column' => true
    ])
    ->register();
```

## WordPress Integration

For standalone WordPress projects, simply use the static facades in your theme or plugin:

```php
<?php
// functions.php or your plugin file

// Hook into WordPress init to register post types and taxonomies
add_action('init', function() {
    // Register post types
    \Pollora\Entity\UI\Resources\PostType::make('book', 'Book', 'Books')
        ->public()
        ->supports(['title', 'editor', 'thumbnail'])
        ->register();

    // Register taxonomies
    \Pollora\Entity\UI\Resources\Taxonomy::make('genre', 'book', 'Genre', 'Genres')
        ->hierarchical()
        ->register();
});
```

## Laravel Integration

For Laravel projects, you can integrate with the service provider system:

```php
// config/app.php
'providers' => [
    // ...
    Pollora\Entity\Infrastructure\Providers\LaravelEntityServiceProvider::class,
]
```

Then you can use dependency injection throughout your Laravel application:

```php
<?php

namespace App\Http\Controllers;

use Pollora\Entity\Application\Services\EntityFactoryService;
use Pollora\Entity\Application\Services\EntityRegistrationService;

class PostTypeController
{
    public function __construct(
        private EntityFactoryService $factoryService,
        private EntityRegistrationService $registrationService
    ) {
    }
    
    public function register()
    {
        $postType = $this->factoryService->createPostType('book', 'Book', 'Books');
        $postType->public()->supports(['title', 'editor']);
        
        $this->registrationService->registerPostType($postType);
        
        return response()->json(['message' => 'Post type registered']);
    }
}
```

## Documentation

- [Post Types](doc/PostType.md)
- [Taxonomies](doc/Taxonomy.md)

## Architecture

This package follows Hexagonal Architecture principles:

- **Domain** layer contains the business logic with no WordPress dependencies
- **Application** layer contains the use cases and orchestration
- **Infrastructure** layer adapts the domain to WordPress
- **UI** layer provides easy access points for the end-user

## Features in Detail

### Post Types

- Full support for all WordPress post type arguments
- Type-safe capabilities and permissions
- Customizable admin UI (columns, filters, etc.)
- REST API integration
- Block editor support
- Custom meta boxes
- Archive and permalink configuration

### Taxonomies

- Full support for all WordPress taxonomy arguments
- Hierarchical and non-hierarchical taxonomies
- Custom meta boxes
- REST API integration
- Admin UI customization
- Default terms
- Term ordering

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information. 