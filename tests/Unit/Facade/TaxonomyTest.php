<?php

declare(strict_types=1);

use Pollora\Entity\Domain\Model\Taxonomy as TaxonomyDomain;
use Pollora\Entity\Taxonomy;

test('can create taxonomy through facade', function () {
    $taxonomy = Taxonomy::make('test-taxonomy', 'post', 'Test', 'Tests');

    expect($taxonomy)->toBeInstanceOf(TaxonomyDomain::class)
        ->and($taxonomy->getSlug())->toBe('test-taxonomy')
        ->and($taxonomy->getObjectType())->toBe('post');
});

test('can create taxonomy with multiple object types through facade', function () {
    $objectTypes = ['post', 'page', 'custom-post-type'];
    $taxonomy = Taxonomy::make('test-taxonomy', $objectTypes, 'Test', 'Tests');

    expect($taxonomy)->toBeInstanceOf(TaxonomyDomain::class)
        ->and($taxonomy->getObjectType())->toBe($objectTypes);
});

test('can use fluent methods to set properties', function () {
    $taxonomy = Taxonomy::make('product_cat', 'product', 'Category', 'Categories')
        ->public()
        ->hierarchical()
        ->showInRest()
        ->showAdminColumn()
        ->showInQuickEdit()
        ->rewrite(['slug' => 'product-category', 'with_front' => false]);

    $args = $taxonomy->getArgs();

    expect($args)->toBeArray()
        ->and($args['public'])->toBeTrue()
        ->and($args['hierarchical'])->toBeTrue()
        ->and($args['show_in_rest'])->toBeTrue()
        ->and($args['show_admin_column'])->toBeTrue()
        ->and($args['show_in_quick_edit'])->toBeTrue()
        ->and($args['rewrite'])->toBe(['slug' => 'product-category', 'with_front' => false]);
});

test('can chain multiple fluent methods', function () {
    $taxonomy = Taxonomy::make('location', ['post', 'event'], 'Location', 'Locations')
        ->public()
        ->showUi()
        ->showInMenu()
        ->showInNavMenus()
        ->publiclyQueryable()
        ->hideFromTagCloud()
        ->sort(true)
        ->exclusive()
        ->checkedOntop()
        ->queryVar('location')
        ->defaultTerm([
            'name' => 'Uncategorized',
            'slug' => 'uncategorized',
        ]);

    $args = $taxonomy->getArgs();

    expect($args)->toBeArray()
        ->and($args['public'])->toBeTrue()
        ->and($args['show_ui'])->toBeTrue()
        ->and($args['show_in_menu'])->toBeTrue()
        ->and($args['show_in_nav_menus'])->toBeTrue()
        ->and($args['publicly_queryable'])->toBeTrue()
        ->and($args['show_tagcloud'])->toBeFalse()
        ->and($args['sort'])->toBeTrue()
        ->and($args['exclusive'])->toBeTrue()
        ->and($args['checked_ontop'])->toBeTrue()
        ->and($args['query_var'])->toBe('location')
        ->and($args['default_term'])->toBe([
            'name' => 'Uncategorized',
            'slug' => 'uncategorized',
        ]);
});

test('can set labels and description', function () {
    $taxonomy = Taxonomy::make('genre', 'book', 'Genre', 'Genres')
        ->setLabel('Genres')
        ->setDescription('Book genres taxonomy')
        ->setLabels([
            'name' => 'Genres',
            'singular_name' => 'Genre',
            'search_items' => 'Search Genres',
            'all_items' => 'All Genres',
            'edit_item' => 'Edit Genre',
            'update_item' => 'Update Genre',
            'add_new_item' => 'Add New Genre',
        ]);

    $args = $taxonomy->getArgs();

    expect($args)->toBeArray()
        ->and($args['label'])->toBe('Genres')
        ->and($args['description'])->toBe('Book genres taxonomy')
        ->and($args['labels'])->toBeArray()
        ->and($args['labels']['name'])->toBe('Genres')
        ->and($args['labels']['singular_name'])->toBe('Genre')
        ->and($args['labels']['search_items'])->toBe('Search Genres');
});

test('can set rest API properties', function () {
    $taxonomy = Taxonomy::make('custom_tag', 'post', 'Tag', 'Tags')
        ->showInRest()
        ->restBase('custom-tags')
        ->restControllerClass('WP_REST_Terms_Controller')
        ->restNamespace('custom/v2');

    $args = $taxonomy->getArgs();

    expect($args)->toBeArray()
        ->and($args['show_in_rest'])->toBeTrue()
        ->and($args['rest_base'])->toBe('custom-tags')
        ->and($args['rest_controller_class'])->toBe('WP_REST_Terms_Controller')
        ->and($args['rest_namespace'])->toBe('custom/v2');
});

test('can set callback functions', function () {
    $metaBoxCb = function() { echo 'Meta box content'; };
    $sanitizeCb = function($value) { return sanitize_text_field($value); };
    $countCb = function() { return 0; };

    $taxonomy = Taxonomy::make('custom_tax', 'post', 'Custom', 'Customs')
        ->metaBoxCb($metaBoxCb)
        ->metaBoxSanitizeCb($sanitizeCb)
        ->updateCountCallback($countCb);

    $args = $taxonomy->getArgs();

    expect($args)->toBeArray()
        ->and($args['meta_box_cb'])->toBe($metaBoxCb)
        ->and($args['meta_box_sanitize_cb'])->toBe($sanitizeCb)
        ->and($args['update_count_callback'])->toBe($countCb);
});

test('can set hierarchy settings', function () {
    $taxonomy = Taxonomy::make('department', 'employee', 'Department', 'Departments')
        ->hierarchical()
        ->allowHierarchy();

    $args = $taxonomy->getArgs();

    expect($args)->toBeArray()
        ->and($args['hierarchical'])->toBeTrue()
        ->and($args['allow_hierarchy'])->toBeTrue();
});

test('private method sets public to false', function () {
    $taxonomy = Taxonomy::make('internal_cat', 'post', 'Internal', 'Internals')
        ->private();

    $args = $taxonomy->getArgs();

    expect($args)->toBeArray()
        ->and($args['public'])->toBeFalse();
});

test('can use withArgs to set custom arguments', function () {
    $taxonomy = Taxonomy::make('custom_tax', 'post', 'Custom', 'Customs')
        ->setRawArgs([
            'custom_arg' => 'custom_value',
            'another_custom' => true,
            'nested' => [
                'value' => 'nested_value'
            ],
            'capabilities' => [
                'manage_terms' => 'manage_categories',
                'edit_terms' => 'manage_categories',
                'delete_terms' => 'manage_categories',
                'assign_terms' => 'edit_posts',
            ]
        ]);

    $args = $taxonomy->getArgs();

    expect($args)->toBeArray()
        ->and($args['custom_arg'])->toBe('custom_value')
        ->and($args['another_custom'])->toBeTrue()
        ->and($args['nested'])->toBe(['value' => 'nested_value'])
        ->and($args['capabilities'])->toBe([
            'manage_terms' => 'manage_categories',
            'edit_terms' => 'manage_categories',
            'delete_terms' => 'manage_categories',
            'assign_terms' => 'edit_posts',
        ]);
});

test('can handle single object type as string', function () {
    $taxonomy = Taxonomy::make('category', 'post', 'Category', 'Categories');

    expect($taxonomy->getObjectType())->toBe('post');
});

$taxonomy = Taxonomy::make('color', 'product', 'Color', 'Colors')
    ->args([
        '_builtin' => false,
        'show_in_quick_edit' => true,
    ]);

$args = $taxonomy->getArgs();

test('can set args property for additional arguments', function () {
    $taxonomy = Taxonomy::make('color', 'product', 'Color', 'Colors')
        ->args([
            '_builtin' => false,
            'show_in_quick_edit' => true,
        ]);

    $args = $taxonomy->getArgs();

    expect($args)->toBeArray()
        ->and($args['args']['_builtin'])->toBeFalse()
        ->and($args['args']['show_in_quick_edit'])->toBeTrue();
});
