<?php

declare(strict_types=1);

use Pollora\Entity\Domain\Model\PostType as PostTypeDomain;
use Pollora\Entity\PostType;

test('can create post type through facade', function () {
    $postType = PostType::make('test-post-type', 'Test', 'Tests');

    expect($postType)->toBeInstanceOf(PostTypeDomain::class)
        ->and($postType->getSlug())->toBe('test-post-type');
});

test('can use fluent methods to set properties', function () {
    $postType = PostType::make('customer', 'Customer', 'Customers')
        ->showInRest()
        ->public()
        ->hierarchical()
        ->menuIcon('dashicons-businessman')
        ->supports(['title', 'editor', 'thumbnail']);

    $args = $postType->getArgs();

    expect($args)->toBeArray()
        ->and($args['show_in_rest'])->toBeTrue()
        ->and($args['public'])->toBeTrue()
        ->and($args['hierarchical'])->toBeTrue()
        ->and($args['menu_icon'])->toBe('dashicons-businessman')
        ->and($args['supports'])->toBe(['title', 'editor', 'thumbnail']);
});

test('can chain multiple fluent methods', function () {
    $postType = PostType::make('product', 'Product', 'Products')
        ->public()
        ->showUi()
        ->showInMenu()
        ->showInNavMenus()
        ->showInAdminBar()
        ->excludeFromSearch()
        ->publiclyQueryable()
        ->hasArchive('products')
        ->rewrite(['slug' => 'products', 'with_front' => false])
        ->menuPosition(5)
        ->capabilityType('product');

    $args = $postType->getArgs();

    expect($args)->toBeArray()
        ->and($args['public'])->toBeTrue()
        ->and($args['show_ui'])->toBeTrue()
        ->and($args['show_in_menu'])->toBeTrue()
        ->and($args['show_in_nav_menus'])->toBeTrue()
        ->and($args['show_in_admin_bar'])->toBeTrue()
        ->and($args['exclude_from_search'])->toBeTrue()
        ->and($args['publicly_queryable'])->toBeTrue()
        ->and($args['has_archive'])->toBe('products')
        ->and($args['rewrite'])->toBe(['slug' => 'products', 'with_front' => false])
        ->and($args['menu_position'])->toBe(5)
        ->and($args['capability_type'])->toBe('product');
});

test('can set labels and description', function () {
    $postType = PostType::make('event', 'Event', 'Events')
        ->setLabel('Events')
        ->setDescription('Custom post type for events')
        ->setLabels([
            'name' => 'Events',
            'singular_name' => 'Event',
            'add_new' => 'Add New Event',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
        ]);

    $args = $postType->getArgs();

    expect($args)->toBeArray()
        ->and($args['label'])->toBe('Events')
        ->and($args['description'])->toBe('Custom post type for events')
        ->and($args['labels'])->toBeArray()
        ->and($args['labels']['name'])->toBe('Events')
        ->and($args['labels']['singular_name'])->toBe('Event')
        ->and($args['labels']['add_new'])->toBe('Add New Event');
});

test('can set rest API properties', function () {
    $postType = PostType::make('api-resource', 'API Resource', 'API Resources')
        ->showInRest()
        ->restBase('resources')
        ->restControllerClass('WP_REST_Posts_Controller')
        ->restNamespace('custom/v1');

    $args = $postType->getArgs();

    expect($args)->toBeArray()
        ->and($args['show_in_rest'])->toBeTrue()
        ->and($args['rest_base'])->toBe('resources')
        ->and($args['rest_controller_class'])->toBe('WP_REST_Posts_Controller')
        ->and($args['rest_namespace'])->toBe('custom/v1');
});

test('can set taxonomies for post type', function () {
    $postType = PostType::make('product', 'Product', 'Products')
        ->taxonomies(['category', 'post_tag', 'product_cat']);

    $args = $postType->getArgs();

    expect($args)->toBeArray()
        ->and($args['taxonomies'])->toBe(['category', 'post_tag', 'product_cat']);
});

test('private method sets public to false', function () {
    $postType = PostType::make('internal', 'Internal', 'Internals')
        ->private();

    $args = $postType->getArgs();

    expect($args)->toBeArray()
        ->and($args['public'])->toBeFalse();
});

test('can use withArgs to set custom arguments', function () {
    $postType = PostType::make('custom', 'Custom', 'Customs')
        ->setRawArgs([
            'custom_arg' => 'custom_value',
            'another_custom' => true,
            'nested' => [
                'value' => 'nested_value'
            ]
        ]);

    $args = $postType->getArgs();

    expect($args)->toBeArray()
        ->and($args['custom_arg'])->toBe('custom_value')
        ->and($args['another_custom'])->toBeTrue()
        ->and($args['nested'])->toBe(['value' => 'nested_value']);
});
