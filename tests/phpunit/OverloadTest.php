<?php

namespace Tests\PhpUnit;

use Overload\Overload;
use Overload\OverloadClass;
use PHPUnit\Framework\TestCase;
use Tests\PhpUnit\ForTest\Bar;
use Tests\PhpUnit\ForTest\Foo;

class OverloadTest extends TestCase
{
    public function testCallOneMethod()
    {
        $overload = new Overload(
            new OverloadClass(Bar::class), 'oneMethod'
        );

        $this->assertEquals(
            1, $overload->call()
        );
    }

    public function testCallOneMethodWithArgument()
    {
        $overload = new Overload(
            new OverloadClass(Bar::class), 'oneMethodWithArgument'
        );

        $this->assertEquals(
            'shinda', $overload->call('shinda')
        );
    }

    public function testCallWithTwoMethodsReturnString()
    {
        $overload = new Overload(
            new OverloadClass(Bar::class), 'twoMethods1', 'twoMethods2'
        );

        $this->assertEquals(
            'shinda', $overload->call('shinda')
        );
    }

    public function testCallWithTwoMethodsReturnInteger()
    {
        $overload = new Overload(
            new OverloadClass(Bar::class), 'twoMethods1', 'twoMethods2'
        );

        $this->assertEquals(
            5, $overload->call(5)
        );
    }

    public function testCallWithTwoArgumentsFirst()
    {
        $overload = new Overload(
            new OverloadClass(Bar::class), 'twoArguments1', 'twoArguments2'
        );

        $this->assertEquals(
            'shinda1', $overload->call('shinda', 1)
        );
    }

    public function testCallWithTwoArgumentsWithSecond()
    {
        $overload = new Overload(
            new OverloadClass(Bar::class), 'twoArguments1', 'twoArguments2'
        );

        $this->assertEquals(
            'kioku3', $overload->call(['key' => 'kioku'], 3)
        );
    }

    public function testCallWithOneObject()
    {
        $overload = new Overload(
            new OverloadClass(Bar::class), 'oneObject'
        );

        $object = new Foo();

        $this->assertEquals(
            $object, $overload->call(new Foo())
        );
    }

    public function testCallWithThreeArgumentsString()
    {
        $overload = new Overload(
            new OverloadClass(Bar::class), 'threeArguments1', 'threeArguments2', 'threeArguments3'
        );

        $this->assertEquals(
            'string', $overload->call('string')
        );
    }

    public function testCallWithThreeArgumentsInteger()
    {
        $overload = new Overload(
            new OverloadClass(Bar::class), 'threeArguments1', 'threeArguments2', 'threeArguments3'
        );

        $this->assertEquals(
            31, $overload->call(31)
        );
    }

    public function testCallWithThreeArgumentsArray()
    {
        $overload = new Overload(
            new OverloadClass(Bar::class), 'threeArguments1', 'threeArguments2', 'threeArguments3'
        );

        $this->assertEquals(
            ['key' => 'value'], $overload->call(['key' => 'value'])
        );
    }
}