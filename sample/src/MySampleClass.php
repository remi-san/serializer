<?php
namespace RemiSan\Serializer\Sample;

class MySampleClass
{
    public $foo;
    protected $bar;
    private $baz;

    public function __construct($baz = 'baz')
    {
        $this->foo = 'foo';
        $this->bar = 'bar';
        $this->baz = $baz;
    }
}
