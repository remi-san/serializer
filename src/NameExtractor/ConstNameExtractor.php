<?php

namespace RemiSan\Serializer\NameExtractor;

use RemiSan\Serializer\SerializableClassNameExtractor;

class ConstNameExtractor implements SerializableClassNameExtractor
{
    /**
     * @param  string $class
     * @return string
     */
    public function extractName($class)
    {
        if (! $this->canExtractName($class)) {
            throw new \InvalidArgumentException();
        }

        return $class::NAME;
    }

    /**
     * @param  string $class
     * @return bool
     */
    public function canExtractName($class)
    {
        return defined($class.'::NAME');
    }
}
