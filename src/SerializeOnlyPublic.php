<?php

namespace Ornament\Json;

use stdClass;
use ReflectionProperty;

trait SerializeOnlyPublic
{
    use Serializer;

    /**
     * Returns a stdClass model representation suitable for Json serialization.
     * This trait only exports public properties.
     *
     * @return stdClass
     */
    public function jsonSerialize() : stdClass
    {
        return $this->serialized(ReflectionProperty::IS_PUBLIC & ~ReflectionProperty::IS_STATIC);
    }
}

