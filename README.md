# Pollora Entity WordPress Package

A modern PHP 8.2+ library for easily managing WordPress custom post types and taxonomies with a hexagonal architecture.

## Test Structure

The unit tests use PestPHP and simulate WordPress functions to test the code without requiring a complete WordPress installation.

### WordPress Mocks

WordPress mocks are organized as follows:

1. `tests/helpers.php`: Global WordPress functions (global namespace)
2. `tests/ext_cpts_helpers.php`: Functions in the `ExtCPTs` namespace

#### `helpers.php` File

This file contains simulations of global WordPress functions such as:
- `add_action` (to intercept and execute callbacks)
- `register_post_type` and `register_taxonomy`
- `register_extended_post_type` and `register_extended_taxonomy`
- `is_admin`
- `did_action`
- `apply_filters`
- etc.

#### `ext_cpts_helpers.php` File

This file contains simulations of WordPress functions in the `ExtCPTs` namespace used by the `johnbillion/extended-cpts` library:
- `ExtCPTs\apply_filters`
- `ExtCPTs\add_filter`
- `ExtCPTs\get_post_type_object`
- `ExtCPTs\get_taxonomies`
- `ExtCPTs\get_post_types`
- `ExtCPTs\is_wp_error`
- `ExtCPTs\do_action`
- etc.

### Bootstrap

The `tests/bootstrap.php` file loads the Composer autoloader, test helpers, and configures Mockery.

## Code Structure

The hexagonal architecture used here separates the code into three layers:

1. **Domain**: Domain models (Entity, PostType, Taxonomy)
2. **Application**: Application services that orchestrate operations
3. **Adapter**: Adapters that allow interaction with WordPress

The Domain layer is at the center and doesn't depend on any other layer. It defines ports (interfaces) that the adapters implement.

The Application layer uses these interfaces to interact with the outside world, without knowing the implementation details.

## Usage

```php
// Creating and registering a custom post type
use Pollora\Entity\PostType;

PostType::make('book', 'Book', 'Books')
    ->setPublic(true)
    ->setHasArchive(true)
    ->setSupports(['title', 'editor', 'thumbnail'])
    ->setMenuIcon('dashicons-book-alt')
    ->register();

// Creating and registering a taxonomy
use Pollora\Entity\Taxonomy;

Taxonomy::make('genre', 'book', 'Genre', 'Genres')
    ->setHierarchical(true)
    ->setShowInRest(true)
    ->register();
``` 