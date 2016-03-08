<?php

namespace RemiSan\Serializer;

interface DataFormatter
{
    /**
     * @param string $name
     * @param array  $payload
     *
     * @return array
     */
    public function format($name, array $payload);

    /**
     * @param array $serializedObject
     *
     * @return array
     */
    public function getNameAndPayload(array $serializedObject);

    /**
     * @param array $serializedObject
     *
     * @return bool
     */
    public function isSerializedObject(array $serializedObject);
}
