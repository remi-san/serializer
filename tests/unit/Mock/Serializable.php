<?php

namespace RemiSan\Serializer\Test\Mock;

class Serializable
{
    public $foo;
    protected $bar;
    private $baz;

    public function __construct($baz = null)
    {
        $this->foo = 'foo';
        $this->bar = 'bar';
        $this->baz = $baz;
    }
}
