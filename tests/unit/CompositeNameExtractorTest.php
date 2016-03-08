<?php

namespace RemiSan\Serializer\Test;

use RemiSan\Serializer\NameExtractor\CompositeNameExtractor;
use RemiSan\Serializer\SerializableClassNameExtractor;
use RemiSan\Serializer\Test\Mock\Serializable;

class CompositeNameExtractorTest extends \PHPUnit_Framework_TestCase
{
    /** @var SerializableClassNameExtractor */
    private $subExtractor;

    public function setUp()
    {
        $this->subExtractor = \Mockery::mock(SerializableClassNameExtractor::class);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function testEntityManagerClosed()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function itShouldReturnSubExtractorValueWhenSubExtractorCanExtract()
    {
        $extractor = new CompositeNameExtractor();

        $this->subExtractor->shouldReceive('extractName')->andReturn('subValue');
        $this->subExtractor->shouldReceive('canExtractName')->andReturn(true);

        $extractor->addExtractor($this->subExtractor);

        $this->assertEquals('subValue', $extractor->extractName(Serializable::class));
    }

    /**
     * @test
     */
    public function itShouldThrowExceptionWhenSubExtractorCantExtract()
    {
        $extractor = new CompositeNameExtractor();

        $this->subExtractor->shouldReceive('canExtractName')->andReturn(false);

        $this->setExpectedException(\InvalidArgumentException::class);

        $extractor->extractName(Serializable::class);
    }

    /**
     * @test
     */
    public function itShouldReturnTrueIfASubExtractorCanExtract()
    {
        $extractor = new CompositeNameExtractor();

        $this->subExtractor->shouldReceive('canExtractName')->andReturn(true);

        $extractor->addExtractor($this->subExtractor);

        $this->assertTrue($extractor->canExtractName(Serializable::class));
    }

    /**
     * @test
     */
    public function itShouldReturnFalseIfNoSubExtractorCanExtract()
    {
        $extractor = new CompositeNameExtractor();

        $this->subExtractor->shouldReceive('canExtractName')->andReturn(false);

        $extractor->addExtractor($this->subExtractor);

        $this->assertFalse($extractor->canExtractName(Serializable::class));
    }
}
