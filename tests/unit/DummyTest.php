<?php
namespace TwitterHangman\Test;

class DummyTest extends \PHPUnit_Framework_TestCase
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
