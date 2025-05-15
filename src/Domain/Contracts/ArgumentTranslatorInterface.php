<?php

declare(strict_types=1);

namespace Pollora\Entity\Domain\Contracts;

/**
 * Interface for translating entity arguments.
 *
 * This interface defines how entity arguments should be translated
 * across different frameworks or implementations.
 */
interface ArgumentTranslatorInterface
{
    /**
     * Translates entity arguments based on the entity type and specified keys.
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
    ): array;
}
