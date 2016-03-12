<?php

namespace RemiSan\Serializer\Test;

use RemiSan\Serializer\Hydrator\HydratorFactory;
use RemiSan\Serializer\Test\Mock\Serializable;
use Zend\Hydrator\HydratorInterface;

class HydratorFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldReturnAnHydratorClassName()
    {
        $hydratorFactory = new HydratorFactory(__DIR__ . DIRECTORY_SEPARATOR . 'cache');

        $hydratorClassName = $hydratorFactory->getHydratorClassName(Serializable::class, true);

        $this->assertNotNull($hydratorClassName);
        $this->assertTrue(is_subclass_of($hydratorClassName, HydratorInterface::class));
    }

    /**
     * @test
     */
    public function itShouldReturnAnHydratorInstance()
    {
        $hydratorFactory = new HydratorFactory(__DIR__ . DIRECTORY_SEPARATOR . 'cache');

        $hydrator = $hydratorFactory->getHydrator(Serializable::class, true);

        $this->assertInstanceOf(HydratorInterface::class, $hydrator);
    }
}
