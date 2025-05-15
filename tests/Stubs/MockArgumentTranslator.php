<?php

declare(strict_types=1);

namespace Pollora\Entity\Tests\Stubs;

use Pollora\Entity\Domain\Contracts\ArgumentTranslatorInterface;

/**
 * A mock implementation of ArgumentTranslatorInterface for testing.
 *
 * This translator simulates translations by appending the entity type
 * to the string values that need to be translated.
 */
class MockArgumentTranslator implements ArgumentTranslatorInterface
{
    /**
     * Simulates translations by appending the entity type to the string values.
     *
     * @param  array<string, mixed>  $args  The arguments to translate
     * @param  string  $entity  The entity type (e.g., 'post-types', 'taxonomies')
     * @param  array<int, string>  $keysToTranslate  The keys to be translated
     * @return array<string, mixed> The translated arguments
     */
    public function translate(
        array $args,
        string $entity,
        array $keysToTranslate = [
            'label',
            'labels.*',
            'names.singular',
            'names.plural',
            'singular',
            'plural',
        ]
    ): array {
        foreach ($keysToTranslate as $keyPath) {
            if (strpos($keyPath, '*') !== false) {
                // Handle wildcard keys (e.g., 'labels.*')
                $prefix = str_replace('.*', '', $keyPath);
                if (isset($args[$prefix]) && is_array($args[$prefix])) {
                    foreach ($args[$prefix] as $subKey => $value) {
                        if (is_string($value)) {
                            $args[$prefix][$subKey] = $this->mockTranslate($value, $entity);
                        }
                    }
                }
            } elseif (strpos($keyPath, '.') !== false) {
                // Handle nested keys (e.g., 'names.singular')
                $keys = explode('.', $keyPath);
                $this->translateNestedKey($args, $keys, $entity);
            } else {
                // Handle simple keys (e.g., 'label', 'singular', 'plural')
                if (isset($args[$keyPath]) && is_string($args[$keyPath])) {
                    $args[$keyPath] = $this->mockTranslate($args[$keyPath], $entity);
                }
            }
        }

        return $args;
    }

    /**
     * Translate a nested key in an array.
     *
     * @param  array<string, mixed>  $args  The arguments being translated
     * @param  array<int, string>  $keys  The nested key path as an array
     * @param  string  $entity  The entity type for translation
     */
    private function translateNestedKey(array &$args, array $keys, string $entity): void
    {
        $current = &$args;
        $lastKey = array_pop($keys);

        foreach ($keys as $key) {
            if (! isset($current[$key]) || ! is_array($current[$key])) {
                return;
            }
            $current = &$current[$key];
        }

        if (isset($current[$lastKey]) && is_string($current[$lastKey])) {
            $current[$lastKey] = $this->mockTranslate($current[$lastKey], $entity);
        }
    }

    /**
     * Helper method to simulate translation by appending the entity type.
     *
     * @param  string  $value  The original string
     * @param  string  $entity  The entity type
     * @return string The "translated" string
     */
    private function mockTranslate(string $value, string $entity): string
    {
        return "[{$entity}] {$value}";
    }
}
