<?php

namespace RemiSan\Serializer;

interface SerializableClassMapper
{
    /**
     * @param string[] $classes
     */
    public function registerMultiple(array $classes);

    /**
     * @param string $class
     */
    public function register($class);

    /**
     * @param string $class
     *
     * @return string
     */
    public function extractName($class);

    /**
     * @param string $name
     *
     * @return string
     */
    public function getClassName($name);
}
