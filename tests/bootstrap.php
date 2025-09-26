<?php

declare(strict_types=1);

// Load Composer's autoloader
require_once __DIR__.'/../vendor/autoload.php';

// Configure Mockery
\Mockery::getConfiguration()->allowMockingNonExistentMethods(true);
