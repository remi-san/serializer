<?php

namespace RemiSan\Serializer\CustomSerializer;

interface CustomSerializer
{
    /**
     * Serialize the object
     *
     * @param object $object
     *
     * @return array
     */
    public function serialize($object);

    /**
     * Deserialize the object
     *
     * @param array  $serialized
     * @param string $fqcn       the fully qualified class name
     *
     * @return object
     */
    public function deserialize(array $serialized, $fqcn);

    /**
     * Can the custom serializer (de)serialize the objects of this class
     *
     * @param string $className
     *
     * @return boolean
     */
    public function canHandle($className);
}
