<?php

namespace Ornament\Tests;

use Generator;
use StdClass;
use Ornament\Core\Model;
use Ornament\Json;

/**
 * Test the JSON decorator.
 */
return function ($test) : Generator {
    $test->beforeEach(function () use (&$model) {
        $model = new class() extends StdClass {
            use Model;

            /**
             * @var Ornament\Json\Property
             */
            public $test;
        };
        $model->test = '{"foo":"bar"}';
    });
    /** A property annotated as Json should get decorated as the correct object and retain its data. */
    yield function () use (&$model) {
        assert($model->test instanceof Json\Property);
        assert($model->test->foo == 'bar');
    };
    /** After changing the JSON, we still have the updated information. */
    yield function () use (&$model) {
        $model->test->bar = 'foo';
        assert($model->test->bar == 'foo');
    };
    /** Serializing the property gives a `StdClass`, and a `__toString()` gives the serialized JSON. */
    yield function () use (&$model) {
        assert($model->test->jsonSerialize() instanceof StdClass);
        assert("{$model->test}" == '{"foo":"bar"}');
    };
};

