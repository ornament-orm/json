<?php

namespace Ornament\Json;

use Ornament\Core\ModelCheck;
use StdClass;

trait SerializeAll
{
    use ModelCheck {
        ModelCheck::check as __ornamentSerializeAllCheck;
    }
    /**
     * Returns a StdClass model representation suitable for Json serialization.
     * This trait only exports both public and protected properties.
     *
     * @return StdClass
     * @throws DomainException if called on a non-Ornament model
     */
    public function jsonSerialize() : StdClass
    {
        $this->__ornamentSerializeAllCheck();
        $export = new StdClass;
        foreach ($this->__state as $name => $value) {
            $export->$name = $this->$name;
        }
        return $export;
    }
}

