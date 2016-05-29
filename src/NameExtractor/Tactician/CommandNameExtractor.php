<?php

namespace RemiSan\Serializer\NameExtractor\Tactician;

use League\Tactician\Plugins\NamedCommand\NamedCommand;
use RemiSan\Serializer\SerializableClassNameExtractor;

class CommandNameExtractor implements SerializableClassNameExtractor
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
        return $reflection->implementsInterface(NamedCommand::class) && defined($class.'::NAME');
    }
}
