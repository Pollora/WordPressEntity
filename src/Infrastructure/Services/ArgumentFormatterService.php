<?php

declare(strict_types=1);

namespace Pollora\Entity\Infrastructure\Services;

use Pollora\Entity\Domain\Contracts\ArgumentFormatterInterface;

/**
 * Service for formatting arguments to WordPress-compatible format.
 */
final class ArgumentFormatterService implements ArgumentFormatterInterface
{
    /**
     * Format an object's properties into WordPress-compatible arguments.
     *
     * @param object $object The object to format
     * @param array $exclude Properties to exclude from formatting
     * @param array|null $rawArgs Raw arguments to merge with (takes priority)
     * @return array Formatted arguments in WordPress-compatible format
     */
    public function format(object $object, array $exclude = [], ?array $rawArgs = null): array
    {
        $args = $this->extractArguments($object, $exclude);
        return $this->mergeWithRawArgs($args, $rawArgs);
    }

    /**
     * Convert a camelCase string to snake_case.
     *
     * @param string $input The string to convert
     * @return string The converted string
     */
    public function toSnakeCase(string $input): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }

    /**
     * Extract arguments from object properties.
     *
     * @param object $object The object to extract from
     * @param array $exclude Properties to exclude
     * @return array Extracted arguments
     */
    private function extractArguments(object $object, array $exclude = []): array
    {
        $reflection = new \ReflectionClass($object);
        $args = [];

        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $name = $property->getName();
            
            if (in_array($name, $exclude, true)) {
                continue;
            }

            $value = $property->getValue($object);
            if ($value !== null) {
                $args[$this->toSnakeCase($name)] = $value;
            }
        }

        return $args;
    }

    /**
     * Merge raw arguments with extracted arguments.
     *
     * @param array $args Extracted arguments
     * @param array|null $rawArgs Raw arguments to merge with
     * @return array Merged arguments
     */
    private function mergeWithRawArgs(array $args, ?array $rawArgs): array
    {
        if ($rawArgs === null) {
            return $args;
        }
        
        // Fusionner les arguments en donnant la priorité aux rawArgs
        return array_merge($args, $rawArgs);
    }
} 