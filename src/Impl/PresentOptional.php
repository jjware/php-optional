<?php

namespace JJWare\Util\Impl;

use \JJWare\Util\Optional;

class PresentOptional extends Optional
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function orElse($value)
    {
        return $this->value;
    }

    public function orElseGet(callable $supplier)
    {
        return $this->value;
    }

    public function orElseThrow(callable $supplier)
    {
        return $this->value;
    }

    public function ifPresent(callable $consumer)
    {
        call_user_func($consumer, $this->value);
    }

    public function isPresent()
    {
        return true;
    }

    public function map(callable $func): Optional {
        return Optional::ofNullable(call_user_func($func, $this->value));
    }

    public function flatMap(callable $func): Optional
    {
        return call_user_func($func, $this->value);
    }

    public function filter(callable $predicate): Optional
    {
        if (call_user_func($predicate, $this->value)) {
            return $this;
        } else {
            return Optional::empty();
        }
    }

    public function get() {
        return $this->value;
    }
}
