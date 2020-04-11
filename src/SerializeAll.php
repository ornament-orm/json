<?php

namespace Ornament\Json;

use stdClass;
use ReflectionProperty;

trait SerializeAll
{
    use Serializer;

    /**
     * Returns a StdClass model representation suitable for Json serialization.
     * This trait only exports both public and protected properties.
     *
     * @return StdClass
     */
    public function jsonSerialize() : stdClass
    {
        return $this->jsonSerialized((ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED) & ~ReflectionProperty::IS_STATIC);
    }
}

