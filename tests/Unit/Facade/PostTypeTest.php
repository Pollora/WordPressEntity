<?php

declare(strict_types=1);

use Pollora\Entity\Domain\Model\PostType as PostTypeDomain;
use Pollora\Entity\PostType;

test('can create post type through facade', function () {
    $postType = PostType::make('test-post-type', 'Test', 'Tests');

    expect($postType)->toBeInstanceOf(PostTypeDomain::class)
        ->and($postType->getSlug())->toBe('test-post-type');
});
