<?php

namespace JJWare\Util;

use JJWare\Util\Impl\EmptyOptional;
use JJWare\Util\Impl\PresentOptional;
use Prophecy\Exception\InvalidArgumentException;

abstract class Optional
{
    private static $EMPTY_VALUE = null;

    /**
     * Returns a new Optional from a nullable variable
     *
     * When provided with a value other than null, a populated Optional object is returned. When provided with a null value, an empty Optional is returned
     * @param mixed|null $value
     * @return Optional
     */
    public static function ofNullable($value)
    {
        return is_null($value) ? static::empty() : new PresentOptional($value);
    }

    /**
     * Returns an empty Optional
     * @return Optional
     */
    public static function empty()
    {
        if (is_null(static::$EMPTY_VALUE)) {
            static::$EMPTY_VALUE = new EmptyOptional();
        }
        return static::$EMPTY_VALUE;
    }

    /**
     * Returns a populated Optional
     *
     * When a null value is provided, throws an InvalidArgumentException
     * @param mixed $value
     * @return Optional
     * @throws InvalidArgumentException
     */
    public static function of($value)
    {
        if (is_null($value)) {
            throw new InvalidArgumentException("Null value");
        }
        return new PresentOptional($value);
    }

    /**
     * Returns value when present, otherwise returns the given value
     * @param mixed $value
     * @return mixed
     */
    public abstract function orElse($value);

    /**
     * Returns value when present, or else the return value of the supplier function
     * @param callable $supplier
     * @return mixed
     */
    public abstract function orElseGet(callable $supplier);

    /**
     * Returns value when present, otherwise throws the exception returned by the supplier function
     * @param callable $supplier
     * @return mixed
     */
    public abstract function orElseThrow(callable $supplier);

    /**
     * Invokes the consumer, passing in the value, if the value is present
     *
     * Does nothing if no value is present
     * @param callable $consumer
     * @return void
     */
    public abstract function ifPresent(callable $consumer);

    /**
     * Returns true if a value is present, otherwise returns null
     * @return bool
     */
    public abstract function isPresent();

    /**
     * Returns a new Optional containing the result of the function argument invocation
     * @param callable $func
     * @return Optional
     */
    public abstract function map(callable $func);

    /**
     * Returns a new Optional containing the value if present, otherwise returns an empty Optional
     * @param callable $predicate
     * @return Optional
     */
    public abstract function filter(callable $predicate);

    /**
     * Returns value if present, otherwise throws UnderflowException
     * @return mixed
     * @throws \UnderflowException
     */
    public abstract function get();
}
