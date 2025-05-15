<?php

declare(strict_types=1);

namespace Pollora\Entity\Tests\Unit\Application\Services;

use Pollora\Entity\Application\Services\EntityFactoryService;
use Pollora\Entity\Domain\Models\PostType;
use Pollora\Entity\Domain\Models\Taxonomy;

it('creates a post type through the factory', function () {
    $factory = new EntityFactoryService;

    $postType = $factory->createPostType('book', 'Book', 'Books');

    expect($postType)->toBeInstanceOf(PostType::class)
        ->and($postType->getSlug())->toBe('book')
        ->and($postType->getSingular())->toBe('Book')
        ->and($postType->getPlural())->toBe('Books');
});

it('creates a taxonomy through the factory', function () {
    $factory = new EntityFactoryService;

    $taxonomy = $factory->createTaxonomy('genre', 'book', 'Genre', 'Genres');

    expect($taxonomy)->toBeInstanceOf(Taxonomy::class)
        ->and($taxonomy->getSlug())->toBe('genre')
        ->and($taxonomy->getObjectType())->toBe('book')
        ->and($taxonomy->getSingular())->toBe('Genre')
        ->and($taxonomy->getPlural())->toBe('Genres');
});
