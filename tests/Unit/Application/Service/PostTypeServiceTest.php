<?php

declare(strict_types=1);

use Mockery\MockInterface;
use Pollora\Entity\Application\Service\EntityRegistrationService;
use Pollora\Entity\Application\Service\PostTypeService;
use Pollora\Entity\Domain\Model\PostType;
use Pollora\Entity\Port\Out\PostTypeRegistryPort;

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

test('can create post type service', function () {
    /** @var PostTypeRegistryPort&MockInterface $postTypeRegistry */
    $postTypeRegistry = Mockery::mock(PostTypeRegistryPort::class);
    /** @var EntityRegistrationService&MockInterface $registrationService */
    $registrationService = Mockery::mock(EntityRegistrationService::class);

    $service = new PostTypeService($postTypeRegistry, $registrationService);

    expect($service)->toBeInstanceOf(PostTypeService::class);
});

test('can create and register post type', function () {
    /** @var PostTypeRegistryPort&MockInterface $postTypeRegistry */
    $postTypeRegistry = Mockery::mock(PostTypeRegistryPort::class);
    /** @var EntityRegistrationService&MockInterface $registrationService */
    $registrationService = Mockery::mock(EntityRegistrationService::class);
    $registrationService->shouldReceive('registerEntity')->once();

    $service = new PostTypeService($postTypeRegistry, $registrationService);

    $postType = $service->createPostType('test-post-type', 'Test', 'Tests');

    expect($postType)->toBeInstanceOf(PostType::class)
        ->and($postType->getSlug())->toBe('test-post-type');
});

test('can register existing post type', function () {
    /** @var PostTypeRegistryPort&MockInterface $postTypeRegistry */
    $postTypeRegistry = Mockery::mock(PostTypeRegistryPort::class);
    /** @var EntityRegistrationService&MockInterface $registrationService */
    $registrationService = Mockery::mock(EntityRegistrationService::class);
    $registrationService->shouldReceive('registerEntity')->once();

    $service = new PostTypeService($postTypeRegistry, $registrationService);

    $postType = new PostType('test-post-type', 'Test', 'Tests');
    $service->register($postType);

    // Verification is handled by the mock expectation
});
