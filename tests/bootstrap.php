<?php

declare(strict_types=1);

// Load Composer's autoloader
require_once __DIR__.'/../vendor/autoload.php';

// Load helper functions for tests
require_once __DIR__.'/helpers.php';

// Configure Mockery
\Mockery::getConfiguration()->allowMockingNonExistentMethods(true);
