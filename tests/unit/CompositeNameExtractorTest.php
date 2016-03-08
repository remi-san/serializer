<?php

namespace RemiSan\Serializer\Test;

class CompositeNameExtractorTest extends \PHPUnit_Framework_TestCase
{
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
}
