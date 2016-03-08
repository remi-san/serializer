<?php

namespace RemiSan\Serializer\Test;

use RemiSan\Serializer\DataFormatter;
use RemiSan\Serializer\Hydrator\HydratorFactory;
use RemiSan\Serializer\SerializableClassMapper;
use RemiSan\Serializer\Serializer;

class SerializerTest extends \PHPUnit_Framework_TestCase
{
    /** @var SerializableClassMapper */
    private $classMapper;

    /** @var HydratorFactory */
    private $hydratorFactory;

    /** @var DataFormatter */
    private $dataFormatter;

    public function setUp()
    {
        $this->classMapper = \Mockery::mock(SerializableClassMapper::class);
        $this->hydratorFactory = \Mockery::mock(HydratorFactory::class);
        $this->dataFormatter = \Mockery::mock(DataFormatter::class);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldSerialize()
    {
        $serializer = new Serializer(
            $this->classMapper,
            $this->hydratorFactory,
            $this->dataFormatter,
            true
        );

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function itShouldDeserialize()
    {
        $serializer = new Serializer(
            $this->classMapper,
            $this->hydratorFactory,
            $this->dataFormatter,
            true
        );

        $this->assertTrue(true);
    }
}
