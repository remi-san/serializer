<?php

namespace RemiSan\Serializer\Test;

use RemiSan\Serializer\CustomSerializer\DateTimeCustomSerializer;

class DateTimeCustomSerializerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldBeAbleToHandleADateTime()
    {
        $customSerializer = new DateTimeCustomSerializer();

        $this->assertTrue($customSerializer->canHandle(\DateTime::class));
    }

    /**
     * @test
     */
    public function itShouldBeAbleToHandleADateTimeImmutable()
    {
        $customSerializer = new DateTimeCustomSerializer();

        $this->assertTrue($customSerializer->canHandle(\DateTimeImmutable::class));
    }

    /**
     * @test
     */
    public function itShouldNotBeAbleToHandleADifferentObject()
    {
        $customSerializer = new DateTimeCustomSerializer();

        $this->assertFalse($customSerializer->canHandle('object'));
    }

    /**
     * @test
     */
    public function itShouldSerializeADateTime()
    {
        $customSerializer = new DateTimeCustomSerializer();

        $timeZone = new \DateTimeZone('+00:00');
        $object = \DateTime::createFromFormat('U', 1469787919, $timeZone);

        $serialized = $customSerializer->serialize($object);

        $this->assertEquals(
            [
                1469787919,
                $timeZone
            ],
            $serialized
        );
    }

    /**
     * @test
     */
    public function itShouldSerializeADateTimeImmutable()
    {
        $customSerializer = new DateTimeCustomSerializer();

        $timeZone = new \DateTimeZone('+00:00');
        $object = \DateTimeImmutable::createFromFormat('U', 1469787919, $timeZone);

        $serialized = $customSerializer->serialize($object);

        $this->assertEquals(
            [
                1469787919,
                $timeZone
            ],
            $serialized
        );
    }

    /**
     * @test
     */
    public function itShouldNotSerializeADifferentObject()
    {
        $customSerializer = new DateTimeCustomSerializer();

        $this->setExpectedException(\InvalidArgumentException::class);

        $customSerializer->serialize(new \stdClass());
    }

    /**
     * @test
     */
    public function itShouldDeserializeADateTime()
    {
        $customSerializer = new DateTimeCustomSerializer();

        $serialized = [
            1469787919,
            new \DateTimeZone('+00:00')
        ];

        $object = $customSerializer->deserialize($serialized, \DateTime::class);

        $this->assertEquals(
            $object,
            \DateTime::createFromFormat('U', 1469787919, new \DateTimeZone('+00:00'))
        );
    }

    /**
     * @test
     */
    public function itShouldDeserializeADateTimeImmutable()
    {
        $customSerializer = new DateTimeCustomSerializer();

        $serialized = [
            1469787919,
            new \DateTimeZone('+00:00')
        ];

        $object = $customSerializer->deserialize($serialized, \DateTimeImmutable::class);

        $this->assertEquals(
            $object,
            \DateTimeImmutable::createFromFormat('U', 1469787919, new \DateTimeZone('+00:00'))
        );
    }

    /**
     * @test
     */
    public function itShouldNotDeserializeADifferentObject()
    {
        $customSerializer = new DateTimeCustomSerializer();

        $this->setExpectedException(\InvalidArgumentException::class);

        $customSerializer->deserialize([], 'object');
    }
}
