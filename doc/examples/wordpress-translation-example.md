# WordPress Translation Integration for pollora/entity

This document explains how to use the translation capabilities of `pollora/entity` in a WordPress plugin or theme.

## Creating a Custom Translator for WordPress

Since WordPress has its own translation system, you can create a custom translator implementation that leverages WordPress's translation functions:

### 1. Create a WordPress Translator Implementation

```php
<?php

// In your theme or plugin file

use Pollora\Entity\Domain\Contracts\ArgumentTranslatorInterface;

/**
 * WordPress implementation of ArgumentTranslatorInterface.
 */
class WordPressArgumentTranslator implements ArgumentTranslatorInterface
{
    /**
     * The text domain to use for translations.
     */
    private string $textDomain;
    
    /**
     * Constructor.
     * 
     * @param string $textDomain The text domain to use for translations.
     */
    public function __construct(string $textDomain = 'my-plugin')
    {
        $this->textDomain = $textDomain;
    }
    
    /**
     * Translates entity arguments using WordPress's translation functions.
     *
     * @param array $args The arguments to translate
     * @param string $entity The entity type (e.g., 'post-types', 'taxonomies')
     * @param array $keysToTranslate The keys to be translated
     * @return array The translated arguments
     */
    public function translate(
        array $args,
        string $entity,
        array $keysToTranslate = [
            'label',
            'labels.*',
            'names.singular',
            'names.plural',
        ]
    ): array {
        foreach ($keysToTranslate as $keyPath) {
            if (strpos($keyPath, '*') !== false) {
                // Handle wildcard keys (e.g., 'labels.*')
                $prefix = str_replace('.*', '', $keyPath);
                if (isset($args[$prefix]) && is_array($args[$prefix])) {
                    foreach ($args[$prefix] as $subKey => $value) {
                        if (is_string($value)) {
                            $args[$prefix][$subKey] = __($value, $this->textDomain);
                        }
                    }
                }
            } else if (strpos($keyPath, '.') !== false) {
                // Handle nested keys (e.g., 'names.singular')
                $keys = explode('.', $keyPath);
                $this->translateNestedKey($args, $keys);
            } else {
                // Handle simple keys (e.g., 'label')
                if (isset($args[$keyPath]) && is_string($args[$keyPath])) {
                    $args[$keyPath] = __($args[$keyPath], $this->textDomain);
                }
            }
        }

        return $args;
    }

    /**
     * Translate a nested key in an array.
     *
     * @param array $args The arguments being translated
     * @param array $keys The nested key path as an array
     * @return void
     */
    private function translateNestedKey(array &$args, array $keys): void
    {
        $current = &$args;
        $lastKey = array_pop($keys);
        
        foreach ($keys as $key) {
            if (!isset($current[$key]) || !is_array($current[$key])) {
                return;
            }
            $current = &$current[$key];
        }
        
        if (isset($current[$lastKey]) && is_string($current[$lastKey])) {
            $current[$lastKey] = __($current[$lastKey], $this->textDomain);
        }
    }
}
```

### 2. Create a Simple Service Container

```php
<?php

/**
 * Simple service container for managing dependencies.
 */
class ServiceContainer
{
    /**
     * Registered services.
     */
    private static array $services = [];
    
    /**
     * Register a service.
     *
     * @param string $name The service name
     * @param mixed $service The service instance
     * @return void
     */
    public static function register(string $name, $service): void
    {
        self::$services[$name] = $service;
    }
    
    /**
     * Get a service.
     *
     * @param string $name The service name
     * @return mixed The service instance
     */
    public static function get(string $name)
    {
        return self::$services[$name] ?? null;
    }
}
```

### 3. Register Your Translator and Create a Registration Service

```php
<?php

use Pollora\Entity\Application\Services\EntityRegistrationService;
use Pollora\Entity\Infrastructure\Repositories\WordPressPostTypeRegistrar;
use Pollora\Entity\Infrastructure\Repositories\WordPressTaxonomyRegistrar;
use Pollora\Entity\Infrastructure\Services\EntityMapperService;

/**
 * Initialize services.
 */
function initialize_entity_services(): void
{
    // Create dependencies
    $mapper = new EntityMapperService();
    $postTypeRegistrar = new WordPressPostTypeRegistrar($mapper);
    $taxonomyRegistrar = new WordPressTaxonomyRegistrar($mapper);
    $translator = new WordPressArgumentTranslator('my-plugin');
    
    // Create the registration service
    $registrationService = new EntityRegistrationService(
        $postTypeRegistrar,
        $taxonomyRegistrar,
        $translator
    );
    
    // Register in the service container
    ServiceContainer::register('entity.registration', $registrationService);
}
add_action('plugins_loaded', 'initialize_entity_services');
```

## Using Custom Translator

### Registering Post Types and Taxonomies

```php
<?php

use Pollora\Entity\Domain\Models\PostType;
use Pollora\Entity\Domain\Models\Taxonomy;

/**
 * Register post types and taxonomies.
 */
function register_custom_types(): void
{
    /** @var EntityRegistrationService $service */
    $service = ServiceContainer::get('entity.registration');
    
    // Create post type
    $bookPostType = new PostType('book', __('Book', 'my-plugin'), __('Books', 'my-plugin'));
    $bookPostType->public()
        ->supports(['title', 'editor', 'thumbnail'])
        ->setMenuIcon('dashicons-book-alt');
    
    // Register with automatic translation
    $service->registerPostType($bookPostType);
    
    // Create taxonomy
    $genreTaxonomy = new Taxonomy(
        'genre',
        'book',
        __('Genre', 'my-plugin'),
        __('Genres', 'my-plugin')
    );
    $genreTaxonomy->hierarchical()
        ->showInRest();
    
    // Register with automatic translation
    $service->registerTaxonomy($genreTaxonomy);
}
add_action('init', 'register_custom_types');
```

## Translation Files

Create your translation files as usual for WordPress:

1. Create a POT file for your plugin
2. Translate strings to create PO/MO files
3. Load textdomain in your plugin

```php
<?php

/**
 * Load plugin text domain.
 */
function load_my_plugin_textdomain(): void
{
    load_plugin_textdomain(
        'my-plugin',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages'
    );
}
add_action('plugins_loaded', 'load_my_plugin_textdomain');
```

## Full Example for Plugins

Here's a complete example of using the translator in a plugin:

```php
<?php
/**
 * Plugin Name: My Custom Types
 * Description: Register custom post types and taxonomies with translations
 * Version: 1.0.0
 * Text Domain: my-custom-types
 * Domain Path: /languages
 */

declare(strict_types=1);

// Include the Pollora Entity package files (assuming Composer autoloading)

use Pollora\Entity\Application\Services\EntityRegistrationService;
use Pollora\Entity\Domain\Contracts\ArgumentTranslatorInterface;
use Pollora\Entity\Domain\Models\PostType;
use Pollora\Entity\Domain\Models\Taxonomy;
use Pollora\Entity\Infrastructure\Repositories\WordPressPostTypeRegistrar;
use Pollora\Entity\Infrastructure\Repositories\WordPressTaxonomyRegistrar;
use Pollora\Entity\Infrastructure\Services\EntityMapperService;

// WordPress translator implementation
class WordPressArgumentTranslator implements ArgumentTranslatorInterface
{
    // Implementation as shown above
    private string $textDomain;
    
    public function __construct(string $textDomain)
    {
        $this->textDomain = $textDomain;
    }
    
    public function translate(array $args, string $entity, array $keysToTranslate = []): array
    {
        // Implementation as shown above
        return $args;
    }
    
    private function translateNestedKey(array &$args, array $keys): void
    {
        // Implementation as shown above
    }
}

// Simple service container
class ServiceContainer
{
    // Implementation as shown above
    private static array $services = [];
    
    public static function register(string $name, $service): void
    {
        self::$services[$name] = $service;
    }
    
    public static function get(string $name)
    {
        return self::$services[$name] ?? null;
    }
}

// Load text domain
function load_custom_types_textdomain(): void
{
    load_plugin_textdomain(
        'my-custom-types',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages'
    );
}
add_action('plugins_loaded', 'load_custom_types_textdomain');

// Initialize services
function initialize_custom_types_services(): void
{
    $mapper = new EntityMapperService();
    $postTypeRegistrar = new WordPressPostTypeRegistrar($mapper);
    $taxonomyRegistrar = new WordPressTaxonomyRegistrar($mapper);
    $translator = new WordPressArgumentTranslator('my-custom-types');
    
    $registrationService = new EntityRegistrationService(
        $postTypeRegistrar,
        $taxonomyRegistrar,
        $translator
    );
    
    ServiceContainer::register('entity.registration', $registrationService);
}
add_action('plugins_loaded', 'initialize_custom_types_services', 20);

// Register custom types
function register_my_custom_types(): void
{
    /** @var EntityRegistrationService $service */
    $service = ServiceContainer::get('entity.registration');
    if (!$service) {
        return;
    }
    
    // Book post type
    $book = new PostType(
        'book', 
        __('Book', 'my-custom-types'), 
        __('Books', 'my-custom-types')
    );
    $book->public()
        ->supports(['title', 'editor', 'thumbnail', 'excerpt'])
        ->setMenuIcon('dashicons-book-alt')
        ->setDescription(__('Custom post type for books', 'my-custom-types'))
        ->setMenuPosition(5);
        
    $service->registerPostType($book);
    
    // Genre taxonomy
    $genre = new Taxonomy(
        'genre',
        'book',
        __('Genre', 'my-custom-types'),
        __('Genres', 'my-custom-types')
    );
    $genre->hierarchical()
        ->showInRest()
        ->showAdminColumn();
        
    $service->registerTaxonomy($genre);
}
add_action('init', 'register_my_custom_types');
``` 