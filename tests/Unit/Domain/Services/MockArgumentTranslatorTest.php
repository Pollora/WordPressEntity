<?php

declare(strict_types=1);

namespace Pollora\Entity\Tests\Unit\Domain\Services;

use Pollora\Entity\Tests\Stubs\MockArgumentTranslator;

it('translates simple string fields', function () {
    $translator = new MockArgumentTranslator;

    $args = [
        'label' => 'Books',
        'description' => 'Collection of books',
    ];

    $result = $translator->translate($args, 'post-types');

    expect($result['label'])->toBe('[post-types] Books');
    expect($result['description'])->toBe('Collection of books'); // Not in default keys to translate
});

it('translates nested arrays with wildcard', function () {
    $translator = new MockArgumentTranslator;

    $args = [
        'labels' => [
            'name' => 'Books',
            'singular_name' => 'Book',
            'add_new' => 'Add New',
        ],
    ];

    $result = $translator->translate($args, 'post-types');

    expect($result['labels']['name'])->toBe('[post-types] Books');
    expect($result['labels']['singular_name'])->toBe('[post-types] Book');
    expect($result['labels']['add_new'])->toBe('[post-types] Add New');
});

it('translates nested keys', function () {
    $translator = new MockArgumentTranslator;

    $args = [
        'names' => [
            'singular' => 'Book',
            'plural' => 'Books',
            'slug' => 'book', // Not in default keys to translate
        ],
    ];

    $result = $translator->translate($args, 'post-types');

    expect($result['names']['singular'])->toBe('[post-types] Book');
    expect($result['names']['plural'])->toBe('[post-types] Books');
    expect($result['names']['slug'])->toBe('book'); // Should be unchanged
});

it('respects custom keys to translate', function () {
    $translator = new MockArgumentTranslator;

    $args = [
        'label' => 'Books',
        'description' => 'Collection of books',
        'custom_field' => 'Custom Value',
    ];

    $keysToTranslate = ['label', 'description', 'custom_field'];

    $result = $translator->translate($args, 'post-types', $keysToTranslate);

    expect($result['label'])->toBe('[post-types] Books');
    expect($result['description'])->toBe('[post-types] Collection of books'); // Now translated
    expect($result['custom_field'])->toBe('[post-types] Custom Value'); // Now translated
});

it('preserves non-string values', function () {
    $translator = new MockArgumentTranslator;

    $args = [
        'label' => 'Books',
        'public' => true,
        'count' => 5,
        'options' => ['one', 'two', 'three'],
    ];

    $result = $translator->translate($args, 'post-types');

    expect($result['label'])->toBe('[post-types] Books');
    expect($result['public'])->toBeTrue();
    expect($result['count'])->toBe(5);
    expect($result['options'])->toBe(['one', 'two', 'three']);
});
