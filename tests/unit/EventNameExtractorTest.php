<?php

namespace RemiSan\Serializer\Test;

use RemiSan\Serializer\NameExtractor\Event\EventNameExtractor;
use RemiSan\Serializer\Test\Mock\NamedEvent;
use RemiSan\Serializer\Test\Mock\NamedSerializable;

class EventNameExtractorTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itCannotExtractNameIfThereIsNoNameConst()
    {
        $nameExtractor = new EventNameExtractor();
        $this->assertFalse($nameExtractor->canExtractName(\stdClass::class));
    }

    /**
     * @test
     */
    public function itCannotExtractNameIfItIsNotAnEvent()
    {
        $nameExtractor = new EventNameExtractor();
        $this->assertFalse($nameExtractor->canExtractName(NamedSerializable::class));
    }

    /**
     * @test
     */
    public function itCanExtractNameIfItIsAnEventWithANameConst()
    {
        $nameExtractor = new EventNameExtractor();
        $this->assertTrue($nameExtractor->canExtractName(NamedEvent::class));
    }

    /**
     * @test
     */
    public function itShouldThrowAnExceptionIfNameCannotBeExtracted()
    {
        $nameExtractor = new EventNameExtractor();

        $this->setExpectedException(\InvalidArgumentException::class);

        $nameExtractor->extractName(\stdClass::class);
    }

    /**
     * @test
     */
    public function itShouldReturnTheNameIfItCanBeExtracted()
    {
        $nameExtractor = new EventNameExtractor();
        $name = $nameExtractor->extractName(NamedEvent::class);

        $this->assertEquals(NamedEvent::NAME, $name);
    }
}
