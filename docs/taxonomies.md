# Taxonomies Documentation

This guide covers all available methods for creating and configuring WordPress custom taxonomies using the Pollora Entity package.

## Creating a Taxonomy

Taxonomies are created using the static `make()` method, which automatically registers them with WordPress:

```php
use Pollora\Entity\Taxonomy;

$taxonomy = Taxonomy::make('genre', 'book', 'Genre', 'Genres');
```

Parameters:
- `$slug` (string, required): The taxonomy slug (max 32 characters)
- `$objectType` (string|array, required): Post type(s) to attach the taxonomy to
- `$singular` (string, optional): Singular label for the taxonomy
- `$plural` (string, optional): Plural label for the taxonomy

## Basic Configuration Methods

### Labels and Description

```php
$taxonomy->label('Genres')
    ->labels([
        'add_new_item' => 'Add New Genre',
        'new_item_name' => 'New Genre Name',
        'edit_item' => 'Edit Genre',
        // ... more labels
    ])
    ->description('Book genres for categorization');
```

### Visibility Methods

#### Public Access
```php
$taxonomy->public();           // Make taxonomy public
$taxonomy->private();          // Make taxonomy private
$taxonomy->withPublic(true);   // Set public status explicitly
```

#### Query Control
```php
$taxonomy->publiclyQueryable();       // Allow front-end queries
$taxonomy->notPubliclyQueryable();    // Disallow front-end queries
$taxonomy->withPubliclyQueryable(true);
```

### UI Display Methods

#### Admin UI
```php
$taxonomy->showUi();           // Show in admin UI
$taxonomy->hideUi();           // Hide from admin UI
$taxonomy->withShowUi(true);
```

#### Admin Menu
```php
$taxonomy->showInMenu();               // Show in admin menu
$taxonomy->hideFromMenu();             // Hide from admin menu
$taxonomy->withShowInMenu(true);       // Set explicitly
```

#### Navigation Menus
```php
$taxonomy->showInNavMenus();       // Show in nav menus
$taxonomy->hideFromNavMenus();     // Hide from nav menus
$taxonomy->withShowInNavMenus(true);
```

### Hierarchy

```php
$taxonomy->hierarchical();         // Enable hierarchy (like categories)
$taxonomy->nonHierarchical();      // Disable hierarchy (like tags)
$taxonomy->withHierarchical(true);
```

### REST API Support

```php
$taxonomy->showInRest();           // Enable REST API
$taxonomy->hideFromRest();         // Disable REST API
$taxonomy->withShowInRest(true);
$taxonomy->restBase('genres');     // Set REST base endpoint
$taxonomy->restNamespace('myapi/v1');
$taxonomy->restControllerClass('My_REST_Controller');
```

## WordPress UI Features

### Tag Cloud

```php
$taxonomy->showTagcloud();         // Show in tag cloud widget
$taxonomy->hideFromTagcloud();     // Hide from tag cloud widget
$taxonomy->withShowTagcloud(true);
```

### Quick Edit

```php
$taxonomy->showInQuickEdit();      // Show in quick/bulk edit
$taxonomy->hideFromQuickEdit();    // Hide from quick/bulk edit
$taxonomy->withShowInQuickEdit(true);
```

### Admin Column

```php
$taxonomy->showAdminColumn();      // Show column on post listings
$taxonomy->hideAdminColumn();      // Hide column on post listings
$taxonomy->withShowAdminColumn(true);
```

## URL Rewriting

```php
$taxonomy->rewrite([
    'slug' => 'genres',
    'with_front' => false,
    'hierarchical' => true,
    'ep_mask' => EP_NONE
]);

$taxonomy->queryVar('genre');      // Set query var
$taxonomy->queryVar(false);        // Disable query var
```

## Capabilities

```php
$taxonomy->capabilities([
    'manage_terms' => 'manage_genres',
    'edit_terms' => 'edit_genres',
    'delete_terms' => 'delete_genres',
    'assign_terms' => 'assign_genres',
]);
```

## Meta Box Configuration

```php
// Set custom meta box callback
$taxonomy->metaBoxCb('my_custom_genre_meta_box');

// Disable meta box
$taxonomy->metaBoxCb(false);

// Set meta box sanitization callback
$taxonomy->metaBoxSanitizeCb(function($tax_id) {
    // Custom sanitization logic
    return $tax_id;
});
```

## Term Management

### Default Term

```php
// Set default term by name
$taxonomy->defaultTerm('Uncategorized');

// Set default term with slug and description
$taxonomy->defaultTerm([
    'name' => 'Uncategorized',
    'slug' => 'uncategorized',
    'description' => 'Default genre for books'
]);
```

### Term Ordering

```php
$taxonomy->sort();                 // Enable term ordering
$taxonomy->unsort();               // Disable term ordering
$taxonomy->withSort(true);
```

### Update Count Callback

```php
$taxonomy->updateCountCallback(function($terms, $taxonomy) {
    // Custom count update logic
    _update_post_term_count($terms, $taxonomy);
});
```

## Advanced Features

### Checked On Top

```php
$taxonomy->checkedOntop();         // Keep checked terms on top
$taxonomy->uncheckedOntop();       // Don't keep checked terms on top
$taxonomy->withCheckedOntop(true);
```

### Exclusive Terms

```php
$taxonomy->exclusive();            // Allow only one term per post
$taxonomy->nonExclusive();         // Allow multiple terms per post
$taxonomy->withExclusive(true);
```

### Hierarchy in Rewrites

```php
$taxonomy->allowHierarchy();       // Enable hierarchy in URLs
$taxonomy->disallowHierarchy();    // Disable hierarchy in URLs
$taxonomy->withAllowHierarchy(true);
```

### Custom Arguments

```php
$taxonomy->args([
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => false,
    'fields' => 'all',
]);
```

## Dashboard Features

```php
$taxonomy->enableDashboardGlance();    // Show in "At a Glance"
$taxonomy->disableDashboardGlance();   // Hide from "At a Glance"
$taxonomy->withDashboardGlance(true);
```

## Admin Columns

```php
$taxonomy->adminCols([
    'count' => [
        'title' => 'Books',
        'function' => function($term_id) {
            $term = get_term($term_id);
            return $term->count;
        },
    ],
    'description' => [
        'title' => 'Description',
        'function' => function($term_id) {
            $term = get_term($term_id);
            return $term->description;
        },
    ],
]);
```

## Naming Methods

```php
$taxonomy->singular('Genre');      // Set singular name
$taxonomy->plural('Genres');       // Set plural name
$taxonomy->slug('genre');          // Set slug
$taxonomy->names([                 // Set all names at once
    'singular' => 'Genre',
    'plural' => 'Genres',
    'slug' => 'genre',
]);
```

## Complete Examples

### Basic Tag-like Taxonomy

```php
use Pollora\Entity\Taxonomy;

Taxonomy::make('keyword', 'post', 'Keyword', 'Keywords')
    ->label('Keywords')
    ->description('Keywords for posts')
    ->public()
    ->showInRest()
    ->nonHierarchical()
    ->showTagcloud()
    ->showInQuickEdit();
```

### Advanced Category-like Taxonomy

```php
use Pollora\Entity\Taxonomy;

Taxonomy::make('genre', 'book', 'Genre', 'Genres')
    ->label('Genres')
    ->description('Literary genres for books')
    ->public()
    ->hierarchical()
    ->showInRest()
    ->restBase('book-genres')
    ->showAdminColumn()
    ->showInQuickEdit()
    ->rewrite([
        'slug' => 'books/genre',
        'hierarchical' => true,
    ])
    ->capabilities([
        'manage_terms' => 'manage_book_genres',
        'edit_terms' => 'edit_book_genres',
        'delete_terms' => 'delete_book_genres',
        'assign_terms' => 'assign_book_genres',
    ])
    ->defaultTerm([
        'name' => 'General Fiction',
        'slug' => 'general-fiction',
    ])
    ->adminCols([
        'books' => [
            'title' => '# Books',
            'function' => function($term_id) {
                $term = get_term($term_id);
                return sprintf(
                    '<a href="%s">%d</a>',
                    admin_url('edit.php?post_type=book&genre=' . $term->slug),
                    $term->count
                );
            },
        ],
    ])
    ->enableDashboardGlance();
```

### Exclusive Taxonomy (Radio Buttons)

```php
use Pollora\Entity\Taxonomy;

Taxonomy::make('book_status', 'book', 'Status', 'Statuses')
    ->label('Book Status')
    ->public()
    ->hierarchical()
    ->exclusive()  // Only one status per book
    ->showAdminColumn()
    ->defaultTerm('draft');
```

## Object Type Association

You can associate a taxonomy with multiple post types:

```php
// Single post type
Taxonomy::make('genre', 'book', 'Genre', 'Genres');

// Multiple post types
Taxonomy::make('genre', ['book', 'magazine'], 'Genre', 'Genres');
```

## Method Chaining

All configuration methods return the taxonomy instance, allowing for fluent method chaining. Methods can be called in any order after creation with `make()`.