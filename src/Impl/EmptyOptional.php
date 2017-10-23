<?php

namespace JJWare\Util\Impl;

use \JJWare\Util\Optional;

class EmptyOptional extends Optional
{
    public function orElse($value)
    {
        return $value;
    }

    public function orElseGet(callable $supplier)
    {
        return call_user_func($supplier);
    }

    public function orElseThrow(callable $supplier)
    {
        throw call_user_func($supplier);
    }

    public function ifPresent(callable $consumer)
    {
        // Do nothing
    }

    public function isPresent(): bool
    {
        return false;
    }

    public function map(callable $func) : Optional {
        return $this;
    }

    public function filter(callable $predicate) : Optional
    {
        return $this;
    }

    public function get() {
        throw new \UnderflowException("No value present");
    }
}
