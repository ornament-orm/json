<?php

use Ornament\Core\Model;
use Ornament\Json\SerializeOnlyPublic;
use Ornament\Json\SerializeAll;

/**
 * Test exporting via the `jsonSerialize` traits.
 */
return function () : Generator {
    /**
     * With the correct trait applied, only public properties should be exported
     * and not protected ones.
     */
    yield function () {
        $model = new class() extends StdClass implements JsonSerializable {
            use Model;
            use SerializeOnlyPublic;

            public $foo = 1;
            protected $bar = 2;
        };
        assert(isset($model->jsonSerialize()->foo));
        assert(!isset($model->jsonSerialize()->bar));
    };

    /**
     * With the correct trait applied, both public properties should be exported
     * as well as protected ones.
     */
    yield function () {
        $model = new class() extends StdClass implements JsonSerializable {
            use Model;
            use SerializeAll;

            public $foo = 1;
            protected $bar = 2;
        };
        assert(isset($model->jsonSerialize()->foo));
        assert(isset($model->jsonSerialize()->bar));
    };
};

