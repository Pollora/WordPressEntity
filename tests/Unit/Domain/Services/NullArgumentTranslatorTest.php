<?php

declare(strict_types=1);

namespace Pollora\Entity\Tests\Unit\Domain\Services;

use Pollora\Entity\Infrastructure\Services\NullArgumentTranslator;

it('returns arguments unchanged', function () {
    $translator = new NullArgumentTranslator;

    $args = [
        'label' => 'Books',
        'labels' => [
            'name' => 'Books',
            'singular_name' => 'Book',
            'add_new' => 'Add New',
        ],
        'names' => [
            'singular' => 'Book',
            'plural' => 'Books',
        ],
        'public' => true,
    ];

    $result = $translator->translate($args, 'post-types');

    expect($result)->toBe($args);
});

it('works with custom keys to translate', function () {
    $translator = new NullArgumentTranslator;

    $args = [
        'label' => 'Books',
        'custom_field' => 'Custom Value',
    ];

    $keysToTranslate = ['label', 'custom_field'];

    $result = $translator->translate($args, 'post-types', $keysToTranslate);

    expect($result)->toBe($args);
});

it('handles empty arrays', function () {
    $translator = new NullArgumentTranslator;

    $args = [];

    $result = $translator->translate($args, 'taxonomies');

    expect($result)->toBe([]);
});

it('preserves non-string values', function () {
    $translator = new NullArgumentTranslator;

    $args = [
        'label' => 'Books',
        'public' => true,
        'count' => 5,
        'options' => ['one', 'two', 'three'],
    ];

    $result = $translator->translate($args, 'post-types');

    expect($result)->toBe($args);
    expect($result['public'])->toBeTrue();
    expect($result['count'])->toBe(5);
    expect($result['options'])->toBe(['one', 'two', 'three']);
});
