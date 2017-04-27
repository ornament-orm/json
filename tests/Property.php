<?php

namespace Ornament\Tests;

use Generator;
use StdClass;
use Ornament\Core\Model;
use Ornament\Json;

/**
 * Test the JSON decorator.
 */
class Property
{
    /**
     * A property annotated as Json should get decorated as the correct object
     * {?} and retain its data {?}. After changing the JSON, we still have the
     * updated information {?}. Serializing the property gives a `StdClass` {?},
     * and a `__toString()` gives the serialized JSON.
     */
    public function testJsonDecoration() : Generator
    {
        $model = new class() extends StdClass {
            use Model;

            /**
             * @var Ornament\Json\Property
             */
            public $test;
        };
        $model->test = '{"foo":"bar"}';
        yield assert($model->test instanceof Json\Property);
        yield assert($model->test->foo == 'bar');
        $model->test->bar = 'foo';
        yield assert($model->test->bar == 'foo');
        yield assert($model->test->jsonSerialize() instanceof StdClass);
        yield assert("{$model->test}" == '{"foo":"bar","bar":"foo"}');
    }
}

