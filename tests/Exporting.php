<?php

namespace Ornament\Tests;

use Ornament\Core\Model;
use Ornament\Json\SerializeOnlyPublic;
use Ornament\Json\SerializeAll;
use StdClass;

/**
 * Test exporting via the `jsonSerialize` traits.
 */
class Exporting
{
    /**
     * With the correct trait applied, only public properties should be exported
     * {?} and not protected ones {?}.
     */
    public function testExportsOnlyPublicProperties()
    {
        $model = new class() extends StdClass {
            use Model;
            use SerializeOnlyPublic;

            public $foo = 1;
            protected $bar = 2;
        };
        yield assert(isset($model->jsonSerialize()->foo));
        yield assert(!isset($model->jsonSerialize()->bar));
    }

    /**
     * With the correct trait applied, both public properties should be exported
     * {?} as well as protected ones {?}.
     */
    public function testExportsAllProperties()
    {
        $model = new class() extends StdClass {
            use Model;
            use SerializeAll;

            public $foo = 1;
            protected $bar = 2;
        };
        yield assert(isset($model->jsonSerialize()->foo));
        yield assert(isset($model->jsonSerialize()->bar));
    }
}

