<?php

namespace RemiSan\Serializer\NameExtractor\Event;

use League\Event\EventInterface;
use RemiSan\Serializer\SerializableClassNameExtractor;

class EventNameExtractor implements SerializableClassNameExtractor
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
        $reflection = new \ReflectionClass($class);
        return $reflection->implementsInterface(EventInterface::class) && defined($class.'::NAME');
    }
}
