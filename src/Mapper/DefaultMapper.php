<?php

namespace RemiSan\Serializer\Mapper;

use RemiSan\Serializer\SerializableClassMapper;
use RemiSan\Serializer\SerializableClassNameExtractor;

class DefaultMapper implements SerializableClassMapper
{
    /**
     * @var SerializableClassNameExtractor
     */
    private $nameExtractor;

    /**
     * @var string[]
     */
    private $mapping;

    /**
     * Constructor.
     *
     * @param SerializableClassNameExtractor $nameExtractor
     */
    public function __construct(SerializableClassNameExtractor $nameExtractor)
    {
        $this->nameExtractor = $nameExtractor;
        $this->mapping = [];
    }

    /**
     * @param string[] $classes
     */
    public function registerMultiple(array $classes)
    {
        foreach ($classes as $class) {
            $this->register($class);
        }
    }

    /**
     * @param string $class
     */
    public function register($class)
    {
        $this->mapping[$this->extractName($class)] = $class;
    }

    /**
     * @param string $class
     *
     * @return string
     */
    public function extractName($class)
    {
        return $this->nameExtractor->extractName($class);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function getClassName($name)
    {
        if (!isset($this->mapping[$name])) {
            throw new \InvalidArgumentException(sprintf('Could not find "%s"', $name));
        }

        return $this->mapping[$name];
    }
}
