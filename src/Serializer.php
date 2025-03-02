<?php

namespace Ornament\Json;

use Ornament\Core\Helpers;
use ReflectionClass;
use stdClass;

trait Serializer
{
    private function jsonSerialized(int $flags) : stdClass
    {
        static $cache;
        if (!isset($cache)) {
            $cache = Helpers::getModelPropertyDecorations($this);
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

