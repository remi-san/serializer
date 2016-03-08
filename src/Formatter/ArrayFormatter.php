<?php

namespace RemiSan\Serializer\Formatter;

use RemiSan\Serializer\DataFormatter;

class ArrayFormatter implements DataFormatter
{
    /**
     * @param string $name
     * @param array  $payload
     *
     * @return array
     */
    public function format($name, array $payload)
    {
        return [
            'name' => $name,
            'payload' => $payload
        ];
    }

    /**
     * @param array $serializedObject
     *
     * @return array
     */
    public function getNameAndPayload(array $serializedObject)
    {
        return [
            $serializedObject['name'],
            $serializedObject['payload']
        ];
    }

    /**
     * @param array $serializedObject
     *
     * @return bool
     */
    public function isSerializedObject(array $serializedObject)
    {
        return isset($serializedObject['name']) && isset($serializedObject['payload']);
    }
}
