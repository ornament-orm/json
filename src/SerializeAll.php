<?php

namespace Ornament\Json;

use stdClass;
use ReflectionClass;
use ReflectionProperty;

trait SerializeAll
{
    /**
     * Returns a StdClass model representation suitable for Json serialization.
     * This trait only exports both public and protected properties.
     *
     * @return StdClass
     */
    public function jsonSerialize() : stdClass
    {
        $reflection = new ReflectionClass($this);
        $export = new StdClass;
        foreach ($reflection->getProperties((ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED) & ~ReflectionProperty::IS_STATIC) as $property) {
            $name = $property->getName();
            $export->$name = $this->$name ?? null;
        }
        return $export;
    }
}

