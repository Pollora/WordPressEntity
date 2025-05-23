<?php

declare(strict_types=1);

use Pollora\Entity\Domain\Model\Taxonomy;

test('can create taxonomy instance', function () {
    $taxonomy = new Taxonomy('test-taxonomy', 'post', 'Test', 'Tests');

    expect($taxonomy)->toBeInstanceOf(Taxonomy::class)
        ->and($taxonomy->getSlug())->toBe('test-taxonomy')
        ->and($taxonomy->getObjectType())->toBe('post')
        ->and($taxonomy->getEntity())->toBe('taxonomies');
});

test('can create taxonomy using static factory method', function () {
    $taxonomy = Taxonomy::make('test-taxonomy', 'post', 'Test', 'Tests');

    expect($taxonomy)->toBeInstanceOf(Taxonomy::class)
        ->and($taxonomy->getSlug())->toBe('test-taxonomy')
        ->and($taxonomy->getObjectType())->toBe('post');
});

test('can create taxonomy with multiple object types', function () {
    $objectTypes = ['post', 'page', 'custom-post-type'];
    $taxonomy = new Taxonomy('test-taxonomy', $objectTypes);

    expect($taxonomy->getObjectType())->toBe($objectTypes);
});

test('can set and get taxonomy specific properties', function () {
    $taxonomy = new Taxonomy('test-taxonomy', 'post');

    // Test tagcloud settings
    $taxonomy->showTagcloud();
    expect($taxonomy->isShowTagcloud())->toBeTrue();

    $taxonomy->setShowTagcloud(false);
    expect($taxonomy->isShowTagcloud())->toBeFalse();

    // Test quick edit settings
    $taxonomy->showInQuickEdit();
    expect($taxonomy->isShowInQuickEdit())->toBeTrue();

    $taxonomy->setShowInQuickEdit(false);
    expect($taxonomy->isShowInQuickEdit())->toBeFalse();

    // Test admin column settings
    $taxonomy->showAdminColumn();
    expect($taxonomy->isShowAdminColumn())->toBeTrue();

    $taxonomy->setShowAdminColumn(false);
    expect($taxonomy->isShowAdminColumn())->toBeFalse();

    // Test sort settings
    $taxonomy->sort();
    expect($taxonomy->getSort())->toBeTrue();

    $taxonomy->setSort(false);
    expect($taxonomy->getSort())->toBeFalse();
});

test('can set and get meta box callback', function () {
    $taxonomy = new Taxonomy('test-taxonomy', 'post');

    $callback = function () {
        return true;
    };

    $taxonomy->setMetaBoxCb($callback);
    expect($taxonomy->getMetaBoxCb())->toBe($callback);

    $taxonomy->setMetaBoxCb(false);
    expect($taxonomy->getMetaBoxCb())->toBeFalse();
});

test('can set and get meta box sanitize callback', function () {
    $taxonomy = new Taxonomy('test-taxonomy', 'post');

    $callback = function ($term) {
        return sanitize_text_field($term);
    };

    $taxonomy->setMetaBoxSanitizeCb($callback);
    expect($taxonomy->getMetaBoxSanitizeCb())->toBe($callback);
});

test('can set and get update count callback', function () {
    $taxonomy = new Taxonomy('test-taxonomy', 'post');

    $callback = function ($terms, $taxonomy) {
        return count($terms);
    };

    $taxonomy->setUpdateCountCallback($callback);
    expect($taxonomy->getUpdateCountCallback())->toBe($callback);
});

test('can set and get default term', function () {
    $taxonomy = new Taxonomy('test-taxonomy', 'post');

    // Test with string
    $taxonomy->setDefaultTerm('default-term');
    expect($taxonomy->getDefaultTerm())->toBe('default-term');

    // Test with array
    $defaultTerm = [
        'name' => 'Default Term',
        'slug' => 'default-term',
        'description' => 'This is the default term',
    ];

    $taxonomy->setDefaultTerm($defaultTerm);
    expect($taxonomy->getDefaultTerm())->toBe($defaultTerm);
});

test('can set and get args property', function () {
    $taxonomy = new Taxonomy('test-taxonomy', 'post');

    $args = [
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => false,
    ];

    $taxonomy->setArgs($args);
    expect($taxonomy->getArgs()['args'])->toBe($args);
});

test('can set checked on top property', function () {
    $taxonomy = new Taxonomy('test-taxonomy', 'post');

    $taxonomy->checkedOntop();
    expect($taxonomy->isCheckedOntop())->toBeTrue();

    $taxonomy->setCheckedOntop(false);
    expect($taxonomy->isCheckedOntop())->toBeFalse();
});

test('can set exclusive property', function () {
    $taxonomy = new Taxonomy('test-taxonomy', 'post');

    $taxonomy->exclusive();
    expect($taxonomy->isExclusive())->toBeTrue();

    $taxonomy->setExclusive(false);
    expect($taxonomy->isExclusive())->toBeFalse();
});

test('can set allow hierarchy property', function () {
    $taxonomy = new Taxonomy('test-taxonomy', 'post');

    $taxonomy->allowHierarchy();
    expect($taxonomy->isAllowHierarchy())->toBeTrue();

    $taxonomy->setAllowHierarchy(false);
    expect($taxonomy->isAllowHierarchy())->toBeFalse();
});

test('can build taxonomy arguments correctly', function () {
    $taxonomy = new Taxonomy('test-taxonomy', 'post', 'Test', 'Tests');
    $taxonomy->setLabel('Test Taxonomy');
    $taxonomy->setDescription('A test taxonomy');
    $taxonomy->public();
    $taxonomy->hierarchical();
    $taxonomy->showAdminColumn();
    $taxonomy->showInQuickEdit();
    $taxonomy->showTagcloud();

    $args = $taxonomy->getArgs();

    expect($args)->toBeArray()
        ->and($args)->toHaveKey('label')
        ->and($args['label'])->toBe('Test Taxonomy')
        ->and($args)->toHaveKey('description')
        ->and($args['description'])->toBe('A test taxonomy')
        ->and($args)->toHaveKey('public')
        ->and($args['public'])->toBeTrue()
        ->and($args)->toHaveKey('hierarchical')
        ->and($args['hierarchical'])->toBeTrue()
        ->and($args)->toHaveKey('show_admin_column')
        ->and($args['show_admin_column'])->toBeTrue()
        ->and($args)->toHaveKey('show_in_quick_edit')
        ->and($args['show_in_quick_edit'])->toBeTrue()
        ->and($args)->toHaveKey('show_tagcloud')
        ->and($args['show_tagcloud'])->toBeTrue()
        ->and($args)->toHaveKey('object_type')
        ->and($args['object_type'])->toBe('post');
});
