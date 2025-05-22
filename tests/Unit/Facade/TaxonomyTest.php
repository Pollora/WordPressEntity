<?php

declare(strict_types=1);

use Pollora\Entity\Domain\Model\Taxonomy as TaxonomyDomain;
use Pollora\Entity\Taxonomy;

test('can create taxonomy through facade', function () {
    $taxonomy = Taxonomy::make('test-taxonomy', 'post', 'Test', 'Tests');

    expect($taxonomy)->toBeInstanceOf(TaxonomyDomain::class)
        ->and($taxonomy->getSlug())->toBe('test-taxonomy')
        ->and($taxonomy->getObjectType())->toBe('post');
});

test('can create taxonomy with multiple object types through facade', function () {
    $objectTypes = ['post', 'page', 'custom-post-type'];
    $taxonomy = Taxonomy::make('test-taxonomy', $objectTypes, 'Test', 'Tests');

    expect($taxonomy)->toBeInstanceOf(TaxonomyDomain::class)
        ->and($taxonomy->getObjectType())->toBe($objectTypes);
});
