<?php

namespace RemiSan\Serializer\Test;

use RemiSan\Serializer\Formatter\FlatFormatter;

class FlatFormatterTest extends \PHPUnit_Framework_TestCase
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
        $formatter = new FlatFormatter();

        $data = [
            'foo' => 'bar'
        ];

        $formattedData = $formatter->format('baz', $data);

        $this->assertEquals('baz', $formattedData['_metadata']['name']);
        $this->assertEquals('bar', $formattedData['foo']);
        $this->assertEquals(2, count($formattedData));
    }

    /**
     * @test
     */
    public function itShouldReturnFalseWhenProvidedBadFormattedSerializedObject()
    {
        $formatter = new FlatFormatter();

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
        $formatter = new FlatFormatter();

        $data = [
            'foo' => 'bar',
            '_metadata' => ['name' => 'baz']
        ];

        $this->assertTrue($formatter->isSerializedObject($data));
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionWhenProvidedBadFormattedSerializedObject()
    {
        $formatter = new FlatFormatter();

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
        $formatter = new FlatFormatter();

        $data = [
            'foo' => 'bar',
            '_metadata' => ['name' => 'baz']
        ];

        list($name, $payload) = $formatter->getNameAndPayload($data);

        $this->assertEquals('baz', $name);
        $this->assertEquals(['foo' => 'bar'], $payload);
    }
}
