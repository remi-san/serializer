<?php

namespace RemiSan\Serializer\Test;

use Doctrine\Instantiator\Instantiator;
use Doctrine\Instantiator\InstantiatorInterface;
use RemiSan\Serializer\CustomSerializer\DateTimeCustomSerializer;
use RemiSan\Serializer\CustomSerializer\TimeZoneCustomSerializer;
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
        $this->classMapper->register(\DateTime::class);
        $this->classMapper->register(\DateTimeImmutable::class);
        $this->classMapper->register(\DateTimeZone::class);
        $this->hydratorFactory = new HydratorFactory(__DIR__ . DIRECTORY_SEPARATOR . 'cache', true);
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
            $this->instantiator
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
    public function itShouldSerializeUsingCustomSerializerForDateTime()
    {
        $serializer = new Serializer(
            $this->classMapper,
            $this->hydratorFactory,
            $this->dataFormatter,
            $this->instantiator
        );
        $serializer->addCustomSerializer(new DateTimeCustomSerializer());
        $serializer->addCustomSerializer(new TimeZoneCustomSerializer());

        $object = \DateTime::createFromFormat('U', 1469787919, new \DateTimeZone('+00:00'));

        $serialized = $serializer->serialize($object);

        $this->assertEquals(
            [
                1469787919,
                [
                    '+00:00',
                    '_metadata' => [
                        'name' => 'DateTimeZone'
                    ]
                ],
                '_metadata' => [
                    'name' => 'DateTime'
                ]
            ],
            $serialized
        );
    }

    /**
     * @test
     */
    public function itShouldSerializeUsingCustomSerializerForDateTimeImmutable()
    {
        $serializer = new Serializer(
            $this->classMapper,
            $this->hydratorFactory,
            $this->dataFormatter,
            $this->instantiator
        );
        $serializer->addCustomSerializer(new DateTimeCustomSerializer());
        $serializer->addCustomSerializer(new TimeZoneCustomSerializer());

        $object = \DateTimeImmutable::createFromFormat('U', 1469787919, new \DateTimeZone('+00:00'));

        $serialized = $serializer->serialize($object);

        $this->assertEquals(
            [
                1469787919,
                [
                    '+00:00',
                    '_metadata' => [
                        'name' => 'DateTimeZone'
                    ]
                ],
                '_metadata' => [
                    'name' => 'DateTimeImmutable'
                ]
            ],
            $serialized
        );
    }

    /**
     * @test
     */
    public function itShouldThrowAnExceptionWhenTryingToSerializeAPrimitive()
    {
        $serializer = new Serializer(
            $this->classMapper,
            $this->hydratorFactory,
            $this->dataFormatter,
            $this->instantiator
        );
        
        $this->setExpectedException(\InvalidArgumentException::class);

        $serializer->serialize('a');
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
            $this->instantiator
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

    /**
     * @test
     */
    public function itShouldDeserializeUsingCustomSerializerForDateTime()
    {
        $serializer = new Serializer(
            $this->classMapper,
            $this->hydratorFactory,
            $this->dataFormatter,
            $this->instantiator
        );
        $serializer->addCustomSerializer(new DateTimeCustomSerializer());
        $serializer->addCustomSerializer(new TimeZoneCustomSerializer());

        $serialized = [
            1469787919,
            [
                '+00:00',
                '_metadata' => [
                    'name' => 'DateTimeZone'
                ]
            ],
            '_metadata' => [
                'name' => 'DateTime'
            ]
        ];

        $object = $serializer->deserialize($serialized);

        $this->assertEquals(
            $object,
            \DateTime::createFromFormat('U', 1469787919, new \DateTimeZone('+00:00'))
        );
    }

    /**
     * @test
     */
    public function itShouldDeserializeUsingCustomSerializerForDateTimeImmutable()
    {
        $serializer = new Serializer(
            $this->classMapper,
            $this->hydratorFactory,
            $this->dataFormatter,
            $this->instantiator
        );
        $serializer->addCustomSerializer(new DateTimeCustomSerializer());
        $serializer->addCustomSerializer(new TimeZoneCustomSerializer());

        $serialized = [
            1469787919,
            [
                '+00:00',
                '_metadata' => [
                    'name' => 'DateTimeZone'
                ]
            ],
            '_metadata' => [
                'name' => 'DateTimeImmutable'
            ]
        ];

        $object = $serializer->deserialize($serialized);

        $this->assertEquals(
            $object,
            \DateTimeImmutable::createFromFormat('U', 1469787919, new \DateTimeZone('+00:00'))
        );
    }
}
