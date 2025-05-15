<?php

declare(strict_types=1);

namespace Pollora\Entity\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Reset any mocked WordPress functions
        $GLOBALS['wp_function_mocks'] = [];
    }

    /**
     * Mock a WordPress function.
     *
     * @param  string  $functionName  The function name to mock
     * @param  mixed  $returnValue  The value the function should return
     */
    protected function mockWordPressFunction(string $functionName, $returnValue = null): void
    {
        if (! function_exists($functionName)) {
            eval("function {$functionName}() { 
                \$args = func_get_args();
                return \$GLOBALS['wp_function_mocks']['{$functionName}'][\$args] 
                    ?? \$GLOBALS['wp_function_mocks']['{$functionName}'] 
                    ?? null; 
            }");
        }

        $GLOBALS['wp_function_mocks'][$functionName] = $returnValue;
    }
}
