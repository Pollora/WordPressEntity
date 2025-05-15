<?php

declare(strict_types=1);

namespace Pollora\Entity\Tests\Unit\Domain\Services;

use Pollora\Entity\Infrastructure\Services\ArgumentFormatterService;

test('converts camelCase to snake_case', function () {
    $formatter = new ArgumentFormatterService();

    expect($formatter->toSnakeCase('camelCase'))->toBe('camel_case')
        ->and($formatter->toSnakeCase('PascalCase'))->toBe('pascal_case')
        ->and($formatter->toSnakeCase('already_snake_case'))->toBe('already_snake_case')
        ->and($formatter->toSnakeCase('multipleCamelCaseWords'))->toBe('multiple_camel_case_words');
});

test('extracts arguments from object properties', function () {
    $formatter = new ArgumentFormatterService();
    
    $testObject = new class {
        protected string $testProperty = 'value';
        protected ?string $nullProperty = null;
        protected array $arrayProperty = ['key' => 'value'];
        protected int $intProperty = 42;
        protected bool $boolProperty = true;
    };

    $result = $formatter->format($testObject);

    expect($result)->toBeArray()
        ->and($result)->toHaveKey('test_property', 'value')
        ->and($result)->toHaveKey('array_property', ['key' => 'value'])
        ->and($result)->toHaveKey('int_property', 42)
        ->and($result)->toHaveKey('bool_property', true)
        ->and($result)->not->toHaveKey('null_property');
});

test('excludes specified properties', function () {
    $formatter = new ArgumentFormatterService();
    
    $testObject = new class {
        protected string $includeMe = 'value';
        protected string $excludeMe = 'value';
    };

    $result = $formatter->format($testObject, ['excludeMe']);

    expect($result)->toBeArray()
        ->and($result)->toHaveKey('include_me', 'value')
        ->and($result)->not->toHaveKey('exclude_me');
});

test('merges raw arguments with extracted arguments', function () {
    $formatter = new ArgumentFormatterService();
    
    $testObject = new class {
        protected string $property = 'value';
    };

    $rawArgs = [
        'property' => 'overridden',
        'new_property' => 'new_value'
    ];

    $result = $formatter->format($testObject, [], $rawArgs);

    expect($result)->toBeArray()
        ->and($result)->toHaveKey('property', 'overridden')
        ->and($result)->toHaveKey('new_property', 'new_value');
});

test('handles null raw arguments', function () {
    $formatter = new ArgumentFormatterService();
    
    $testObject = new class {
        protected string $property = 'value';
    };

    $result = $formatter->format($testObject, [], null);

    expect($result)->toBeArray()
        ->and($result)->toHaveKey('property', 'value');
});

test('preserves array values', function () {
    $formatter = new ArgumentFormatterService();
    
    $testObject = new class {
        protected array $nestedArray = [
            'key' => [
                'nested' => 'value'
            ]
        ];
    };

    $result = $formatter->format($testObject);

    expect($result)->toBeArray()
        ->and($result)->toHaveKey('nested_array', [
            'key' => [
                'nested' => 'value'
            ]
        ]);
}); 