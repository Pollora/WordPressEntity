# Laravel Translation Integration for pollora/entity

This document explains how to use the translation capabilities of `pollora/entity` in a Laravel application.

## Setup

1. Install the package:

```bash
composer require pollora/entity
```

2. Register the service provider in your `config/app.php`:

```php
'providers' => [
    // ...
    Pollora\Entity\Infrastructure\Providers\LaravelEntityServiceProvider::class,
],
```

3. Publish the translation files:

```bash
php artisan vendor:publish --tag=entity-translations
```

## Adding Translations

Create or edit the language files in `resources/lang/vendor/entity/{lang}/` directory.

For example, to translate post type labels into French, create `resources/lang/vendor/entity/fr/post-types.php`:

```php
<?php

return [
    'label' => 'Livres',
    'labels' => [
        'name' => 'Livres',
        'singular_name' => 'Livre',
        'add_new' => 'Ajouter un livre',
        'add_new_item' => 'Ajouter un nouveau livre',
        'edit_item' => 'Modifier le livre',
        'new_item' => 'Nouveau livre',
        'view_item' => 'Voir le livre',
        'view_items' => 'Voir les livres',
        'search_items' => 'Rechercher des livres',
        'not_found' => 'Aucun livre trouvé',
        'not_found_in_trash' => 'Aucun livre trouvé dans la corbeille',
        'parent_item_colon' => 'Livre parent:',
        'all_items' => 'Tous les livres',
        'archives' => 'Archives des livres',
        'attributes' => 'Attributs du livre',
        'insert_into_item' => 'Insérer dans le livre',
        'uploaded_to_this_item' => 'Téléversé sur ce livre',
        'featured_image' => 'Image à la une du livre',
        'set_featured_image' => 'Définir l\'image à la une du livre',
        'remove_featured_image' => 'Supprimer l\'image à la une du livre',
        'use_featured_image' => 'Utiliser comme image à la une du livre',
        'filter_items_list' => 'Filtrer la liste des livres',
        'filter_by_date' => 'Filtrer par date',
        'items_list_navigation' => 'Navigation de la liste des livres',
        'items_list' => 'Liste des livres',
        'item_published' => 'Livre publié',
        'item_published_privately' => 'Livre publié en privé',
        'item_reverted_to_draft' => 'Livre remis au brouillon',
        'item_scheduled' => 'Livre planifié',
        'item_updated' => 'Livre mis à jour',
        'item_link' => 'Lien du livre',
        'item_link_description' => 'Un lien vers un livre',
    ],
    'names' => [
        'singular' => 'Livre',
        'plural' => 'Livres',
    ],
];
```

## Using in Your Application

Once the translations are set up, you can use the Laravel integration to automatically translate your post types and taxonomies:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Pollora\Entity\UI\Resources\PostType;
use Pollora\Entity\UI\Resources\Taxonomy;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Get the current locale
        $locale = app()->getLocale();
        
        // Set the locale for translations
        app('translator')->setLocale($locale);
        
        // Register post types with automatic translation
        add_action('init', function() {
            // The labels will be automatically translated based 
            // on the current locale
            PostType::make('book', 'Book', 'Books')
                ->public()
                ->supports(['title', 'editor', 'thumbnail'])
                ->menuIcon('dashicons-book-alt')
                ->register();
                
            Taxonomy::make('genre', 'book', 'Genre', 'Genres')
                ->hierarchical()
                ->showInRest()
                ->register();
        });
    }
}
```

## How it Works

1. When you register a post type or taxonomy, the arguments are passed to the Laravel translator
2. The translator looks for keys in the `resources/lang/vendor/entity/{lang}/post-types.php` or `resources/lang/vendor/entity/{lang}/taxonomies.php` files
3. If translations are found, they replace the original values
4. If no translations are found, the original values are used

## Extending the Translation System

If you need to customize the translation process beyond what's provided, you can create your own translator implementation:

```php
<?php

namespace App\Services;

use Pollora\Entity\Domain\Contracts\ArgumentTranslatorInterface;

class CustomArgumentTranslator implements ArgumentTranslatorInterface
{
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
        // Your custom translation logic here
        
        // For example, you could use a different translation file structure,
        // connect to a translation API, or use a database for translations
        
        return $translatedArgs;
    }
}
```

Then register your custom translator in your service provider:

```php
<?php

namespace App\Providers;

use App\Services\CustomArgumentTranslator;
use Illuminate\Support\ServiceProvider;
use Pollora\Entity\Domain\Contracts\ArgumentTranslatorInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Override the default translator with your custom implementation
        $this->app->bind(ArgumentTranslatorInterface::class, CustomArgumentTranslator::class);
    }
}
``` 