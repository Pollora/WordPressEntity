<?php

declare(strict_types=1);

namespace Pollora\Entity\Adapter\Out\WordPress;

use RuntimeException;

/**
 * A WordPress function the adapter needs is not defined: WordPress is not loaded yet.
 */
final class WordPressFunctionMissingException extends RuntimeException {}
