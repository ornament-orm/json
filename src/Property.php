<?php

namespace Ornament\Json;

use Ornament\Core\Decorator;
use JsonSerializable;
use StdClass;
use Iterator;
use Countable;
use DomainException;

class Property extends Decorator implements JsonSerializable, Iterator, Countable
{
    private $decoded = null;
    private $position = 0;

    public function __construct(StdClass $object, string $property)
    {
        parent::__construct($object, $property);
        if (is_string($object->$property)) {
            if (!($decoded = json_decode($object->$property))) {
                throw new DomainException($object->$property);
            }
            $this->decoded = json_decode($object->$property);
        } else {
            $this->decoded = (object)$object->$property;
        }
    }

    public function __get(string $prop)
    {
        if (is_object($this->decoded) && isset($this->decoded->$prop)) {
            return $this->decoded->$prop;
        }
        if (is_array($this->decoded) && isset($this->decoded[$prop])) {
            return $this->decoded[$prop];
        }
    }

    public function __set(string $prop, $value)
    {
        if (is_object($this->decoded)) {
            $this->decoded->$prop = $value;
        } elseif (is_array($this->decoded)) {
            $this->decoded[$prop] = $value;
        }
        $this->source = json_encode($this->decoded);
    }

    public function __isset($prop)
    {
        return isset($this->decoded->$prop);
    }

    public function getSource() : string
    {
        return json_encode($this->decoded);
    }

    public function jsonSerialize()
    {
        return $this->decoded;
    }

    public function current()
    {
        $decoded = (array)$this->decoded;
        return $decoded[array_keys((array)$this->decoded)[$this->position]];
    }

    public function key()
    {
        return array_keys((array)$this->decoded)[$this->position];
    }

    public function next()
    {
        ++$this->position;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        return isset(array_keys((array)$this->decoded)[$this->position]);
    }

    public function count()
    {
        return count($this->decoded);
    }
}

