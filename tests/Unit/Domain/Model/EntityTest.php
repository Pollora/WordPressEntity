<?php

declare(strict_types=1);

use Pollora\Entity\Domain\Model\Entity;

// Creating a concrete class to test the abstract Entity class
class ConcreteEntity extends Entity
{
    protected string $entity = 'test-entity';

    protected string $slug;

    protected ?string $singular;

    protected ?string $plural;

    public function __construct(string $slug, ?string $singular = null, ?string $plural = null)
    {
        $this->slug = $slug;
        $this->singular = $singular;
        $this->plural = $plural;
        $this->init();
    }

    public function init(): void
    {
        $this->setSlug($this->slug);
        $this->setSingular($this->singular);
        $this->setPlural($this->plural);
    }

    public function getSlug(): string
    {
        return parent::getSlug();
    }

    public function getArgs(): ?array
    {
        return $this->buildArguments();
    }
}

// Tests for the Entity class
test('can create entity instance', function () {
    $entity = new ConcreteEntity('test-slug', 'Test', 'Tests');

    expect($entity)->toBeInstanceOf(Entity::class)
        ->and($entity->getSlug())->toBe('test-slug')
        ->and($entity->getEntity())->toBe('test-entity');
});

test('can set and get label', function () {
    $entity = new ConcreteEntity('test-slug');
    $entity->setLabel('Test Label');

    expect($entity->getLabel())->toBe('Test Label');
});

test('can set and get labels array', function () {
    $entity = new ConcreteEntity('test-slug');
    $labels = [
        'name' => 'Tests',
        'singular_name' => 'Test',
        'add_new' => 'Add New',
    ];
    $entity->setLabels($labels);

    expect($entity->getLabels())->toBe($labels);
});

test('can set and get description', function () {
    $entity = new ConcreteEntity('test-slug');
    $entity->setDescription('Test description');

    expect($entity->getDescription())->toBe('Test description');
});

test('can set public visibility', function () {
    $entity = new ConcreteEntity('test-slug');

    // Test both methods for setting public
    $entity->public();
    expect($entity->isPublic())->toBeTrue();

    $entity->setPublic(false);
    expect($entity->isPublic())->toBeFalse();

    $entity->private();
    expect($entity->isPublic())->toBeFalse();
});

test('can build arguments', function () {
    $entity = new ConcreteEntity('test-slug', 'Test', 'Tests');
    $entity->setLabel('Test Label');
    $entity->setDescription('Test Description');
    $entity->public();

    $args = $entity->getArgs();

    expect($args)->toBeArray()
        ->and($args)->toHaveKey('label')
        ->and($args['label'])->toBe('Test Label')
        ->and($args)->toHaveKey('description')
        ->and($args['description'])->toBe('Test Description')
        ->and($args)->toHaveKey('public')
        ->and($args['public'])->toBeTrue();
});

test('can translate arguments', function () {
    $entity = new ConcreteEntity('test-slug', 'Test', 'Tests');
    $args = [
        'label' => 'Test Label',
        'names' => [
            'singular' => 'Test',
            'plural' => 'Tests',
        ],
    ];

    $translatedArgs = $entity->translateArguments($args, 'test-entity');

    // The default implementation just returns the arguments unchanged
    expect($translatedArgs)->toBe($args);
});

test('can set and get raw arguments', function () {
    $entity = new ConcreteEntity('test-slug');
    $rawArgs = [
        'custom_arg' => 'custom_value',
        'another_arg' => 123,
    ];

    $entity->setRawArgs($rawArgs);

    expect($entity->getRawArgs())->toBe($rawArgs);

    // Check that raw args are merged in buildArguments
    $entity->setLabel('Test Label');
    $args = $entity->getArgs();

    expect($args)->toHaveKey('custom_arg')
        ->and($args['custom_arg'])->toBe('custom_value')
        ->and($args)->toHaveKey('another_arg')
        ->and($args['another_arg'])->toBe(123);
});

test('can set and get names', function () {
    $entity = new ConcreteEntity('test-slug');
    $names = [
        'singular' => 'Test',
        'plural' => 'Tests',
        'slug' => 'custom-slug',
    ];

    $entity->setNames($names);

    expect($entity->getNames())->toMatchArray($names);

    // Test individual setters too
    $entity = new ConcreteEntity('original-slug');
    $entity->setSingular('Singular');
    $entity->setPlural('Plurals');
    $entity->setSlug('new-slug');

    $expectedNames = [
        'singular' => 'Singular',
        'plural' => 'Plurals',
        'slug' => 'new-slug',
    ];

    expect($entity->getNames())->toMatchArray($expectedNames);
});
