<?php

namespace RemiSan\Serializer\Test\Mock;

use League\Tactician\Plugins\NamedCommand\NamedCommand;

class NamedSerializableCommand implements NamedCommand
{
    const NAME = 'name';

    /**
     * Returns the name of the command
     *
     * @return string
     */
    public function getCommandName()
    {
        return self::NAME;
    }
}
