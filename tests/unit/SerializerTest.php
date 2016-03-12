<?php

namespace RemiSan\Serializer\Test;

use Doctrine\Instantiator\Instantiator;
use Doctrine\Instantiator\InstantiatorInterface;
use RemiSan\Serializer\DataFormatter;
use RemiSan\Serializer\Formatter\FlatFormatter;
use RemiSan\Serializer\Hydrator\HydratorFactory;
use RemiSan\Serializer\Mapper\DefaultMapper;
use RemiSan\Serializer\NameExtractor\DefaultNameExtractor;
use RemiSan\Serializer\SerializableClassMapper;
use RemiSan\Serializer\Serializer;
use RemiSan\Serializer\Test\Mock\Serializable;

class SerializerTest extends \PHPUnit_Framework_TestCase
{
    /** @var SerializableClassMapper */
    private $classMapper;

    /** @var HydratorFactory */
    private $hydratorFactory;

    /** @var DataFormatter */
    private $dataFormatter;

    /** @var InstantiatorInterface */
    private $instantiator;

    public function setUp()
    {
        $this->classMapper = new DefaultMapper(new DefaultNameExtractor());
        $this->classMapper->register(Serializable::class);
        $this->hydratorFactory = new HydratorFactory(__DIR__ . DIRECTORY_SEPARATOR . 'cache');
        $this->dataFormatter = new FlatFormatter();
        $this->instantiator = new Instantiator();
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
            $this->instantiator,
            true
        );

        $object = new Serializable(new Serializable(['a', 'b']));

        $serialized = $serializer->serialize($object);

        $this->assertEquals(
            [
                'foo' => 'foo',
                'bar' => 'bar',
                'baz' => [
                    'foo' => 'foo',
                    'bar' => 'bar',
                    'baz' => ['a', 'b'],
                    '_metadata' => [
                        'name' => 'RemiSan\Serializer\Test\Mock\Serializable'
                    ]
                ],
                '_metadata' => [
                    'name' => 'RemiSan\Serializer\Test\Mock\Serializable'
                ]
            ],
            $serialized
        );
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
            $this->instantiator,
            true
        );

        $serialized = [
            'foo' => 'foo',
            'bar' => 'bar',
            'baz' => [
                'foo' => 'foo',
                'bar' => 'bar',
                'baz' => ['a', 'b'],
                '_metadata' => [
                    'name' => 'RemiSan\Serializer\Test\Mock\Serializable'
                ]
            ],
            '_metadata' => [
                'name' => 'RemiSan\Serializer\Test\Mock\Serializable'
            ]
        ];

        $deserialized = $serializer->deserialize($serialized);

        $this->assertEquals(
            new Serializable(new Serializable(['a', 'b'])),
            $deserialized
        );

        $this->assertTrue(true);
    }
}
