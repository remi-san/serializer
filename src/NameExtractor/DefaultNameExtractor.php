<?php
namespace RemiSan\Serializer\NameExtractor;

use RemiSan\Serializer\SerializableClassNameExtractor;

class DefaultNameExtractor implements SerializableClassNameExtractor
{
    /**
     * @param  string $class
     * @return string
     */
    public function extractName($class)
    {
        return $class;
    }

    /**
     * @param  string $class
     * @return bool
     */
    public function canExtractName($class)
    {
        return true;
    }
}
