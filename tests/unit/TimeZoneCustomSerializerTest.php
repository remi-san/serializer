<?php

namespace RemiSan\Serializer\Test;

use RemiSan\Serializer\CustomSerializer\TimeZoneCustomSerializer;

class TimeZoneCustomSerializerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldBeAbleToHandleATimeZone()
    {
        $customSerializer = new TimeZoneCustomSerializer();

        $this->assertTrue($customSerializer->canHandle(\DateTimeZone::class));
    }

    /**
     * @test
     */
    public function itShouldNotBeAbleToHandleADifferentObject()
    {
        $customSerializer = new TimeZoneCustomSerializer();

        $this->assertFalse($customSerializer->canHandle('object'));
    }

    /**
     * @test
     */
    public function itShouldSerializeATimeZone()
    {
        $customSerializer = new TimeZoneCustomSerializer();

        $timeZone = new \DateTimeZone('+00:00');

        $serialized = $customSerializer->serialize($timeZone);

        $this->assertEquals(
            [
                '+00:00'
            ],
            $serialized
        );
    }

    /**
     * @test
     */
    public function itShouldNotSerializeADifferentObject()
    {
        $customSerializer = new TimeZoneCustomSerializer();

        $this->setExpectedException(\InvalidArgumentException::class);

        $customSerializer->serialize(new \stdClass());
    }

    /**
     * @test
     */
    public function itShouldDeserializeATimeZone()
    {
        $customSerializer = new TimeZoneCustomSerializer();

        $serialized = [
            '+00:00'
        ];

        $object = $customSerializer->deserialize($serialized, \DateTimeZone::class);

        $this->assertEquals(
            $object,
            new \DateTimeZone('+00:00')
        );
    }

    /**
     * @test
     */
    public function itShouldNotDeserializeADifferentObject()
    {
        $customSerializer = new TimeZoneCustomSerializer();

        $this->setExpectedException(\InvalidArgumentException::class);

        $customSerializer->deserialize([], 'object');
    }
}
