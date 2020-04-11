<?php

namespace Ornament\Json;

use ReflectionClass;
use stdClass;

trait Serializer
{
    private function jsonSerialized(int $flags) : stdClass
    {
        static $cache;
        if (!isset($cache)) {
            $cache = $this->__getModelPropertyDecorations();
        }
        $reflection = new ReflectionClass($this);
        $export = new StdClass;
        foreach ($reflection->getProperties($flags) as $property) {
            $name = $property->getName();
            $export->$name = $this->$name ?? null;
        }
        foreach ($cache['methods'] as $prop => $getter) {
            $export->$prop = $this->$getter($prop);
        }
        return $export;
    }
}

