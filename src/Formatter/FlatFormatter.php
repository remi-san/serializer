<?php

namespace RemiSan\Serializer\Formatter;

use RemiSan\Serializer\DataFormatter;

class FlatFormatter implements DataFormatter
{
    /**
     * @param string $name
     * @param array  $payload
     *
     * @return array
     */
    public function format($name, array $payload)
    {
        $payload['_metadata'] = array('name' => $name);

        return $payload;
    }

    /**
     * @param array $serializedObject
     *
     * @return array
     */
    public function getNameAndPayload(array $serializedObject)
    {
        if (!$this->isSerializedObject($serializedObject)) {
            throw new \InvalidArgumentException();
        }

        $name = $serializedObject['_metadata']['name'];
        $payload = $serializedObject;
        unset($payload['_metadata']);

        return [
            $name,
            $payload,
        ];
    }

    /**
     * @param array $serializedObject
     *
     * @return bool
     */
    public function isSerializedObject(array $serializedObject)
    {
        return isset($serializedObject['_metadata'])
            && is_array($serializedObject['_metadata'])
            && isset($serializedObject['_metadata']['name']);
    }
}
