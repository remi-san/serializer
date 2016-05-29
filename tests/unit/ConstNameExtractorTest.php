<?php

namespace RemiSan\Serializer\Test;

use RemiSan\Serializer\NameExtractor\ConstNameExtractor;
use RemiSan\Serializer\Test\Mock\NamedSerializable;

class ConstNameExtractorTest extends \PHPUnit_Framework_TestCase
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
        $nameExtractor = new ConstNameExtractor();
        $this->assertFalse($nameExtractor->canExtractName(\stdClass::class));
    }

    /**
     * @test
     */
    public function itCanExtractNameIfThereIsANameConst()
    {
        $nameExtractor = new ConstNameExtractor();
        $this->assertTrue($nameExtractor->canExtractName(NamedSerializable::class));
    }

    /**
     * @test
     */
    public function itShouldThrowAnExceptionIfNameCannotBeExtracted()
    {
        $nameExtractor = new ConstNameExtractor();

        $this->setExpectedException(\InvalidArgumentException::class);

        $nameExtractor->extractName(\stdClass::class);
    }

    /**
     * @test
     */
    public function itShouldReturnTheNameIfItCanBeExtracted()
    {
        $nameExtractor = new ConstNameExtractor();
        $name = $nameExtractor->extractName(NamedSerializable::class);

        $this->assertEquals(NamedSerializable::NAME, $name);
    }
}
