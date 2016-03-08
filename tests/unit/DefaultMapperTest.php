<?php

namespace RemiSan\Serializer\Test;

use RemiSan\Serializer\Mapper\DefaultMapper;
use RemiSan\Serializer\SerializableClassNameExtractor;
use RemiSan\Serializer\Test\Mock\Serializable;

class DefaultMapperTest extends \PHPUnit_Framework_TestCase
{
    /** @var SerializableClassNameExtractor */
    private $nameExtractor;

    public function setUp()
    {
        $this->nameExtractor = \Mockery::mock(SerializableClassNameExtractor::class);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldRegisterTheClass()
    {
        $this->nameExtractor->shouldReceive('extractName')->andReturn('serializable');

        $mapper = new DefaultMapper($this->nameExtractor);

        $mapper->register(Serializable::class);

        $this->assertEquals(Serializable::class, $mapper->getClassName('serializable'));
    }

    /**
     * @test
     */
    public function itShouldRegisterTheClasses()
    {
        $this->nameExtractor->shouldReceive('extractName')->andReturn('serializable');

        $mapper = new DefaultMapper($this->nameExtractor);

        $mapper->registerMultiple([Serializable::class]);

        $this->assertEquals(Serializable::class, $mapper->getClassName('serializable'));
    }

    /**
     * @test
     */
    public function itShouldThrowAnExcpetionIfNotRegostered()
    {
        $mapper = new DefaultMapper($this->nameExtractor);

        $this->setExpectedException(\InvalidArgumentException::class);

        $mapper->getClassName('serializable');
    }
}
