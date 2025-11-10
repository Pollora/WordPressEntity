# Post Types Documentation

This guide covers all available methods for creating and configuring WordPress custom post types using the Pollora Entity package.

## Creating a Post Type

Post types are created using the static `make()` method, which automatically registers them with WordPress:

```php
use Pollora\Entity\PostType;

$postType = PostType::make('book', 'Book', 'Books');
```

Parameters:
- `$slug` (string, required): The post type slug (max 20 characters)
- `$singular` (string, optional): Singular label for the post type
- `$plural` (string, optional): Plural label for the post type

## Basic Configuration Methods

### Labels and Description

```php
$postType->label('Books')
    ->labels([
        'add_new' => 'Add New Book',
        'add_new_item' => 'Add New Book',
        'edit_item' => 'Edit Book',
        // ... more labels
    ])
    ->description('A custom post type for books');
```

### Visibility Methods

#### Public Access
```php
$postType->public();           // Make post type public
$postType->private();          // Make post type private
$postType->withPublic(true);   // Set public status explicitly
```

#### Query Control
```php
$postType->publiclyQueryable();       // Allow front-end queries
$postType->notPubliclyQueryable();    // Disallow front-end queries
$postType->withPubliclyQueryable(true);
```

#### Search Control
```php
$postType->excludeFromSearch();       // Exclude from search results
$postType->includeInSearch();         // Include in search results
$postType->withExcludeFromSearch(false);
```

### UI Display Methods

#### Admin UI
```php
$postType->showUi();           // Show in admin UI
$postType->hideUi();           // Hide from admin UI
$postType->withShowUi(true);
```

#### Admin Menu
```php
$postType->showInMenu();               // Show in admin menu
$postType->hideFromMenu();             // Hide from admin menu
$postType->withShowInMenu(true);       // Set explicitly
$postType->withShowInMenu('tools.php'); // Show under specific menu
```

#### Navigation Menus
```php
$postType->showInNavMenus();       // Show in nav menus
$postType->hideFromNavMenus();     // Hide from nav menus
$postType->withShowInNavMenus(true);
```

#### Admin Bar
```php
$postType->showInAdminBar();       // Show in admin bar
$postType->hideFromAdminBar();     // Hide from admin bar
$postType->withShowInAdminBar(true);
```

### Hierarchy and Structure

```php
$postType->hierarchical();         // Enable hierarchy (like pages)
$postType->nonHierarchical();      // Disable hierarchy (like posts)
$postType->chronological();        // Alias for non-hierarchical
$postType->withHierarchical(true);
```

### REST API Support

```php
$postType->showInRest();           // Enable REST API
$postType->hideFromRest();         // Disable REST API
$postType->withShowInRest(true);
$postType->restBase('books');      // Set REST base endpoint
$postType->restNamespace('myapi/v1');
$postType->restControllerClass('My_REST_Controller');
```

### Block Editor Support

```php
$postType->blockEditor();          // Enable block editor
$postType->classicEditor();        // Use classic editor
$postType->withBlockEditor(true);
```

## Advanced Configuration

### Menu Configuration

```php
$postType->menuPosition(5)         // Set menu position
    ->menuIcon('dashicons-book');  // Set menu icon
```

### Archive Settings

```php
$postType->hasArchive();           // Enable archives
$postType->hasArchive('books');    // Custom archive slug
```

### URL Rewriting

```php
$postType->rewrite([
    'slug' => 'books',
    'with_front' => false,
    'feeds' => true,
    'pages' => true
]);

$postType->queryVar('book');       // Set query var
$postType->queryVar(false);        // Disable query var
```

### Capabilities

```php
$postType->capabilities([
    'edit_post' => 'edit_book',
    'edit_posts' => 'edit_books',
    'publish_posts' => 'publish_books',
    // ... more capabilities
]);

$postType->capabilityType('book');
$postType->mapMetaCap();           // Map meta capabilities
$postType->withoutMetaCap();       // Don't map meta capabilities
```

### Feature Support

```php
$postType->supports([
    'title',
    'editor',
    'author',
    'thumbnail',
    'excerpt',
    'trackbacks',
    'custom-fields',
    'comments',
    'revisions',
    'page-attributes',
    'post-formats'
]);
```

### Taxonomies

```php
$postType->taxonomies(['category', 'post_tag', 'genre']);
```

### Export and User Deletion

```php
$postType->canExport();            // Allow export
$postType->cannotExport();         // Prevent export
$postType->withCanExport(true);

$postType->deleteWithUser();       // Delete posts when user deleted
$postType->keepOnUserDelete();     // Keep posts when user deleted
$postType->withDeleteWithUser(true);
```

### Templates (Block Editor)

```php
$postType->template([
    ['core/heading', ['placeholder' => 'Book Title']],
    ['core/paragraph', ['placeholder' => 'Book description...']],
]);

$postType->templateLock('all');    // Lock template completely
$postType->templateLock('insert'); // Lock insert only
$postType->templateLock(false);    // No lock
```

## Dashboard Features

### Dashboard Widgets

```php
$postType->dashboardActivity();        // Show in dashboard activity
$postType->withoutDashboardActivity(); // Hide from dashboard activity
$postType->withDashboardActivity(true);

$postType->enableDashboardGlance();    // Show in "At a Glance"
$postType->disableDashboardGlance();   // Hide from "At a Glance"
$postType->withDashboardGlance(true);
```

### Quick Edit

```php
$postType->quickEdit();            // Enable quick edit
$postType->withoutQuickEdit();     // Disable quick edit
$postType->withQuickEdit(true);
```

### RSS Feed

```php
$postType->showInFeed();           // Include in RSS feed
$postType->hideFromFeed();         // Exclude from RSS feed
$postType->withShowInFeed(true);
```

## Extended Features

### Meta Box Registration

```php
$postType->registerMetaBoxCb(function() {
    add_meta_box(
        'book_details',
        'Book Details',
        'render_book_details_meta_box',
        'book'
    );
});
```

### Priority Configuration

```php
$postType->priority(10);           // Set registration priority (default: 5)
```

The priority determines when the post type is registered during WordPress initialization. Lower numbers execute earlier.


### Custom Properties

```php
$postType->titlePlaceholder('Enter book title here');
$postType->featuredImage('Book Cover');
```

### Admin Columns

```php
$postType->adminCols([
    'author' => [
        'title' => 'Author',
        'meta_key' => 'book_author',
    ],
    'isbn' => [
        'title' => 'ISBN',
        'function' => function($post_id) {
            return get_post_meta($post_id, 'isbn', true);
        },
    ],
]);
```

### Admin Filters

```php
$postType->adminFilters([
    'genre' => [
        'title' => 'Filter by Genre',
        'taxonomy' => 'genre',
    ],
]);
```

### Archive Query Modifications

```php
$postType->archive([
    'posts_per_page' => 20,
    'orderby' => 'title',
    'order' => 'ASC',
]);
```

### Site Filters and Sortables

```php
$postType->siteFilters([
    'genre' => [
        'title' => 'Genre',
        'taxonomy' => 'genre',
    ],
]);

$postType->siteSortables([
    'price' => [
        'title' => 'Price',
        'meta_key' => 'book_price',
        'type' => 'numeric',
    ],
]);
```

## Naming Methods

```php
$postType->singular('Book');       // Set singular name
$postType->plural('Books');        // Set plural name
$postType->slug('book');           // Set slug
$postType->names([                 // Set all names at once
    'singular' => 'Book',
    'plural' => 'Books',
    'slug' => 'book',
]);
```

## Complete Example

```php
use Pollora\Entity\PostType;

PostType::make('book', 'Book', 'Books')
    ->label('Books')
    ->description('Custom post type for managing books')
    ->public()
    ->showInRest()
    ->hasArchive('books')
    ->menuIcon('dashicons-book')
    ->menuPosition(5)
    ->supports(['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'])
    ->taxonomies(['genre', 'author'])
    ->capabilities([
        'edit_post' => 'edit_book',
        'edit_posts' => 'edit_books',
        'publish_posts' => 'publish_books',
    ])
    ->adminCols([
        'isbn' => [
            'title' => 'ISBN',
            'meta_key' => 'book_isbn',
        ],
        'price' => [
            'title' => 'Price',
            'function' => function($post_id) {
                return '$' . get_post_meta($post_id, 'book_price', true);
            },
        ],
    ])
    ->dashboardActivity()
    ->enableDashboardGlance();
```

## Method Chaining

All configuration methods return the post type instance, allowing for fluent method chaining. Methods can be called in any order after creation with `make()`.
