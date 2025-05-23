<?php

declare(strict_types=1);

use Pollora\Entity\Domain\Model\PostType;

test('can create post type instance', function () {
    $postType = new PostType('test-post-type', 'Test', 'Tests');

    expect($postType)->toBeInstanceOf(PostType::class)
        ->and($postType->getSlug())->toBe('test-post-type')
        ->and($postType->getEntity())->toBe('post-types');
});

test('can create post type using static factory method', function () {
    $postType = PostType::make('test-post-type', 'Test', 'Tests');

    expect($postType)->toBeInstanceOf(PostType::class)
        ->and($postType->getSlug())->toBe('test-post-type');
});

test('can set and get post type specific properties', function () {
    $postType = new PostType('test-post-type');

    // Test menu settings
    $postType->setMenuPosition(25);
    expect($postType->getMenuPosition())->toBe(25);

    $postType->setMenuIcon('dashicons-admin-post');
    expect($postType->getMenuIcon())->toBe('dashicons-admin-post');

    // Test hierarchical settings
    $postType->setHierarchical(true);
    expect($postType->isHierarchical())->toBeTrue();

    $postType->chronological();
    expect($postType->isHierarchical())->toBeFalse();

    // Test archive settings
    $postType->hasArchive();
    expect($postType->getHasArchive())->toBeTrue();

    $postType->hasArchive('custom-archive');
    expect($postType->getHasArchive())->toBe('custom-archive');

    // Test capability settings
    $postType->setCapabilityType('page');
    expect($postType->getCapabilityType())->toBe('page');

    $postType->mapMetaCap();
    expect($postType->isMapMetaCap())->toBeTrue();
});

test('can set and get admin column settings', function () {
    $postType = new PostType('test-post-type');

    $adminCols = [
        'title' => [
            'title' => 'Title',
            'default' => true,
        ],
        'author' => [
            'title' => 'Author',
        ],
        'date' => [
            'title' => 'Date',
        ],
    ];

    $postType->setAdminCols($adminCols);
    expect($postType->getAdminCols())->toBe($adminCols);
});

test('can set and get supports property', function () {
    $postType = new PostType('test-post-type');

    $supports = [
        'title',
        'editor',
        'author',
        'thumbnail',
        'excerpt',
        'comments',
    ];

    $postType->supports($supports);
    expect($postType->getSupports())->toBe($supports);
});

test('can set and get taxonomies', function () {
    $postType = new PostType('test-post-type');

    $taxonomies = ['category', 'post_tag', 'custom-tax'];

    $postType->setTaxonomies($taxonomies);
    expect($postType->getTaxonomies())->toBe($taxonomies);
});

test('can set show in admin bar', function () {
    $postType = new PostType('test-post-type');

    $postType->showInAdminBar();
    expect($postType->getShowInAdminBar())->toBeTrue();

    $postType->setShowInAdminBar(false);
    expect($postType->getShowInAdminBar())->toBeFalse();
});

test('can set dashboard activity', function () {
    $postType = new PostType('test-post-type');

    $postType->enableDashboardActivity();
    expect($postType->isDashboardActivity())->toBeTrue();

    $postType->setDashboardActivity(false);
    expect($postType->isDashboardActivity())->toBeFalse();
});

test('can set exclude from search', function () {
    $postType = new PostType('test-post-type');

    $postType->excludeFromSearch();
    expect($postType->getExcludeFromSearch())->toBeTrue();

    $postType->setExcludeFromSearch(false);
    expect($postType->getExcludeFromSearch())->toBeFalse();
});

test('can set and get title placeholder', function () {
    $postType = new PostType('test-post-type');

    $postType->titlePlaceholder('Enter test title here');
    expect($postType->getEnterTitleHere())->toBe('Enter test title here');
});

test('can build post type arguments correctly', function () {
    $postType = new PostType('test-post-type', 'Test', 'Tests');
    $postType->setLabel('Test Post Type');
    $postType->setDescription('A test post type');
    $postType->public();
    $postType->hasArchive();
    $postType->setMenuIcon('dashicons-admin-post');
    $postType->setMenuPosition(25);
    $postType->supports(['title', 'editor', 'thumbnail']);

    $args = $postType->getArgs();

    expect($args)->toBeArray()
        ->and($args)->toHaveKey('label')
        ->and($args['label'])->toBe('Test Post Type')
        ->and($args)->toHaveKey('description')
        ->and($args['description'])->toBe('A test post type')
        ->and($args)->toHaveKey('public')
        ->and($args['public'])->toBeTrue()
        ->and($args)->toHaveKey('has_archive')
        ->and($args['has_archive'])->toBeTrue()
        ->and($args)->toHaveKey('menu_icon')
        ->and($args['menu_icon'])->toBe('dashicons-admin-post')
        ->and($args)->toHaveKey('menu_position')
        ->and($args['menu_position'])->toBe(25)
        ->and($args)->toHaveKey('supports')
        ->and($args['supports'])->toBe(['title', 'editor', 'thumbnail']);
});
