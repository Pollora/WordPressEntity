<?php

declare(strict_types=1);

use Mockery\MockInterface;
use Pollora\Entity\Application\Service\EntityRegistrationService;
use Pollora\Entity\Application\Service\TaxonomyService;
use Pollora\Entity\Domain\Model\Taxonomy;
use Pollora\Entity\Port\Out\TaxonomyRegistryPort;

// Simulate required WordPress functions
if (! function_exists('did_action')) {
    function did_action($hook)
    {
        return true; // Simulate that the action has already been triggered
    }
}

if (! function_exists('add_action')) {
    function add_action($hook, $callback, $priority = 10)
    {
        // Execute the callback immediately for tests
        if ($hook === 'init') {
            $callback();
        }
    }
}

test('can create taxonomy service', function () {
    /** @var TaxonomyRegistryPort&MockInterface $taxonomyRegistry */
    $taxonomyRegistry = Mockery::mock(TaxonomyRegistryPort::class);
    /** @var EntityRegistrationService&MockInterface $registrationService */
    $registrationService = Mockery::mock(EntityRegistrationService::class);

    $service = new TaxonomyService($taxonomyRegistry, $registrationService);

    expect($service)->toBeInstanceOf(TaxonomyService::class);
});

test('can create and register taxonomy', function () {
    /** @var TaxonomyRegistryPort&MockInterface $taxonomyRegistry */
    $taxonomyRegistry = Mockery::mock(TaxonomyRegistryPort::class);
    /** @var EntityRegistrationService&MockInterface $registrationService */
    $registrationService = Mockery::mock(EntityRegistrationService::class);
    $registrationService->shouldReceive('registerEntity')->once();

    $service = new TaxonomyService($taxonomyRegistry, $registrationService);

    $taxonomy = $service->createTaxonomy('test-taxonomy', 'post', 'Test', 'Tests');

    expect($taxonomy)->toBeInstanceOf(Taxonomy::class)
        ->and($taxonomy->getSlug())->toBe('test-taxonomy')
        ->and($taxonomy->getObjectType())->toBe('post');
});

test('can register existing taxonomy', function () {
    /** @var TaxonomyRegistryPort&MockInterface $taxonomyRegistry */
    $taxonomyRegistry = Mockery::mock(TaxonomyRegistryPort::class);
    /** @var EntityRegistrationService&MockInterface $registrationService */
    $registrationService = Mockery::mock(EntityRegistrationService::class);
    $registrationService->shouldReceive('registerEntity')->once();

    $service = new TaxonomyService($taxonomyRegistry, $registrationService);

    $taxonomy = new Taxonomy('test-taxonomy', 'post', 'Test', 'Tests');
    $service->register($taxonomy);

    // Verification is handled by the mock expectation
});

test('can create taxonomy with multiple object types', function () {
    /** @var TaxonomyRegistryPort&MockInterface $taxonomyRegistry */
    $taxonomyRegistry = Mockery::mock(TaxonomyRegistryPort::class);
    /** @var EntityRegistrationService&MockInterface $registrationService */
    $registrationService = Mockery::mock(EntityRegistrationService::class);
    $registrationService->shouldReceive('registerEntity')->once();

    $service = new TaxonomyService($taxonomyRegistry, $registrationService);

    $objectTypes = ['post', 'page', 'custom-post-type'];
    $taxonomy = $service->createTaxonomy('test-taxonomy', $objectTypes, 'Test', 'Tests');

    expect($taxonomy)->toBeInstanceOf(Taxonomy::class)
        ->and($taxonomy->getObjectType())->toBe($objectTypes);
});
