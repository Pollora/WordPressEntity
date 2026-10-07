<p align="center">
  <a href="https://pollora.dev">
    <img src="https://raw.githubusercontent.com/Pollora/.github/main/brand/banners/WordPressEntity.png" width="100%" alt="Entity: fluent WordPress post types and taxonomies">
  </a>
</p>

<p align="center">
  <a href="https://packagist.org/packages/pollora/entity"><img src="https://img.shields.io/packagist/v/pollora/entity" alt="Latest version"></a>
  <a href="https://packagist.org/packages/pollora/entity"><img src="https://img.shields.io/packagist/dt/pollora/entity" alt="Total downloads"></a>
  <a href="https://github.com/Pollora/WordPressEntity/actions/workflows/tests.yml"><img src="https://github.com/Pollora/WordPressEntity/actions/workflows/tests.yml/badge.svg" alt="Tests"></a>
  <a href="LICENSE"><img src="https://img.shields.io/github/license/Pollora/WordPressEntity" alt="License"></a>
</p>

Entity declares WordPress custom post types and taxonomies with a fluent, typed interface instead of the long argument arrays of `register_post_type()` and `register_taxonomy()`. Each option has its own method, boolean options get dedicated methods (`public()`, `showInRest()`…), and registration is hooked to `init` for you. It is built on [Extended CPTs](https://github.com/johnbillion/extended-cpts), so labels are generated from the singular and plural names, and admin columns and filters are one method away (`adminCols()`, `adminFilters()`).

> Part of [Pollora](https://pollora.dev), the Laravel framework for WordPress. In a Pollora project it is already installed: declare post types and taxonomies with the `#[PostType]` and `#[Taxonomy]` attributes instead, and Pollora registers them through this package.

## Installation

```bash
composer require pollora/entity
```

Requires PHP 8.2+ and WordPress.

## Quick start

### Post types

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

`make()` returns the configured object and registers it on the WordPress `init` hook, so call it before `init` runs (in a plugin's main file or a theme's `functions.php`).

## Features

- Typed, fluent methods for the post type and taxonomy arguments, with dedicated methods for boolean options.
- Built on [Extended CPTs](https://github.com/johnbillion/extended-cpts).
- Hexagonal architecture that keeps the domain independent from WordPress.
- Tested with Pest, with WordPress functions mocked.

## Documentation

- [Post types](docs/post-types.md): creating and configuring custom post types.
- [Taxonomies](docs/taxonomies.md): creating and configuring custom taxonomies.

In a Pollora project, see [Post types](https://pollora.dev/content/post-types/) and [Taxonomies](https://pollora.dev/content/taxonomies/) on pollora.dev.

## Architecture

The package follows hexagonal architecture principles:

1. **Domain layer**: the core model (`Entity`, `PostType`, `Taxonomy`).
2. **Application layer**: services that orchestrate registration.
3. **Adapter layer**: the WordPress integration adapters.

The domain layer has no external dependencies: it defines interfaces (ports) that the adapters implement.

## Testing

```bash
composer test
```

This runs the Pest unit tests, PHPStan and Pint. WordPress functions are mocked:

- `tests/Helpers/helpers.php`: global WordPress function mocks
- `tests/Helpers/ext_cpts_helpers.php`: Extended CPTs namespace function mocks
- `tests/Helpers/wordpress_args_helpers.php`: mocks for pollora/wordpress-args
- `tests/bootstrap.php`: test environment setup

## Contributing

Contributions are welcome: see the [contributing guide](https://github.com/Pollora/.github/blob/main/CONTRIBUTING.md). Report security issues privately, as described in the [security policy](https://github.com/Pollora/.github/blob/main/SECURITY.md).

## License

Entity is open-source software licensed under the [MIT license](LICENSE). © [RuBee group](https://rubee.group)
