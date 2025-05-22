<?php

declare(strict_types=1);

namespace Pollora\Entity\Traits;

/**
 * The ArgumentHelper class is a trait that provides methods to extract arguments from properties using getter methods.
 */
trait ArgumentTranslater
{
    /**
     * Unused class. Need for the pollora framework.
     */
    protected function translateArguments(array $args, string $entity, array $keyToTranslate = [
        'label',
        'labels.*',
        'names.singular',
        'names.plural',
    ]): array
    {
        return $args;
    }
}
