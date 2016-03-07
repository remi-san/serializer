<?php
namespace RemiSan\Serializer;

interface SerializableClassNameExtractor
{
    /**
     * @param  string $class
     * @return string
     */
    public function extractName($class);

    /**
     * @param  string $class
     * @return bool
     */
    public function canExtractName($class);
}
