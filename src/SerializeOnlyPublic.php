<?php

namespace Ornament\Json;

use stdClass;
use ReflectionClass;
use ReflectionProperty;

trait SerializeOnlyPublic
{
    /**
     * Returns a stdClass model representation suitable for Json serialization.
     * This trait only exports public properties.
     *
     * @return stdClass
     */
    public function jsonSerialize() : stdClass
    {
        $reflection = new ReflectionClass($this);
        $export = new stdClass;
        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC & ~ReflectionProperty::IS_STATIC) as $property) {
            $name = $property->getName();
            $export->$name = $this->$name ?? null;
        }
        return $export;
    }
}

