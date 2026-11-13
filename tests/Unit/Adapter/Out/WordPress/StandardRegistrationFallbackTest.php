<?php

declare(strict_types=1);

use Pollora\Entity\Adapter\Out\WordPress\PostTypeRegistryAdapter;
use Pollora\Entity\Adapter\Out\WordPress\TaxonomyRegistryAdapter;

beforeEach(function () {
    $GLOBALS['entity_test_registrations'] = [];
});

afterEach(function () {
    unset($GLOBALS['entity_test_registrations']);
});

// Expose the protected fallbacks, which the adapters use when Extended CPTs is absent.
function postTypeFallbackAdapter(): PostTypeRegistryAdapter
{
    return new class extends PostTypeRegistryAdapter
    {
        public function fallback(string $slug, array $args, array $names): void
        {
            $this->fallbackToStandardPostTypeRegistration($slug, $args, $names);
        }
    };
}

function taxonomyFallbackAdapter(): TaxonomyRegistryAdapter
{
    return new class extends TaxonomyRegistryAdapter
    {
        public function fallback(string $slug, string|array $objectType, array $args, array $names): void
        {
            $this->fallbackToStandardTaxonomyRegistration($slug, $objectType, $args, $names);
        }
    };
}

it('registers the post type with the given slug and arguments when no names are given', function () {
    postTypeFallbackAdapter()->fallback('book', ['public' => true], []);

    expect($GLOBALS['entity_test_registrations'])->toBe([
        ['register_post_type', 'book', ['public' => true]],
    ]);
});

it('merges singular and plural names into the post type labels', function () {
    postTypeFallbackAdapter()->fallback('book', ['labels' => ['menu_name' => 'Library']], ['singular' => 'Book', 'plural' => 'Books']);

    expect($GLOBALS['entity_test_registrations'])->toBe([
        ['register_post_type', 'book', ['labels' => ['menu_name' => 'Library', 'singular_name' => 'Book', 'name' => 'Books']]],
    ]);
});

it('registers the post type under the slug found in the names', function () {
    postTypeFallbackAdapter()->fallback('book', [], ['slug' => 'novel']);

    expect($GLOBALS['entity_test_registrations'])->toBe([
        ['register_post_type', 'novel', []],
    ]);
});

it('registers the taxonomy with the given slug, object type and arguments when no names are given', function () {
    taxonomyFallbackAdapter()->fallback('genre', ['book', 'film'], ['hierarchical' => true], []);

    expect($GLOBALS['entity_test_registrations'])->toBe([
        ['register_taxonomy', 'genre', ['book', 'film'], ['hierarchical' => true]],
    ]);
});

it('merges singular and plural names into the taxonomy labels', function () {
    taxonomyFallbackAdapter()->fallback('genre', 'book', [], ['singular' => 'Genre', 'plural' => 'Genres']);

    expect($GLOBALS['entity_test_registrations'])->toBe([
        ['register_taxonomy', 'genre', 'book', ['labels' => ['singular_name' => 'Genre', 'name' => 'Genres']]],
    ]);
});

it('registers the taxonomy under the slug found in the names', function () {
    taxonomyFallbackAdapter()->fallback('genre', 'book', [], ['slug' => 'style']);

    expect($GLOBALS['entity_test_registrations'])->toBe([
        ['register_taxonomy', 'style', 'book', []],
    ]);
});

it('does not use the standard functions when Extended CPTs is available', function () {
    (new PostTypeRegistryAdapter)->registerPostType('book', ['public' => true], ['singular' => 'Book', 'plural' => 'Books']);
    (new TaxonomyRegistryAdapter)->registerTaxonomy('genre', 'book', [], ['singular' => 'Genre', 'plural' => 'Genres']);

    expect($GLOBALS['entity_test_registrations'])->toBe([]);
});

it('forwards register() to the taxonomy registration only when an object_type is present', function () {
    $adapter = new class extends TaxonomyRegistryAdapter
    {
        public array $calls = [];

        public function registerTaxonomy(string $slug, string|array $objectType, array $args, array $names): void
        {
            $this->calls[] = [$slug, $objectType, $args, $names];
        }
    };

    $adapter->register('genre', ['public' => true], []);
    expect($adapter->calls)->toBe([]);

    $adapter->register('genre', ['object_type' => ['book'], 'public' => true], ['singular' => 'Genre']);
    expect($adapter->calls)->toBe([['genre', ['book'], ['object_type' => ['book'], 'public' => true], ['singular' => 'Genre']]]);
});

it('forwards register() to registerPostType', function () {
    $adapter = new class extends PostTypeRegistryAdapter
    {
        public array $calls = [];

        public function registerPostType(string $slug, array $args, array $names): void
        {
            $this->calls[] = [$slug, $args, $names];
        }
    };

    $adapter->register('book', ['public' => true], ['singular' => 'Book']);

    expect($adapter->calls)->toBe([['book', ['public' => true], ['singular' => 'Book']]]);
});
