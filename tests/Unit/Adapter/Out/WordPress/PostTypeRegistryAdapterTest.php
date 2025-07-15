<?php

declare(strict_types=1);

use Pollora\Entity\Adapter\Out\WordPress\PostTypeRegistryAdapter;

test('can create post type registry adapter', function () {
    $adapter = new PostTypeRegistryAdapter;

    expect($adapter)->toBeInstanceOf(PostTypeRegistryAdapter::class);
});

test('can register post type', function () {
    $adapter = new PostTypeRegistryAdapter;

    $slug = 'test-post-type';
    $args = [
        'label' => 'Test Post Type',
        'description' => 'A test post type',
        'public' => true,
    ];
    $names = [
        'singular' => 'Test',
        'plural' => 'Tests',
    ];

    // This should not generate any errors
    $adapter->register($slug, $args, $names);

    expect(true)->toBeTrue(); // Placeholder assertion
});

test('can register post type with explicit method', function () {
    $adapter = new PostTypeRegistryAdapter;

    $slug = 'test-post-type';
    $args = [
        'label' => 'Test Post Type',
        'description' => 'A test post type',
        'public' => true,
    ];
    $names = [
        'singular' => 'Test',
        'plural' => 'Tests',
    ];

    // This should not generate any errors
    $adapter->registerPostType($slug, $args, $names);

    expect(true)->toBeTrue(); // Placeholder assertion
});
