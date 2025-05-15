<?php

declare(strict_types=1);

namespace Pollora\Entity\Infrastructure\Services;

use Pollora\Entity\Domain\Contracts\ArgumentTranslatorInterface;

/**
 * Laravel implementation of ArgumentTranslatorInterface.
 *
 * This implementation translates arguments using Laravel's translation system.
 * Note: This is a reference implementation that requires Laravel.
 */
class LaravelArgumentTranslator implements ArgumentTranslatorInterface
{
    /**
     * Translates entity arguments using Laravel's translation capabilities.
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
        ]
    ): array {
        // Early return if we're not in a Laravel environment
        if (! $this->isLaravelAvailable()) {
            return $args;
        }

        foreach ($keysToTranslate as $keyPath) {
            if (strpos($keyPath, '*') !== false) {
                // Handle wildcard keys (e.g., 'labels.*')
                $prefix = str_replace('.*', '', $keyPath);
                if (isset($args[$prefix]) && is_array($args[$prefix])) {
                    foreach ($args[$prefix] as $subKey => $value) {
                        if (is_string($value)) {
                            $translationKey = "{$entity}.{$prefix}.{$subKey}";
                            $args[$prefix][$subKey] = $this->translate_text($translationKey, ['value' => $value], $value);
                        }
                    }
                }
            } elseif (strpos($keyPath, '.') !== false) {
                // Handle nested keys (e.g., 'names.singular')
                $keys = explode('.', $keyPath);
                $this->translateNestedKey($args, $keys, $entity);
            } else {
                // Handle simple keys (e.g., 'label')
                if (isset($args[$keyPath]) && is_string($args[$keyPath])) {
                    $translationKey = "{$entity}.{$keyPath}";
                    $args[$keyPath] = $this->translate_text($translationKey, ['value' => $args[$keyPath]], $args[$keyPath]);
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
            $path = implode('.', array_merge([$entity], $keys, [$lastKey]));
            $current[$lastKey] = $this->translate_text($path, ['value' => $current[$lastKey]], $current[$lastKey]);
        }
    }

    /**
     * Check if Laravel is available in the current environment.
     */
    private function isLaravelAvailable(): bool
    {
        return function_exists('app') && function_exists('trans');
    }

    /**
     * Wrapper for Laravel's trans() function to avoid direct references.
     *
     * @param  string  $key  The translation key
     * @param  array  $replace  The replacement parameters
     * @param  string  $default  The default value
     * @return string The translated text
     */
    private function translate_text(string $key, array $replace = [], string $default = ''): string
    {
        if ($this->isLaravelAvailable()) {
            return call_user_func('trans', $key, $replace, $default);
        }

        return $default;
    }
}
