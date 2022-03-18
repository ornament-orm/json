<?php

namespace Ornament\Json;

use Ornament\Core\Decorator;
use JsonSerializable;
use StdClass;
use DomainException;
use Countable;
use Iterator;

class Property extends Decorator implements JsonSerializable, Countable, Iterator
{
    /**
     * @var mixed
     */
    private $decoded = null;

    /**
     * @var array
     */
    private $keys = [];

    /**
     * @var int
     */
    private $position = 0;

    public function __construct($value)
    {
        parent::__construct($value);
        if (is_string($value)) {
            if (null === ($decoded = json_decode($value))) {
                throw new DomainException($value);
            }
            $this->decoded = json_decode($value);
        } else {
            $this->decoded = $value ?? new StdClass;
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
}

