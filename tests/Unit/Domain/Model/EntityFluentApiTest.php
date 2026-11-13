<?php

declare(strict_types=1);

use Pollora\Entity\Domain\Model\Taxonomy;

/*
 * Entity-level accessors, exercised on a Taxonomy because it inherits them
 * unchanged (PostType overrides the hierarchical group, tested separately).
 * Each row: setter, its arguments, getter, value the getter must return.
 */
dataset('entity accessors', [
    'priority' => ['priority', [9], 'getPriority', 9],
    'label' => ['label', ['Genres'], 'getLabel', 'Genres'],
    'setLabel' => ['setLabel', ['Genres'], 'getLabel', 'Genres'],
    'labels' => ['labels', [['name' => 'Genres']], 'getLabels', ['name' => 'Genres']],
    'setLabels' => ['setLabels', [['name' => 'Genres']], 'getLabels', ['name' => 'Genres']],
    'description' => ['description', ['About'], 'getDescription', 'About'],
    'setDescription' => ['setDescription', ['About'], 'getDescription', 'About'],
    'public' => ['public', [], 'isPublic', true],
    'private' => ['private', [], 'isPublic', false],
    'withPublic' => ['withPublic', [true], 'isPublic', true],
    'setPublic' => ['setPublic', [false], 'isPublic', false],
    'publiclyQueryable' => ['publiclyQueryable', [], 'getPubliclyQueryable', true],
    'notPubliclyQueryable' => ['notPubliclyQueryable', [], 'getPubliclyQueryable', false],
    'withPubliclyQueryable' => ['withPubliclyQueryable', [true], 'getPubliclyQueryable', true],
    'withPubliclyQueryable null' => ['withPubliclyQueryable', [null], 'getPubliclyQueryable', null],
    'setPubliclyQueryable' => ['setPubliclyQueryable', [false], 'getPubliclyQueryable', false],
    'hierarchical' => ['hierarchical', [], 'isHierarchical', true],
    'nonHierarchical' => ['nonHierarchical', [], 'isHierarchical', false],
    'withHierarchical' => ['withHierarchical', [true], 'isHierarchical', true],
    'setHierarchical' => ['setHierarchical', [false], 'isHierarchical', false],
    'showUi' => ['showUi', [], 'getShowUi', true],
    'hideUi' => ['hideUi', [], 'getShowUi', false],
    'withShowUi' => ['withShowUi', [true], 'getShowUi', true],
    'withShowUi null' => ['withShowUi', [null], 'getShowUi', null],
    'setShowUi' => ['setShowUi', [false], 'getShowUi', false],
    'showInMenu' => ['showInMenu', [], 'isShowInMenu', true],
    'hideFromMenu' => ['hideFromMenu', [], 'isShowInMenu', false],
    'withShowInMenu string' => ['withShowInMenu', ['tools.php'], 'isShowInMenu', 'tools.php'],
    'setShowInMenu' => ['setShowInMenu', [false], 'isShowInMenu', false],
    'showInNavMenus' => ['showInNavMenus', [], 'getShowInNavMenus', true],
    'hideFromNavMenus' => ['hideFromNavMenus', [], 'getShowInNavMenus', false],
    'withShowInNavMenus' => ['withShowInNavMenus', [true], 'getShowInNavMenus', true],
    'setShowInNavMenus' => ['setShowInNavMenus', [null], 'getShowInNavMenus', null],
    'queryVar' => ['queryVar', ['genre'], 'getQueryVar', 'genre'],
    'withQueryVar' => ['withQueryVar', [false], 'getQueryVar', false],
    'setQueryVar' => ['setQueryVar', ['g'], 'getQueryVar', 'g'],
    'rewrite' => ['rewrite', [['slug' => 'g']], 'getRewrite', ['slug' => 'g']],
    'withRewrite' => ['withRewrite', [false], 'getRewrite', false],
    'setRewrite' => ['setRewrite', [['slug' => 'x']], 'getRewrite', ['slug' => 'x']],
    'showInRest' => ['showInRest', [], 'getShowInRest', true],
    'hideFromRest' => ['hideFromRest', [], 'getShowInRest', false],
    'withShowInRest' => ['withShowInRest', [true], 'getShowInRest', true],
    'setShowInRest' => ['setShowInRest', [false], 'getShowInRest', false],
    'restBase' => ['restBase', ['genres'], 'getRestBase', 'genres'],
    'withRestBase' => ['withRestBase', ['genres'], 'getRestBase', 'genres'],
    'setRestBase' => ['setRestBase', ['g'], 'getRestBase', 'g'],
    'restNamespace' => ['restNamespace', ['app/v1'], 'getRestNamespace', 'app/v1'],
    'withRestNamespace' => ['withRestNamespace', ['app/v2'], 'getRestNamespace', 'app/v2'],
    'setRestNamespace' => ['setRestNamespace', ['app/v3'], 'getRestNamespace', 'app/v3'],
    'restControllerClass' => ['restControllerClass', ['A\\B'], 'getRestControllerClass', 'A\\B'],
    'withRestControllerClass' => ['withRestControllerClass', ['A\\C'], 'getRestControllerClass', 'A\\C'],
    'setRestControllerClass' => ['setRestControllerClass', ['A\\D'], 'getRestControllerClass', 'A\\D'],
    'capabilities' => ['capabilities', [['edit_terms' => 'x']], 'getCapabilities', ['edit_terms' => 'x']],
    'withCapabilities' => ['withCapabilities', [['edit_terms' => 'y']], 'getCapabilities', ['edit_terms' => 'y']],
    'setCapabilities' => ['setCapabilities', [['edit_terms' => 'z']], 'getCapabilities', ['edit_terms' => 'z']],
    'enableDashboardGlance' => ['enableDashboardGlance', [], 'isDashboardGlance', true],
    'disableDashboardGlance' => ['disableDashboardGlance', [], 'isDashboardGlance', false],
    'withDashboardGlance' => ['withDashboardGlance', [true], 'isDashboardGlance', true],
    'setDashboardGlance' => ['setDashboardGlance', [false], 'isDashboardGlance', false],
    'adminCols' => ['adminCols', [['title' => []]], 'getAdminCols', ['title' => []]],
    'withAdminCols' => ['withAdminCols', [['date' => []]], 'getAdminCols', ['date' => []]],
    'setAdminCols' => ['setAdminCols', [['author' => []]], 'getAdminCols', ['author' => []]],
]);

it('stores the value through the accessor and stays chainable', function (string $setter, array $arguments, string $getter, mixed $expected) {
    $taxonomy = new Taxonomy('genre', 'post');

    $result = $taxonomy->{$setter}(...$arguments);

    expect($result)->toBe($taxonomy)
        ->and($taxonomy->{$getter}())->toBe($expected);
})->with('entity accessors');

it('leaves the accessors unset until a value is given', function () {
    $taxonomy = new Taxonomy('genre', 'post');

    expect($taxonomy->getLabel())->toBeNull()
        ->and($taxonomy->getPriority())->toBe(5)
        ->and($taxonomy->isPublic())->toBeNull()
        ->and($taxonomy->getRewrite())->toBeNull()
        ->and($taxonomy->isDashboardGlance())->toBeNull();
});

it('keeps singular, plural and slug in the names array', function () {
    $taxonomy = new Taxonomy('genre', 'post', 'Genre', 'Genres');

    expect($taxonomy->getNames())->toBe(['slug' => 'genre', 'singular' => 'Genre', 'plural' => 'Genres']);

    $taxonomy->withSingular('Style')->withPlural('Styles')->withSlug('style');
    expect($taxonomy->getNames())->toBe(['slug' => 'style', 'singular' => 'Style', 'plural' => 'Styles']);

    $taxonomy->setSingular('Kind')->setPlural('Kinds')->setSlug('kind');
    expect($taxonomy->getNames())->toBe(['slug' => 'kind', 'singular' => 'Kind', 'plural' => 'Kinds']);
});

it('replaces the whole names array through names, withNames and setNames', function () {
    $taxonomy = new Taxonomy('genre', 'post');

    expect($taxonomy->names(['singular' => 'A'])->getNames())->toBe(['singular' => 'A'])
        ->and($taxonomy->withNames(['singular' => 'B'])->getNames())->toBe(['singular' => 'B'])
        ->and($taxonomy->setNames(['singular' => 'C'])->getNames())->toBe(['singular' => 'C']);
});

it('returns an empty names array when none was ever set', function () {
    $taxonomy = (new ReflectionClass(Taxonomy::class))->newInstanceWithoutConstructor();

    expect($taxonomy->getNames())->toBe([]);
});

it('returns translateArguments input unchanged', function () {
    $taxonomy = new Taxonomy('genre', 'post');
    $args = ['label' => 'Genres', 'labels' => ['name' => 'Genres']];

    expect($taxonomy->translateArguments($args, 'taxonomies'))->toBe($args);
});

it('does not expose the priority in the registration arguments', function () {
    $taxonomy = (new Taxonomy('genre', 'post'))->priority(12)->label('Genres');

    expect($taxonomy->getArgs())->not->toHaveKey('priority')
        ->and($taxonomy->getPriority())->toBe(12);
});
