<?php

namespace Ornament\Json;

use Ornament\Core\Decorator;
use JsonSerializable;
use StdClass;
use Iterator;
use Countable;
use ArrayAccess;
use DomainException;

class Property extends Decorator implements JsonSerializable, Iterator, Countable, ArrayAccess
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
            $this->decoded = $object->$property ?? new StdClass;
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

    public function offsetExists($offset) : bool
    {
        if (is_object($this->decoded)) {
            return isset($this->decoded->$offset);
        } elseif (is_array($this->decoded)) {
            return isset($this->decoded[$offset]);
        }
        return false;
    }

    public function offsetGet($offset)
    {
        if (is_object($this->decoded)) {
            return $this->decoded->$offset;
        } elseif (is_array($this->decoded)) {
            return $this->decoded[$offset];
        } else {
            return null;
        }
    }

    public function offsetSet($offset, $value)
    {
        if (is_object($this->decoded)) {
            $this->decoded->$offset = $value;
        } elseif (is_array($this->decoded)) {
            $this->decoded[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        if (is_object($this->decoded)) {
            unset($this->decoded->$offset);
        } elseif (is_array($this->decoded)) {
           unset($this->decoded[$offset]);
        }
    }
}

