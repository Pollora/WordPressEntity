<?php

declare(strict_types=1);

use Pollora\Entity\Domain\Model\PostType;

/*
 * PostType accessors. Each row: setter, its arguments, getter, expected value.
 */
dataset('post type accessors', [
    'excludeFromSearch' => ['excludeFromSearch', [], 'getExcludeFromSearch', true],
    'includeInSearch' => ['includeInSearch', [], 'getExcludeFromSearch', false],
    'withExcludeFromSearch' => ['withExcludeFromSearch', [true], 'getExcludeFromSearch', true],
    'withExcludeFromSearch null' => ['withExcludeFromSearch', [null], 'getExcludeFromSearch', null],
    'setExcludeFromSearch' => ['setExcludeFromSearch', [false], 'getExcludeFromSearch', false],
    'chronological' => ['chronological', [], 'isHierarchical', false],
    'hierarchical' => ['hierarchical', [], 'isHierarchical', true],
    'nonHierarchical' => ['nonHierarchical', [], 'isHierarchical', false],
    'withHierarchical' => ['withHierarchical', [true], 'isHierarchical', true],
    'setHierarchical' => ['setHierarchical', [false], 'isHierarchical', false],
    'showInAdminBar' => ['showInAdminBar', [], 'getShowInAdminBar', true],
    'hideFromAdminBar' => ['hideFromAdminBar', [], 'getShowInAdminBar', false],
    'withShowInAdminBar' => ['withShowInAdminBar', [true], 'getShowInAdminBar', true],
    'setShowInAdminBar null' => ['setShowInAdminBar', [null], 'getShowInAdminBar', null],
    'menuPosition' => ['menuPosition', [20], 'getMenuPosition', 20],
    'menuPosition null' => ['menuPosition', [null], 'getMenuPosition', null],
    'setMenuPosition' => ['setMenuPosition', [30], 'getMenuPosition', 30],
    'menuIcon' => ['menuIcon', ['dashicons-book'], 'getMenuIcon', 'dashicons-book'],
    'setMenuIcon' => ['setMenuIcon', ['dashicons-star'], 'getMenuIcon', 'dashicons-star'],
    'capabilityType' => ['capabilityType', ['page'], 'getCapabilityType', 'page'],
    'setCapabilityType' => ['setCapabilityType', ['post'], 'getCapabilityType', 'post'],
    'mapMetaCap' => ['mapMetaCap', [], 'isMapMetaCap', true],
    'withoutMetaCap' => ['withoutMetaCap', [], 'isMapMetaCap', false],
    'withMapMetaCap' => ['withMapMetaCap', [true], 'isMapMetaCap', true],
    'setMapMetaCap' => ['setMapMetaCap', [false], 'isMapMetaCap', false],
    'taxonomies' => ['taxonomies', [['genre']], 'getTaxonomies', ['genre']],
    'hasArchive default' => ['hasArchive', [], 'getHasArchive', true],
    'hasArchive string' => ['hasArchive', ['books'], 'getHasArchive', 'books'],
    'canExport' => ['canExport', [], 'getCanExport', true],
    'cannotExport' => ['cannotExport', [], 'getCanExport', false],
    'withCanExport' => ['withCanExport', [true], 'getCanExport', true],
    'setCanExport' => ['setCanExport', [false], 'getCanExport', false],
    'deleteWithUser' => ['deleteWithUser', [], 'getDeleteWithUser', true],
    'deletedWithUser' => ['deletedWithUser', [], 'getDeleteWithUser', true],
    'keepOnUserDelete' => ['keepOnUserDelete', [], 'getDeleteWithUser', false],
    'withDeleteWithUser' => ['withDeleteWithUser', [true], 'getDeleteWithUser', true],
    'setDeleteWithUser null' => ['setDeleteWithUser', [null], 'getDeleteWithUser', null],
    'template' => ['template', [[['core/paragraph']]], 'getTemplate', [['core/paragraph']]],
    'setTemplate' => ['setTemplate', [[['core/heading']]], 'getTemplate', [['core/heading']]],
    'templateLock' => ['templateLock', ['all'], 'getTemplateLock', 'all'],
    'setTemplateLock' => ['setTemplateLock', [false], 'getTemplateLock', false],
    'supports bool' => ['supports', [false], 'getSupports', false],
    'setSupports' => ['setSupports', [['title']], 'getSupports', ['title']],
    'adminFilters' => ['adminFilters', [['genre' => ['taxonomy' => 'genre']]], 'getAdminFilters', ['genre' => ['taxonomy' => 'genre']]],
    'archive' => ['archive', [['nopaging' => true]], 'getArchive', ['nopaging' => true]],
    'setArchive' => ['setArchive', [['nopaging' => false]], 'getArchive', ['nopaging' => false]],
    'blockEditor' => ['blockEditor', [], 'isBlockEditor', true],
    'enableBlockEditor' => ['enableBlockEditor', [], 'isBlockEditor', true],
    'classicEditor' => ['classicEditor', [], 'isBlockEditor', false],
    'withBlockEditor' => ['withBlockEditor', [true], 'isBlockEditor', true],
    'setBlockEditor' => ['setBlockEditor', [false], 'isBlockEditor', false],
    'dashboardActivity' => ['dashboardActivity', [], 'isDashboardActivity', true],
    'withoutDashboardActivity' => ['withoutDashboardActivity', [], 'isDashboardActivity', false],
    'withDashboardActivity' => ['withDashboardActivity', [true], 'isDashboardActivity', true],
    'titlePlaceholder' => ['titlePlaceholder', ['Title...'], 'getEnterTitleHere', 'Title...'],
    'featuredImage' => ['featuredImage', ['Cover'], 'getFeaturedImage', 'Cover'],
    'setFeaturedImage' => ['setFeaturedImage', ['Photo'], 'getFeaturedImage', 'Photo'],
    'quickEdit' => ['quickEdit', [], 'isQuickEdit', true],
    'enableQuickEdit' => ['enableQuickEdit', [], 'isQuickEdit', true],
    'withoutQuickEdit' => ['withoutQuickEdit', [], 'isQuickEdit', false],
    'withQuickEdit' => ['withQuickEdit', [true], 'isQuickEdit', true],
    'setQuickEdit' => ['setQuickEdit', [false], 'isQuickEdit', false],
    'showInFeed' => ['showInFeed', [], 'isShowInFeed', true],
    'hideFromFeed' => ['hideFromFeed', [], 'isShowInFeed', false],
    'withShowInFeed' => ['withShowInFeed', [true], 'isShowInFeed', true],
    'setShowInFeed' => ['setShowInFeed', [false], 'isShowInFeed', false],
    'siteFilters' => ['siteFilters', [['genre' => []]], 'getSiteFilters', ['genre' => []]],
    'siteSortables' => ['siteSortables', [['title' => []]], 'getSiteSortables', ['title' => []]],
]);

it('stores the value through the accessor and stays chainable', function (string $setter, array $arguments, string $getter, mixed $expected) {
    $postType = new PostType('book');

    $result = $postType->{$setter}(...$arguments);

    expect($result)->toBe($postType)
        ->and($postType->{$getter}())->toBe($expected);
})->with('post type accessors');

it('keeps the callback given to registerMetaBoxCb and setRegisterMetaBoxCb', function () {
    $postType = new PostType('book');
    $first = fn () => 'first';
    $second = fn () => 'second';

    expect($postType->registerMetaBoxCb($first)->getRegisterMetaBoxCb())->toBe($first)
        ->and($postType->setRegisterMetaBoxCb($second)->getRegisterMetaBoxCb())->toBe($second)
        ->and($postType->registerMetaBoxCb(null)->getRegisterMetaBoxCb())->toBeNull();
});

it('keeps the REST controller given to restController and setRestController', function () {
    $postType = new PostType('book');
    $first = Mockery::mock('WP_REST_Controller');
    $second = Mockery::mock('WP_REST_Controller');

    expect($postType->getRestController())->toBeNull()
        ->and($postType->restController($first)->getRestController())->toBe($first)
        ->and($postType->setRestController($second)->getRestController())->toBe($second);
});

it('shares showInRest between the block editor switch and the REST flag', function () {
    $postType = (new PostType('book'))->classicEditor();

    expect($postType->getShowInRest())->toBeFalse();

    $postType->blockEditor();
    expect($postType->getShowInRest())->toBeTrue();
});
