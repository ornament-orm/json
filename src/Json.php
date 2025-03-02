<?php

namespace Ornament\Json;

use JsonSerializable;
use StdClass;
use DomainException;
use Countable;
use Iterator;
use ReflectionProperty;

class Json implements JsonSerializable, Countable, Iterator
{
    private array|object $decoded;

    private array $keys = [];

    private int $position = 0;

    public function __construct(protected array|object|string $_source)
    {
        if (is_string($_source)) {
            if (null === ($decoded = json_decode($_source))) {
                throw new DomainException($_source);
            }
            $this->decoded = json_decode($_source);
        } else {
            $this->decoded = $_source ?? new StdClass;
        }
        $this->keys = array_keys((array)$this->decoded);
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
        $this->_source = json_encode($this->decoded);
    }

    public function __isset(string $prop)
    {
        return isset($this->decoded->$prop);
    }

    public function getSource() : string
    {
        return json_encode($this->decoded);
    }

    public function jsonSerialize() : mixed
    {
        return $this->decoded;
    }

    public function count() : int
    {
        return count((array)$this->decoded);
    }

    public function current() : mixed
    {
        $values = (array)$this->decoded;
        return $values[$this->keys[$this->position]];
    }

    public function key() : mixed
    {
        return $this->keys[$this->position];
    }

    public function next() : void
    {
        ++$this->position;
    }

    public function rewind() : void
    {
        $this->position = 0;
    }

    public function valid() : bool
    {
        return isset($this->keys[$this->position]);
    }

    public function __toString() : string
    {
        return json_encode($this->decoded);
    }
}

