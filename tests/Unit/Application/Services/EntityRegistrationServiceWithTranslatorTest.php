<?php

declare(strict_types=1);

namespace Pollora\Entity\Tests\Unit\Application\Services;

use Mockery;
use Pollora\Entity\Application\Services\EntityRegistrationService;
use Pollora\Entity\Domain\Contracts\EntityRegistrarInterface;
use Pollora\Entity\Domain\Models\PostType;
use Pollora\Entity\Domain\Models\Taxonomy;
use Pollora\Entity\Tests\Stubs\MockArgumentTranslator;

beforeEach(function () {
    $this->postTypeRegistrar = Mockery::mock(EntityRegistrarInterface::class);
    $this->taxonomyRegistrar = Mockery::mock(EntityRegistrarInterface::class);
    $this->translator = new MockArgumentTranslator;

    $this->service = new EntityRegistrationService(
        $this->postTypeRegistrar,
        $this->taxonomyRegistrar,
        $this->translator
    );
});

afterEach(function () {
    Mockery::close();
});

it('registers a post type with translated arguments', function () {
    $postType = new PostType('book', 'Book', 'Books');
    $postType->setLabel('Books');

    $this->postTypeRegistrar->shouldReceive('register')
        ->once()
        ->with(Mockery::type(PostType::class))
        ->andReturnUsing(function ($arg) {
            expect($arg->getLabel())->toBe('[post-types] Books');
            expect($arg->getSingular())->toBe('[post-types] Book');
            expect($arg->getPlural())->toBe('[post-types] Books');

            return true;
        });

    $result = $this->service->registerPostType($postType);

    expect($result)->toBeTrue();

    // Original post type should remain unchanged
    expect($postType->getLabel())->toBe('Books');
    expect($postType->getSingular())->toBe('Book');
    expect($postType->getPlural())->toBe('Books');
});

it('registers a taxonomy with translated arguments', function () {
    $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');
    $taxonomy->setLabel('Genres');

    $this->taxonomyRegistrar->shouldReceive('register')
        ->once()
        ->with(Mockery::type(Taxonomy::class))
        ->andReturnUsing(function ($arg) {
            expect($arg->getLabel())->toBe('[taxonomies] Genres');
            expect($arg->getSingular())->toBe('[taxonomies] Genre');
            expect($arg->getPlural())->toBe('[taxonomies] Genres');

            return true;
        });

    $result = $this->service->registerTaxonomy($taxonomy);

    expect($result)->toBeTrue();

    // Original taxonomy should remain unchanged
    expect($taxonomy->getLabel())->toBe('Genres');
    expect($taxonomy->getSingular())->toBe('Genre');
    expect($taxonomy->getPlural())->toBe('Genres');
});

it('handles registration failure gracefully', function () {
    $postType = new PostType('book', 'Book', 'Books');

    $this->postTypeRegistrar->shouldReceive('register')
        ->once()
        ->with(Mockery::type(PostType::class))
        ->andReturn(false);

    $result = $this->service->registerPostType($postType);

    expect($result)->toBeFalse();
});
