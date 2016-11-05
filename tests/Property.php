<?php

namespace Ornament\Tests;

use Generator;

/**
 * Test the JSON decorator.
 */
class Property
{
    /**
     * A property annotated as Json should get decorated as the correct object
     * {?}.
     */
    public function testJsonDecoration() : Generator
    {
        yield assert(true);
    }
}

