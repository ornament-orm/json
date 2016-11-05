<?php

namespace Ornament\Json;

use JsonSerializable;

class Property implements JsonSerializable
{
    private $__isNull = true;
    private $__original;

    public function __construct($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value);
        } else {
            $decoded = (object) $value;
        }
        if ($decoded) {
            $this->__isNull = false;
            $this->__original = $decoded;
            foreach ($decoded as $key => $item) {
                $this->$key =& $decoded->$key;
            }
        } elseif (is_scalar($value)) {
            $this->__original = $value;
            $this->__isNull = !(bool)$value;
        }
    }

    public function __toString() : string
    {
        if ($this->__isNull) {
            return 'NULL';
        } elseif (is_scalar($this->__original)) {
            return "{$this->__original}";
        }
        return json_encode((object) $this->__original);
    }

    public function jsonSerialize()
    {
        if ($this->__isNull) {
            return null;
        }
        return $this->__original;
    }
}

