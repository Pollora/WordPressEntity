<?php

declare(strict_types=1);

namespace Pollora\Entity\Tests\Unit\Domain\Models;

use Pollora\Entity\Domain\Models\PostType;

it('can create a post type with minimal properties', function () {
    $postType = new PostType('book');

    expect($postType->getSlug())->toBe('book')
        ->and($postType->getEntity())->toBe('post-types')
        ->and($postType->getSingular())->toBeNull()
        ->and($postType->getPlural())->toBeNull();
});

it('can create a post type with all constructor properties', function () {
    $postType = new PostType('book', 'Book', 'Books');

    expect($postType->getSlug())->toBe('book')
        ->and($postType->getSingular())->toBe('Book')
        ->and($postType->getPlural())->toBe('Books');
});

it('can be created using the make static method', function () {
    $postType = PostType::make('book', 'Book', 'Books');

    expect($postType)->toBeInstanceOf(PostType::class)
        ->and($postType->getSlug())->toBe('book')
        ->and($postType->getSingular())->toBe('Book')
        ->and($postType->getPlural())->toBe('Books');
});

it('converts to array correctly', function () {
    $postType = new PostType('book', 'Book', 'Books');
    $postType->public();
    $postType->hierarchical();
    $postType->setMenuIcon('dashicons-book');

    $array = $postType->toArray();

    expect($array)->toBeArray()
        ->and($array)->toHaveKey('slug', 'book')
        ->and($array)->toHaveKey('singular', 'Book')
        ->and($array)->toHaveKey('plural', 'Books')
        ->and($array)->toHaveKey('public', true)
        ->and($array)->toHaveKey('menu_icon', 'dashicons-book')
        ->and($array)->toHaveKey('hierarchical', true);
});

it('sets and gets basic properties correctly', function () {
    $postType = new PostType('book');

    // Set and check description
    $postType->setDescription('Custom book post type');
    expect($postType->getDescription())->toBe('Custom book post type');

    // Set and check label
    $postType->setLabel('Books');
    expect($postType->getLabel())->toBe('Books');

    // Set and check labels array
    $labels = [
        'add_new' => 'Add New Book',
        'edit_item' => 'Edit Book',
    ];
    $postType->setLabels($labels);
    expect($postType->getLabels())->toBe($labels);
});

it('handles boolean properties correctly', function () {
    $postType = new PostType('book');

    // Public property
    expect($postType->isPublic())->toBeNull();
    $postType->public();
    expect($postType->isPublic())->toBeTrue();
    $postType->private();
    expect($postType->isPublic())->toBeFalse();
    $postType->setPublic(true);
    expect($postType->isPublic())->toBeTrue();

    // Hierarchical property
    expect($postType->isHierarchical())->toBeNull();
    $postType->hierarchical();
    expect($postType->isHierarchical())->toBeTrue();

    // ExcludeFromSearch property
    expect($postType->getExcludeFromSearch())->toBeNull();
    $postType->excludeFromSearch();
    expect($postType->getExcludeFromSearch())->toBeTrue();
    $postType->setExcludeFromSearch(false);
    expect($postType->getExcludeFromSearch())->toBeFalse();
});

it('handles string properties correctly', function () {
    $postType = new PostType('book');

    // Menu icon
    expect($postType->getMenuIcon())->toBeNull();
    $postType->setMenuIcon('dashicons-book');
    expect($postType->getMenuIcon())->toBe('dashicons-book');

    // Capability type
    expect($postType->getCapabilityType())->toBeNull();
    $postType->setCapabilityType('book');
    expect($postType->getCapabilityType())->toBe('book');
});

it('handles integer properties correctly', function () {
    $postType = new PostType('book');

    // Menu position
    expect($postType->getMenuPosition())->toBeNull();
    $postType->setMenuPosition(5);
    expect($postType->getMenuPosition())->toBe(5);
});

it('handles array properties correctly', function () {
    $postType = new PostType('book');

    // Taxonomies
    expect($postType->getTaxonomies())->toBeNull();
    $postType->setTaxonomies(['genre', 'author']);
    expect($postType->getTaxonomies())->toBe(['genre', 'author']);

    // Supports
    $supports = ['title', 'editor', 'thumbnail'];
    $postType->supports($supports);
    expect($postType->getSupports())->toBe($supports);
});

it('handles complex properties correctly', function () {
    $postType = new PostType('book');

    // Rewrite
    $rewrite = [
        'slug' => 'books',
        'with_front' => false,
    ];
    $postType->setRewrite($rewrite);
    expect($postType->getRewrite())->toBe($rewrite);

    // Has archive with string
    $postType->hasArchive('library');
    expect($postType->getHasArchive())->toBe('library');

    // Has archive with boolean
    $postType->hasArchive(true);
    expect($postType->getHasArchive())->toBeTrue();
});

it('handles admin-related properties correctly', function () {
    $postType = new PostType('book');

    // ShowInAdminBar property
    expect($postType->getShowInAdminBar())->toBeNull();
    $postType->showInAdminBar();
    expect($postType->getShowInAdminBar())->toBeTrue();
    $postType->setShowInAdminBar(false);
    expect($postType->getShowInAdminBar())->toBeFalse();

    // MapMetaCap property
    expect($postType->isMapMetaCap())->toBeNull();
    $postType->mapMetaCap();
    expect($postType->isMapMetaCap())->toBeTrue();
    $postType->setMapMetaCap(false);
    expect($postType->isMapMetaCap())->toBeFalse();

    // QuickEdit property
    expect($postType->isQuickEdit())->toBeNull();
    $postType->enableQuickEdit();
    expect($postType->isQuickEdit())->toBeTrue();
    $postType->setQuickEdit(false);
    expect($postType->isQuickEdit())->toBeFalse();

    // AdminFilters property
    expect($postType->getAdminFilters())->toBeNull();
    $filters = ['category' => ['title' => 'Category']];
    $postType->adminFilters($filters);
    expect($postType->getAdminFilters())->toBe($filters);
});

it('handles display-related properties correctly', function () {
    $postType = new PostType('book');

    // Featured Image
    expect($postType->getFeaturedImage())->toBeNull();
    $postType->setFeaturedImage('Book Cover');
    expect($postType->getFeaturedImage())->toBe('Book Cover');

    // Enter Title Here
    expect($postType->getEnterTitleHere())->toBeNull();
    $postType->titlePlaceholder('Enter book title here');
    expect($postType->getEnterTitleHere())->toBe('Enter book title here');

    // ShowInFeed property
    expect($postType->isShowInFeed())->toBeNull();
    $postType->showInFeed();
    expect($postType->isShowInFeed())->toBeTrue();
    $postType->setShowInFeed(false);
    expect($postType->isShowInFeed())->toBeFalse();
});

it('handles frontend-related properties correctly', function () {
    $postType = new PostType('book');

    // SiteFilters
    expect($postType->getSiteFilters())->toBeNull();
    $filters = ['author' => ['title' => 'Author']];
    $postType->siteFilters($filters);
    expect($postType->getSiteFilters())->toBe($filters);

    // SiteSortables
    expect($postType->getSiteSortables())->toBeNull();
    $sortables = ['price' => ['title' => 'Price']];
    $postType->siteSortables($sortables);
    expect($postType->getSiteSortables())->toBe($sortables);

    // Archive
    expect($postType->getArchive())->toBeNull();
    $archive = ['nopaging' => true];
    $postType->setArchive($archive);
    expect($postType->getArchive())->toBe($archive);
});

it('handles editor-related properties correctly', function () {
    $postType = new PostType('book');

    // Block Editor
    expect($postType->isBlockEditor())->toBeNull();
    $postType->enableBlockEditor();
    expect($postType->isBlockEditor())->toBeTrue();
    $postType->setBlockEditor(false);
    expect($postType->isBlockEditor())->toBeFalse();

    // Template
    expect($postType->getTemplate())->toBeNull();
    $template = [['core/paragraph']];
    $postType->setTemplate($template);
    expect($postType->getTemplate())->toBe($template);

    // Template Lock
    expect($postType->getTemplateLock())->toBeNull();
    $postType->setTemplateLock('all');
    expect($postType->getTemplateLock())->toBe('all');
});

it('handles dashboard-related properties correctly', function () {
    $postType = new PostType('book');

    // Dashboard Activity
    expect($postType->isDashboardActivity())->toBeNull();
    $postType->enableDashboardActivity();
    expect($postType->isDashboardActivity())->toBeTrue();
    $postType->setDashboardActivity(false);
    expect($postType->isDashboardActivity())->toBeFalse();

    // CanExport property
    expect($postType->getCanExport())->toBeNull();
    $postType->canExport();
    expect($postType->getCanExport())->toBeTrue();
    $postType->setCanExport(false);
    expect($postType->getCanExport())->toBeFalse();

    // DeleteWithUser property
    expect($postType->getDeleteWithUser())->toBeNull();
    $postType->deletedWithUser();
    expect($postType->getDeleteWithUser())->toBeTrue();
    $postType->setDeleteWithUser(false);
    expect($postType->getDeleteWithUser())->toBeFalse();
});

it('handles special methods correctly', function () {
    $postType = new PostType('book');

    // Chronological method
    expect($postType->isHierarchical())->toBeNull();
    $postType->hierarchical(); // Set to true
    expect($postType->isHierarchical())->toBeTrue();
    $postType->chronological(); // Set to false
    expect($postType->isHierarchical())->toBeFalse();
});

it('handles raw arguments correctly', function () {
    $postType = new PostType('book');
    $rawArgs = [
        'public' => true,
        'supports' => ['title', 'editor'],
    ];
    
    $postType->rawArgs($rawArgs);
    
    $result = $postType->toArray();
    expect($result)->toHaveKeys(array_keys($rawArgs))
        ->and($result['public'])->toBe($rawArgs['public'])
        ->and($result['supports'])->toBe($rawArgs['supports']);
});

it('prioritizes raw arguments over individual properties', function () {
    $postType = new PostType('book');
    $rawArgs = [
        'public' => false,
        'menu_icon' => 'dashicons-book',
        'supports' => ['title', 'editor'],
    ];
    
    $postType->rawArgs($rawArgs);
    
    $result = $postType->toArray();
    expect($result)->toHaveKeys(array_keys($rawArgs))
        ->and($result['public'])->toBe($rawArgs['public'])
        ->and($result['menu_icon'])->toBe($rawArgs['menu_icon'])
        ->and($result['supports'])->toBe($rawArgs['supports']);
});

it('merges raw arguments with individual properties', function () {
    $postType = new PostType('book');
    $postType->setShowInRest(true);
    
    $rawArgs = [
        'public' => false,
        'menu_icon' => 'dashicons-book',
        'supports' => ['title', 'editor', 'thumbnail'],
    ];
    
    $postType->rawArgs($rawArgs);
    
    $result = $postType->toArray();
    expect($result)->toHaveKeys(array_merge(['show_in_rest'], array_keys($rawArgs)))
        ->and($result['public'])->toBe($rawArgs['public'])
        ->and($result['menu_icon'])->toBe($rawArgs['menu_icon'])
        ->and($result['supports'])->toBe($rawArgs['supports'])
        ->and($result['show_in_rest'])->toBe(true);
});

it('handles REST API properties correctly', function () {
    $postType = new PostType('book');

    // ShowInRest property
    expect($postType->getShowInRest())->toBeNull();
    $postType->setShowInRest(true);
    expect($postType->getShowInRest())->toBeTrue();
    $postType->setShowInRest(false);
    expect($postType->getShowInRest())->toBeFalse();

    // RestBase property
    expect($postType->getRestBase())->toBeNull();
    $postType->setRestBase('books-api');
    expect($postType->getRestBase())->toBe('books-api');

    // RestNamespace property
    expect($postType->getRestNamespace())->toBeNull();
    $postType->setRestNamespace('my-api/v1');
    expect($postType->getRestNamespace())->toBe('my-api/v1');

    // RestControllerClass property
    expect($postType->getRestControllerClass())->toBeNull();
    $postType->setRestControllerClass('MyRestController');
    expect($postType->getRestControllerClass())->toBe('MyRestController');
});

it('handles menu and navigation properties correctly', function () {
    $postType = new PostType('book');

    // ShowInMenu property
    expect($postType->getShowInMenu())->toBeNull();
    $postType->setShowInMenu(true);
    expect($postType->getShowInMenu())->toBeTrue();
    $postType->setShowInMenu('edit.php?post_type=page');
    expect($postType->getShowInMenu())->toBe('edit.php?post_type=page');

    // ShowInNavMenus property
    expect($postType->getShowInNavMenus())->toBeNull();
    $postType->setShowInNavMenus(true);
    expect($postType->getShowInNavMenus())->toBeTrue();
    $postType->setShowInNavMenus(false);
    expect($postType->getShowInNavMenus())->toBeFalse();
});

it('handles query var properties correctly', function () {
    $postType = new PostType('book');

    // QueryVar property
    expect($postType->getQueryVar())->toBeNull();
    $postType->setQueryVar('custom-query');
    expect($postType->getQueryVar())->toBe('custom-query');
    $postType->setQueryVar(false);
    expect($postType->getQueryVar())->toBeFalse();
});

it('handles capabilities correctly', function () {
    $postType = new PostType('book');

    // Capabilities property
    expect($postType->getCapabilities())->toBeNull();
    $capabilities = [
        'edit_post' => 'edit_book',
        'read_post' => 'read_book',
        'delete_post' => 'delete_book',
        'edit_posts' => 'edit_books',
        'edit_others_posts' => 'edit_others_books',
        'publish_posts' => 'publish_books',
        'read_private_posts' => 'read_private_books'
    ];
    $postType->setCapabilities($capabilities);
    expect($postType->getCapabilities())->toBe($capabilities);
});

it('handles dashboard glance correctly', function () {
    $postType = new PostType('book');

    // DashboardGlance property
    expect($postType->getDashboardGlance())->toBeNull();
    $postType->setDashboardGlance(true);
    expect($postType->getDashboardGlance())->toBeTrue();
    $postType->setDashboardGlance(false);
    expect($postType->getDashboardGlance())->toBeFalse();
});

it('handles admin columns correctly', function () {
    $postType = new PostType('book');

    // AdminCols property
    expect($postType->getAdminCols())->toBeNull();
    $adminCols = [
        'featured_image' => [
            'title' => 'Cover',
            'width' => 80,
            'height' => 80
        ],
        'published' => [
            'title' => 'Published',
            'meta_key' => 'published_date'
        ]
    ];
    $postType->setAdminCols($adminCols);
    expect($postType->getAdminCols())->toBe($adminCols);
});
