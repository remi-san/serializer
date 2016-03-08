<?php
namespace RemiSan\Serializer;

use PhpParser\Node\Name;
use RemiSan\Serializer\Hydrator\HydratorFactory;

class Serializer
{
    /**
     * @var SerializableClassMapper
     */
    private $classMapper;

    /**
     * @var HydratorFactory
     */
    private $hydratorFactory;

    /**
     * @var DataFormatter
     */
    private $dataFormatter;

    /**
     * Constructor.
     *
     * @param SerializableClassMapper $classMapper
     * @param HydratorFactory         $hydratorFactory
     */
    public function __construct(
        SerializableClassMapper $classMapper,
        HydratorFactory $hydratorFactory
    ) {
        $this->classMapper = $classMapper;
        $this->hydratorFactory = $hydratorFactory;
    }


    /**
     * @param  mixed $object
     * @return array
     */
    public function serialize($object)
    {
        if (is_array($object)) {
            $serializedArray = [];
            foreach ($object as $key => $value) {
                $serializedArray[$key] = $this->serialize($value);
            }
            return $serializedArray;
        } elseif (is_object($object)) {
            return $this->serializeObject($object);
        } else {
            return $object;
        }
    }

    /**
     * @param  object $object
     * @return array
     */
    private function serializeObject($object)
    {
        $payload = $this->hydratorFactory->getHydrator(get_class($object))->extract($object);

        $curatedPayload = [];
        foreach ($payload as $key => $value) {
            $curatedPayload[$key] = $this->serialize($value);
        }

        return $this->dataFormatter->format($this->classMapper->extractName(get_class($object)), $curatedPayload);
    }

    /**
     * @param  mixed $serializedObject
     * @return object|array
     */
    public function deserialize($serializedObject)
    {
        if (!is_array($serializedObject)) {
            return $serializedObject;
        } elseif ($this->dataFormatter->isSerializedObject($serializedObject)) {
            return $this->deserializeObject($serializedObject);
        } else {
            $deserializedArray = [];
            foreach ($serializedObject as $key => $value) {
                if (!is_array($value)) {
                    throw new \InvalidArgumentException();
                }
                $deserializedArray[$key] = $this->deserialize($value);
            }
            return $deserializedArray;
        }
    }

    /**
     * @param  array $serializedObject
     * @return object
     */
    private function deserializeObject(array $serializedObject)
    {
        $this->checkSerializedObject($serializedObject);

        list($name, $payload) = $this->dataFormatter->getNameAndPayload($serializedObject);

        $curatedPayload = [];
        foreach ($payload as $key => $value) {
            $curatedPayload[$key] = $this->deserialize($value);
        }

        $objectFqcn = $this->classMapper->getClassName($name);
        $object = new $objectFqcn();

        return $this->hydratorFactory->getHydrator($objectFqcn)->hydrate($curatedPayload, $object);
    }

    /**
     * @param array $serializedObject
     */
    private function checkSerializedObject(array $serializedObject)
    {
        if (!$this->dataFormatter->isSerializedObject($serializedObject)) {
            throw new \InvalidArgumentException();
        }
    }
}
