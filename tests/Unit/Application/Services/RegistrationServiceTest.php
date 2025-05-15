<?php

declare(strict_types=1);

namespace Pollora\Entity\Tests\Unit\Application\Services;

use Mockery;
use Pollora\Entity\Application\Services\EntityRegistrationService;
use Pollora\Entity\Domain\Contracts\EntityRegistrarInterface;
use Pollora\Entity\Domain\Models\PostType;
use Pollora\Entity\Domain\Models\Taxonomy;

beforeEach(function () {
    $this->postTypeRegistrar = Mockery::mock(EntityRegistrarInterface::class);
    $this->taxonomyRegistrar = Mockery::mock(EntityRegistrarInterface::class);
    $this->service = new EntityRegistrationService(
        $this->postTypeRegistrar,
        $this->taxonomyRegistrar
    );
});

afterEach(function () {
    Mockery::close();
});

it('registers a post type', function () {
    $postType = new PostType('book', 'Book', 'Books');

    $this->postTypeRegistrar->shouldReceive('register')
        ->once()
        ->with($postType)
        ->andReturn(true);

    $result = $this->service->registerPostType($postType);

    expect($result)->toBeTrue();
});

it('checks if a post type exists', function () {
    $this->postTypeRegistrar->shouldReceive('exists')
        ->once()
        ->with('book')
        ->andReturn(true);

    $result = $this->service->postTypeExists('book');

    expect($result)->toBeTrue();
});

it('unregisters a post type', function () {
    $this->postTypeRegistrar->shouldReceive('unregister')
        ->once()
        ->with('book')
        ->andReturn(true);

    $result = $this->service->unregisterPostType('book');

    expect($result)->toBeTrue();
});

it('registers a taxonomy', function () {
    $taxonomy = new Taxonomy('genre', 'book', 'Genre', 'Genres');

    $this->taxonomyRegistrar->shouldReceive('register')
        ->once()
        ->with($taxonomy)
        ->andReturn(true);

    $result = $this->service->registerTaxonomy($taxonomy);

    expect($result)->toBeTrue();
});

it('checks if a taxonomy exists', function () {
    $this->taxonomyRegistrar->shouldReceive('exists')
        ->once()
        ->with('genre')
        ->andReturn(true);

    $result = $this->service->taxonomyExists('genre');

    expect($result)->toBeTrue();
});

it('unregisters a taxonomy', function () {
    $this->taxonomyRegistrar->shouldReceive('unregister')
        ->once()
        ->with('genre')
        ->andReturn(true);

    $result = $this->service->unregisterTaxonomy('genre');

    expect($result)->toBeTrue();
});
