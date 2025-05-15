<?php

declare(strict_types=1);

namespace Pollora\Entity\Infrastructure\Services;

use Pollora\Entity\Domain\Contracts\ArgumentTranslatorInterface;

/**
 * Default implementation of ArgumentTranslatorInterface that performs no translation.
 *
 * This implementation follows the Null Object pattern, allowing the code to
 * function without translation when no specific translator is provided.
 */
class NullArgumentTranslator implements ArgumentTranslatorInterface
{
    /**
     * Returns the original arguments without translation.
     *
     * @param  array<string, mixed>  $args  The arguments to translate
     * @param  string  $entity  The entity type (e.g., 'post-types', 'taxonomies')
     * @param  array<int, string>  $keysToTranslate  The keys to be translated
     * @return array<string, mixed> The original arguments
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
        return $args;
    }
}
