<?php

declare(strict_types=1);

namespace Pollora\Entity\Domain\Contracts;

/**
 * Interface for formatting arguments to WordPress-compatible format.
 */
interface ArgumentFormatterInterface
{
    /**
     * Format an object's properties into WordPress-compatible arguments.
     *
     * @param object $object The object to format
     * @param array $exclude Properties to exclude from formatting
     * @param array|null $rawArgs Raw arguments to merge with (takes priority)
     * @return array Formatted arguments in WordPress-compatible format
     */
    public function format(object $object, array $exclude = [], ?array $rawArgs = null): array;

    /**
     * Convert a camelCase string to snake_case.
     *
     * @param string $input The string to convert
     * @return string The converted string
     */
    public function toSnakeCase(string $input): string;
} 