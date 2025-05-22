<?php

declare(strict_types=1);

namespace Pollora\Entity\Shared\Traits;

/**
 * The ArgumentTranslater trait provides methods to translate arguments for entity registration.
 *
 * This trait can be used to handle translation of labels and other textual properties
 * when registering post types or taxonomies. In the default implementation,
 * it simply returns the original arguments unchanged.
 */
trait ArgumentTranslater
{
    /**
     * Translates provided arguments for entity registration.
     *
     * In some contexts, this method can be overridden to provide
     * translation capabilities for entity labels and descriptions.
     * The default implementation simply returns the original arguments.
     *
     * @param  array  $args  The arguments to translate
     * @param  string  $entity  The entity type ('post-types' or 'taxonomies')
     * @param  array  $keyToTranslate  Keys that should be translated
     * @return array The translated arguments
     */
    public function translateArguments(array $args, string $entity, array $keyToTranslate = [
        'label',
        'labels.*',
        'names.singular',
        'names.plural',
    ]): array
    {
        return $args;
    }
}
