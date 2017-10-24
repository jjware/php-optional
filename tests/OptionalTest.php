<?php

use JJWare\Util\Impl\EmptyOptional;
use JJWare\Util\Impl\PresentOptional;
use JJWare\Util\Optional;

class OptionalTest extends PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $this->assertEquals(Optional::empty(), new EmptyOptional());
    }

    public function testOf()
    {
        $this->assertEquals(Optional::of(1), new PresentOptional(1));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testOfWithNull()
    {
        Optional::of(null);
    }

    public function testOfNullableForSome()
    {
        $this->assertEquals(Optional::ofNullable(1), new PresentOptional(1));
    }

    public function testOfNullableForNull()
    {
        $this->assertEquals(Optional::ofNullable(null), new EmptyOptional());
    }

    public function testOrElseWhenPresent()
    {
        $value = Optional::of(1)->orElse(2);
        $this->assertEquals($value, 1);
    }

    public function testOrElseWhenEmpty()
    {
        $value = Optional::empty()->orElse(2);
        $this->assertEquals($value, 2);
    }

    public function testOrElseGetWhenPresent()
    {
        $value = Optional::of(1)->orElseGet(function () {
            return 3;
        });
        $this->assertEquals($value, 1);
    }

    public function testOrElseGetWhenEmpty()
    {
        $value = Optional::empty()->orElseGet(function () {
            return 3;
        });
        $this->assertEquals($value, 3);
    }

    public function testOrElseThrowWhenPresent()
    {
        $value = Optional::of(1)->orElseThrow(function () {
            return new InvalidArgumentException("test");
        });
        $this->assertEquals($value, 1);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testOrElseThrowWhenEmpty()
    {
        Optional::empty()->orElseThrow(function () {
            return new InvalidArgumentException("test");
        });
    }

    public function testIsPresentWhenPresent()
    {
        $o = Optional::of(1);
        $this->assertTrue($o->isPresent());
    }

    public function testIsPresentWhenEmpty()
    {
        $o = Optional::empty();
        $this->assertFalse($o->isPresent());
    }

    public function testIfPresentWhenPresent()
    {
        $t = new stdClass();
        $t->value = 0;
        Optional::of(1)->ifPresent(function ($x) use ($t) {
            $t->value = $x;
        });
        $this->assertEquals($t->value, 1);
    }

    public function testIfPresentWhenEmpty()
    {
        $t = new stdClass();
        $t->value = 0;
        Optional::empty()->ifPresent(function ($x) use ($t) {
            $t->value = $x;
        });
        $this->assertEquals($t->value, 0);
    }

    public function testMapWhenPresent()
    {
        $value = Optional::of(1)->map(function ($x) {
            return 'test' . $x;
        });
        $this->assertEquals($value, Optional::of('test1'));
    }

    public function testMapWhenEmpty()
    {
        $value = Optional::empty()->map(function ($x) {
            return 'test' . $x;
        });
        $this->assertEquals($value, Optional::empty());
    }

    public function testFlatMapWhenPresent()
    {
        $value = Optional::of(1)->flatMap(function ($x) {
            return Optional::of($x + 1);
        })->get();
        $this->assertEquals($value, 2);
    }

    public function testFlatMapWhenEmpty()
    {
        $value = Optional::empty()->flatMap(function ($x) {
            return Optional::of($x + 1);
        })->orElse(0);
        $this->assertEquals($value, 0);
    }

    public function testFilterWhenPresentEvaluateTrue()
    {
        $value = Optional::of(1)->filter(function ($x) {
            return $x == 1;
        });
        $this->assertEquals($value, Optional::of(1));
    }

    public function testFilterWhenPresentEvaluateFalse()
    {
        $value = Optional::of(1)->filter(function ($x) {
            return $x < 1;
        });
        $this->assertEquals($value, Optional::empty());
    }

    public function testFilterWhenEmpty()
    {
        $value = Optional::empty()->filter(function ($x) {
            return $x == 1;
        });
        $this->assertEquals($value, Optional::empty());
    }

    public function testGetWhenPresent()
    {
        $value = Optional::of(1)->get();
        $this->assertEquals($value, 1);
    }

    /**
     * @expectedException UnderflowException
     */
    public function testGetWhenEmpty()
    {
        Optional::empty()->get();
    }
}
