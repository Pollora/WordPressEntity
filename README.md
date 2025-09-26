# Pollora Entity WordPress Package

A modern PHP 8.2+ library for easily managing WordPress custom post types and taxonomies with a fluent interface and hexagonal architecture.

## Features

- 🚀 Modern PHP 8.2+ with type declarations
- 🏗️ Fluent interface for easy configuration
- 🔧 Built on top of [Extended CPTs](https://github.com/johnbillion/extended-cpts) library
- 📐 Hexagonal architecture for better separation of concerns
- 🧪 Fully tested with PestPHP
- 💡 Intuitive method naming with dedicated methods for boolean properties

## Installation

```bash
composer require pollora/entity
```

## Documentation

- [Post Types Documentation](docs/post-types.md) - Complete guide for creating and configuring custom post types
- [Taxonomies Documentation](docs/taxonomies.md) - Complete guide for creating and configuring custom taxonomies

## Quick Start

### Post Types

```php
use Pollora\Entity\PostType;

PostType::make('book', 'Book', 'Books')
    ->public()
    ->showInRest()
    ->hasArchive()
    ->supports(['title', 'editor', 'thumbnail'])
    ->menuIcon('dashicons-book-alt');
```

### Taxonomies

```php
use Pollora\Entity\Taxonomy;

Taxonomy::make('genre', 'book', 'Genre', 'Genres')
    ->hierarchical()
    ->showInRest()
    ->showInQuickEdit();
```

## Architecture

This package follows hexagonal architecture principles:

1. **Domain Layer**: Core business logic (Entity, PostType, Taxonomy)
2. **Application Layer**: Services that orchestrate operations
3. **Adapter Layer**: WordPress integration adapters

The Domain layer remains independent of external dependencies, defining interfaces (ports) that adapters implement.

## Testing

The package includes comprehensive unit tests using PestPHP with WordPress function mocks:

```bash
composer test
```

### Test Structure

- `tests/helpers.php`: Global WordPress function mocks
- `tests/ext_cpts_helpers.php`: Extended CPTs namespace function mocks
- `tests/bootstrap.php`: Test environment setup

## License

This package is open-source software licensed under the MIT license. 
