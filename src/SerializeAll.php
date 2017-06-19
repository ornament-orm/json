<?php

namespace Ornament\Json;

use StdClass;

trait SerializeAll
{
    /**
     * Returns a StdClass model representation suitable for Json serialization.
     * This trait only exports both public and protected properties.
     *
     * @return StdClass
     */
    public function jsonSerialize() : StdClass
    {
        $export = new StdClass;
        foreach ($this->__state as $name => $value) {
            $export->$name = $this->$name;
        }
        return $export;
    }
}

