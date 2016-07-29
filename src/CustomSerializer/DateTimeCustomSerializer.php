<?php

namespace RemiSan\Serializer\CustomSerializer;

class DateTimeCustomSerializer implements CustomSerializer
{
    /**
     * Serialize the object
     *
     * @param object $object
     *
     * @return array|void
     */
    public function serialize($object)
    {
        if (!$this->canHandle(get_class($object))) {
            throw new \InvalidArgumentException();
        }

        return [ $object->getTimestamp(), $object->getTimezone() ];
    }

    /**
     * Deserialize the object
     *
     * @param array  $serialized
     * @param string $fqcn the fully qualified class name
     *
     * @return object
     */
    public function deserialize(array $serialized, $fqcn)
    {
        if (!$this->canHandle($fqcn)) {
            throw new \InvalidArgumentException();
        }

        return  $fqcn::createFromFormat('U', $serialized[0], $serialized[1]);
    }

    /**
     * Can the custom serializer (de)serialize the objects of this class
     *
     * @param string $className
     *
     * @return boolean
     */
    public function canHandle($className)
    {
        return $className === \DateTimeImmutable::class || $className === \DateTime::class;
    }
}
