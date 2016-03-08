<?php

namespace RemiSan\Serializer\Test;

use RemiSan\Serializer\Formatter\ArrayFormatter;

class ArrayFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldReturnAnArrayOfArrayWhenFormatting()
    {
        $formatter = new ArrayFormatter();

        $data = [
            'foo' => 'bar'
        ];

        $formattedData = $formatter->format('baz', $data);

        $this->assertEquals('baz', $formattedData['name']);
        $this->assertEquals($data, $formattedData['payload']);
    }

    /**
     * @test
     */
    public function itShouldReturnFalseWhenProvidedBadFormattedSerializedObject()
    {
        $formatter = new ArrayFormatter();

        $data = [
            'foo' => 'bar'
        ];

        $this->assertFalse($formatter->isSerializedObject($data));
    }

    /**
     * @test
     */
    public function itShouldReturnTrueWhenProvidedWellFormattedSerializedObject()
    {
        $formatter = new ArrayFormatter();

        $data = [
            'name' => 'baz',
            'payload' => ['foo' => 'bar']
        ];

        $this->assertTrue($formatter->isSerializedObject($data));
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionWhenProvidedBadFormattedSerializedObject()
    {
        $formatter = new ArrayFormatter();

        $data = [
            'foo' => 'bar'
        ];

        $this->setExpectedException(\InvalidArgumentException::class);

        $formatter->getNameAndPayload($data);
    }

    /**
     * @test
     */
    public function itShouldReturnNameAndPayloadWhenProvidedWellFormattedSerializedObject()
    {
        $formatter = new ArrayFormatter();

        $data = [
            'name' => 'baz',
            'payload' => ['foo' => 'bar']
        ];

        list($name, $payload) = $formatter->getNameAndPayload($data);

        $this->assertEquals('baz', $name);
        $this->assertEquals(['foo' => 'bar'], $payload);
    }
}
