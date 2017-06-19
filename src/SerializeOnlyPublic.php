<?php

namespace Ornament\Json;

use StdClass;

trait SerializeOnlyPublic
{
    /**
     * Returns a StdClass model representation suitable for Json serialization.
     * This trait only exports public properties.
     *
     * @return StdClass
     */
    public function jsonSerialize() : StdClass
    {
        $annotations = $this->__ornamentalize();
        $export = new StdClass;
        foreach ($annotations['properties'] as $name => $anns) {
            if (!$anns['readOnly']) {
                $export->$name = $this->$name;
            }
        }
        return $export;
    }
}

