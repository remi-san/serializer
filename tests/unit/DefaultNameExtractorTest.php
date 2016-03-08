<?php

namespace RemiSan\Serializer\Test;

use RemiSan\Serializer\NameExtractor\DefaultNameExtractor;
use RemiSan\Serializer\Test\Mock\Serializable;

class DefaultNameExtractorTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldReturnClassName()
    {
        $extractor = new DefaultNameExtractor();

        $this->assertEquals(Serializable::class, $extractor->extractName(Serializable::class));
    }

    /**
     * @test
     */
    public function itShouldAlwaysReturnTrue()
    {
        $extractor = new DefaultNameExtractor();

        $this->assertTrue($extractor->canExtractName(Serializable::class));
    }
}
