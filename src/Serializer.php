<?php

namespace Ornament\Json;

use ReflectionClass;
use stdClass;

trait Serializer
{
    private function serialized(int $flags) : stdClass
    {
        $reflection = new ReflectionClass($this);
        $export = new StdClass;
        foreach ($reflection->getProperties($flags) as $property) {
            $name = $property->getName();
            $export->$name = $this->$name ?? null;
        }
        $cache = $this->__getModelPropertyDecorations();
        foreach ($cache['methods'] as $prop => $getter) {
            $export->$prop = $this->$getter($prop);
        }
        return $export;
    }
}

