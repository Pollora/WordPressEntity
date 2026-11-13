<?php

declare(strict_types=1);

use Pollora\Entity\Domain\Model\Taxonomy;

/*
 * Taxonomy accessors. Each row: setter, its arguments, getter, expected value.
 */
dataset('taxonomy accessors', [
    'showTagcloud' => ['showTagcloud', [], 'isShowTagcloud', true],
    'hideFromTagcloud' => ['hideFromTagcloud', [], 'isShowTagcloud', false],
    'withShowTagcloud' => ['withShowTagcloud', [true], 'isShowTagcloud', true],
    'setShowTagcloud' => ['setShowTagcloud', [false], 'isShowTagcloud', false],
    'showInQuickEdit' => ['showInQuickEdit', [], 'isShowInQuickEdit', true],
    'hideFromQuickEdit' => ['hideFromQuickEdit', [], 'isShowInQuickEdit', false],
    'withShowInQuickEdit' => ['withShowInQuickEdit', [true], 'isShowInQuickEdit', true],
    'setShowInQuickEdit' => ['setShowInQuickEdit', [false], 'isShowInQuickEdit', false],
    'showAdminColumn' => ['showAdminColumn', [], 'isShowAdminColumn', true],
    'hideAdminColumn' => ['hideAdminColumn', [], 'isShowAdminColumn', false],
    'withShowAdminColumn' => ['withShowAdminColumn', [true], 'isShowAdminColumn', true],
    'setShowAdminColumn' => ['setShowAdminColumn', [false], 'isShowAdminColumn', false],
    'metaBoxCb false' => ['metaBoxCb', [false], 'getMetaBoxCb', false],
    'metaBoxCb null' => ['metaBoxCb', [null], 'getMetaBoxCb', null],
    'defaultTerm string' => ['defaultTerm', ['uncategorized'], 'getDefaultTerm', 'uncategorized'],
    'defaultTerm array' => ['defaultTerm', [['name' => 'Misc']], 'getDefaultTerm', ['name' => 'Misc']],
    'setDefaultTerm' => ['setDefaultTerm', ['misc'], 'getDefaultTerm', 'misc'],
    'sort' => ['sort', [], 'getSort', true],
    'unsort' => ['unsort', [], 'getSort', false],
    'withSort' => ['withSort', [true], 'getSort', true],
    'withSort null' => ['withSort', [null], 'getSort', null],
    'setSort' => ['setSort', [false], 'getSort', false],
    'checkedOntop' => ['checkedOntop', [], 'isCheckedOntop', true],
    'uncheckedOntop' => ['uncheckedOntop', [], 'isCheckedOntop', false],
    'withCheckedOntop' => ['withCheckedOntop', [true], 'isCheckedOntop', true],
    'setCheckedOntop' => ['setCheckedOntop', [false], 'isCheckedOntop', false],
    'exclusive' => ['exclusive', [], 'isExclusive', true],
    'nonExclusive' => ['nonExclusive', [], 'isExclusive', false],
    'withExclusive' => ['withExclusive', [true], 'isExclusive', true],
    'setExclusive' => ['setExclusive', [false], 'isExclusive', false],
    'allowHierarchy' => ['allowHierarchy', [], 'isAllowHierarchy', true],
    'disallowHierarchy' => ['disallowHierarchy', [], 'isAllowHierarchy', false],
    'withAllowHierarchy' => ['withAllowHierarchy', [true], 'isAllowHierarchy', true],
    'setAllowHierarchy' => ['setAllowHierarchy', [false], 'isAllowHierarchy', false],
]);

it('stores the value through the accessor and stays chainable', function (string $setter, array $arguments, string $getter, mixed $expected) {
    $taxonomy = new Taxonomy('genre', 'post');

    $result = $taxonomy->{$setter}(...$arguments);

    expect($result)->toBe($taxonomy)
        ->and($taxonomy->{$getter}())->toBe($expected);
})->with('taxonomy accessors');

it('keeps the callbacks given to the meta box, sanitize and count accessors', function () {
    $taxonomy = new Taxonomy('genre', 'post');
    $metaBox = fn () => 'box';
    $sanitize = fn () => 'sanitize';
    $count = fn () => 'count';

    expect($taxonomy->metaBoxCb($metaBox)->getMetaBoxCb())->toBe($metaBox)
        ->and($taxonomy->metaBoxSanitizeCb($sanitize)->getMetaBoxSanitizeCb())->toBe($sanitize)
        ->and($taxonomy->metaBoxSanitizeCb(null)->getMetaBoxSanitizeCb())->toBeNull()
        ->and($taxonomy->updateCountCallback($count)->getUpdateCountCallback())->toBe($count);
});

it('keeps the extra args given to args and setArgs, and clears them with null', function () {
    $taxonomy = new Taxonomy('genre', 'post');

    expect($taxonomy->args(['orderby' => 'term_order'])->args)->toBe(['orderby' => 'term_order'])
        ->and($taxonomy->setArgs(['orderby' => 'name'])->args)->toBe(['orderby' => 'name'])
        ->and($taxonomy->setArgs(null)->args)->toBeNull();
});
