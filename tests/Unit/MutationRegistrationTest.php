<?php

declare(strict_types=1);

use Pollora\Entity\Adapter\Out\WordPress\PostTypeRegistryAdapter;
use Pollora\Entity\Adapter\Out\WordPress\TaxonomyRegistryAdapter;
use Pollora\Entity\Application\Service\EntityRegistrationService;
use Pollora\Entity\Domain\Model\Entity;
use Pollora\Entity\Domain\Model\PostType as PostTypeDomain;
use Pollora\Entity\Port\Out\EntityRegistryPort;
use Pollora\Entity\PostType;

beforeEach(function () {
    $GLOBALS['entity_test_registrations'] = [];
    $GLOBALS['ext_cpts_registrations'] = [];
});

test('the post type adapter delegates to the extended post type library', function () {
    (new PostTypeRegistryAdapter)->registerPostType('book', ['public' => true], ['singular' => 'Book', 'plural' => 'Books']);

    expect($GLOBALS['ext_cpts_registrations'])->toHaveCount(1)
        ->and($GLOBALS['ext_cpts_registrations'][0][0])->toBe('post_type')
        ->and($GLOBALS['ext_cpts_registrations'][0][1])->toBe('book')
        ->and($GLOBALS['ext_cpts_registrations'][0][2])->toHaveKey('public', true);
});

test('the taxonomy adapter delegates to the extended taxonomy library', function () {
    (new TaxonomyRegistryAdapter)->registerTaxonomy('genre', ['book'], ['public' => true], ['singular' => 'Genre']);

    expect($GLOBALS['ext_cpts_registrations'])->toHaveCount(1)
        ->and($GLOBALS['ext_cpts_registrations'][0][0])->toBe('taxonomy')
        ->and($GLOBALS['ext_cpts_registrations'][0][1])->toBe('genre')
        ->and($GLOBALS['ext_cpts_registrations'][0][2])->toBe(['book']);
});

test('the post type facade registers the post type with WordPress', function () {
    $postType = PostType::make('movie', 'Movie', 'Movies');

    expect($postType)->toBeInstanceOf(PostTypeDomain::class)
        ->and($GLOBALS['ext_cpts_registrations'])->toHaveCount(1)
        ->and($GLOBALS['ext_cpts_registrations'][0][0])->toBe('post_type')
        ->and($GLOBALS['ext_cpts_registrations'][0][1])->toBe('movie');
});

test('the registration service passes args without names and names separately', function () {
    $registry = new class implements EntityRegistryPort
    {
        /** @var list<array<int, mixed>> */
        public array $calls = [];

        public function register(string $slug, array $args, array $names): void
        {
            $this->calls[] = [$slug, $args, $names];
        }
    };

    $entity = new class extends Entity
    {
        protected string $entity = 'things';

        public function init(): void {}

        public function getArgs(): array
        {
            return ['label' => 'Thing'];
        }

        public function getNames(): array
        {
            return ['slug' => 'thing', 'singular' => 'Thing'];
        }

        public function getSlug(): string
        {
            return 'thing';
        }
    };

    (new EntityRegistrationService($registry))->registerEntity($entity);

    expect($registry->calls)->toBe([['thing', ['label' => 'Thing'], ['slug' => 'thing', 'singular' => 'Thing']]]);
});

test('the registration service passes empty names when the translated args drop them', function () {
    $registry = new class implements EntityRegistryPort
    {
        /** @var list<array<int, mixed>> */
        public array $calls = [];

        public function register(string $slug, array $args, array $names): void
        {
            $this->calls[] = [$slug, $args, $names];
        }
    };

    $entity = new class extends Entity
    {
        protected string $entity = 'things';

        public function init(): void {}

        public function getArgs(): array
        {
            return ['label' => 'Thing'];
        }

        public function getSlug(): string
        {
            return 'thing';
        }

        public function translateArguments(array $args, string $entity, array $keyToTranslate = []): array
        {
            unset($args['names']);

            return $args;
        }
    };

    (new EntityRegistrationService($registry))->registerEntity($entity);

    expect($registry->calls)->toBe([['thing', ['label' => 'Thing'], []]]);
});

test('a new post type initialises its names in the constructor', function () {
    $postType = new PostTypeDomain('album', 'Album', 'Albums');

    expect($postType->getNames())->toBe(['slug' => 'album', 'singular' => 'Album', 'plural' => 'Albums']);
});

test('an entity without a slug reports an empty string', function () {
    $entity = new class extends Entity
    {
        protected string $entity = 'x';

        public function init(): void {}
    };

    expect($entity->getSlug())->toBe('');
});

test('a null declaration priority falls back to the declared priority', function (): void {
    $registry = new class implements EntityRegistryPort
    {
        public function register(string $slug, array $args, array $names): void {}
    };
    $entity = new class('movie', 'Movie', 'Movies') extends PostTypeDomain
    {
        public function getPriority(): ?int
        {
            return null;
        }
    };

    (new EntityRegistrationService($registry))->registerEntity($entity);

    expect($GLOBALS['entity_test_hook_priorities']['init'])->toBe($entity->priority);
});
