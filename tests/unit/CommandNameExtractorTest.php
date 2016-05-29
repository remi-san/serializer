<?php

namespace RemiSan\Serializer\Test;

use RemiSan\Serializer\NameExtractor\Tactician\CommandNameExtractor;
use RemiSan\Serializer\Test\Mock\NamedSerializable;
use RemiSan\Serializer\Test\Mock\NamedSerializableCommand;

class CommandNameExtractorTest extends \PHPUnit_Framework_TestCase
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
        $nameExtractor = new CommandNameExtractor();
        $this->assertFalse($nameExtractor->canExtractName(\stdClass::class));
    }

    /**
     * @test
     */
    public function itCannotExtractNameIfItIsNotACommand()
    {
        $nameExtractor = new CommandNameExtractor();
        $this->assertFalse($nameExtractor->canExtractName(NamedSerializable::class));
    }

    /**
     * @test
     */
    public function itCanExtractNameIfItIsACommandWithANameConst()
    {
        $nameExtractor = new CommandNameExtractor();
        $this->assertTrue($nameExtractor->canExtractName(NamedSerializableCommand::class));
    }

    /**
     * @test
     */
    public function itShouldThrowAnExceptionIfNameCannotBeExtracted()
    {
        $nameExtractor = new CommandNameExtractor();

        $this->setExpectedException(\InvalidArgumentException::class);

        $nameExtractor->extractName(\stdClass::class);
    }

    /**
     * @test
     */
    public function itShouldReturnTheNameIfItCanBeExtracted()
    {
        $nameExtractor = new CommandNameExtractor();
        $name = $nameExtractor->extractName(NamedSerializableCommand::class);

        $this->assertEquals(NamedSerializableCommand::NAME, $name);
    }
}
