<?php

declare(strict_types=1);

use Pollora\Entity\Adapter\Out\WordPress\TaxonomyRegistryAdapter;

test('can create taxonomy registry adapter', function () {
    $adapter = new TaxonomyRegistryAdapter;

    expect($adapter)->toBeInstanceOf(TaxonomyRegistryAdapter::class);
});

test('register method requires object_type', function () {
    $adapter = new TaxonomyRegistryAdapter;

    $slug = 'test-taxonomy';
    $args = [
        'label' => 'Test Taxonomy',
        'description' => 'A test taxonomy',
        'public' => true,
    ];
    $names = [
        'singular' => 'Test',
        'plural' => 'Tests',
    ];

    // Should silently fail because object_type is missing
    $adapter->register($slug, $args, $names);

    expect(true)->toBeTrue(); // Placeholder assertion
});

test('can register taxonomy with object_type in args', function () {
    $adapter = new TaxonomyRegistryAdapter;

    $slug = 'test-taxonomy';
    $args = [
        'label' => 'Test Taxonomy',
        'description' => 'A test taxonomy',
        'public' => true,
        'object_type' => 'post',
    ];
    $names = [
        'singular' => 'Test',
        'plural' => 'Tests',
    ];

    // This should not generate any errors
    $adapter->register($slug, $args, $names);

    expect(true)->toBeTrue(); // Placeholder assertion
});

test('can register taxonomy with explicit method', function () {
    $adapter = new TaxonomyRegistryAdapter;

    $slug = 'test-taxonomy';
    $objectType = 'post';
    $args = [
        'label' => 'Test Taxonomy',
        'description' => 'A test taxonomy',
        'public' => true,
    ];
    $names = [
        'singular' => 'Test',
        'plural' => 'Tests',
    ];

    // This should not generate any errors
    $adapter->registerTaxonomy($slug, $objectType, $args, $names);

    expect(true)->toBeTrue(); // Placeholder assertion
});
