<?php

namespace RemiSan\Serializer;

use Doctrine\Instantiator\InstantiatorInterface;
use RemiSan\Serializer\Hydrator\HydratorFactory;

class Serializer
{
    /** @var SerializableClassMapper */
    private $classMapper;

    /** @var HydratorFactory */
    private $hydratorFactory;

    /** @var DataFormatter */
    private $dataFormatter;

    /** @var InstantiatorInterface */
    private $instantiator;

    /**
     * Constructor.
     *
     * @param SerializableClassMapper $classMapper
     * @param HydratorFactory         $hydratorFactory
     * @param DataFormatter           $dataFormatter
     * @param InstantiatorInterface   $instantiator
     */
    public function __construct(
        SerializableClassMapper $classMapper,
        HydratorFactory $hydratorFactory,
        DataFormatter $dataFormatter,
        InstantiatorInterface $instantiator
    ) {
        $this->classMapper = $classMapper;
        $this->hydratorFactory = $hydratorFactory;
        $this->dataFormatter = $dataFormatter;
        $this->instantiator = $instantiator;
    }

    /**
     * @param mixed $object
     *
     * @return array
     */
    public function serialize($object)
    {
        if (!(is_array($object) || is_object($object))) {
            throw new \InvalidArgumentException();
        }

        return $this->innerSerialize($object);
    }

    /**
     * @param mixed $object
     *
     * @return array
     */
    private function innerSerialize($object)
    {
        if (is_array($object)) {
            $serializedArray = [];
            foreach ($object as $key => $value) {
                $serializedArray[$key] = $this->innerSerialize($value);
            }

            return $serializedArray;
        } elseif (is_object($object)) {
            return $this->serializeObject($object);
        } else {
            return $object;
        }
    }

    /**
     * @param object $object
     *
     * @return array
     */
    private function serializeObject($object)
    {
        $payload = $this->hydratorFactory->getHydrator(get_class($object))->extract($object);

        $curatedPayload = [];
        foreach ($payload as $key => $value) {
            $curatedPayload[$key] = $this->innerSerialize($value);
        }

        return $this->dataFormatter->format($this->classMapper->extractName(get_class($object)), $curatedPayload);
    }

    /**
     * @param array $serializedObject
     *
     * @return mixed
     */
    public function deserialize(array $serializedObject)
    {
        return $this->recursiveDeserialize($serializedObject);
    }

    /**
     * @param mixed $serializedObject
     *
     * @return mixed
     */
    private function recursiveDeserialize($serializedObject)
    {
        if (!is_array($serializedObject)) {
            return $serializedObject;
        } elseif ($this->dataFormatter->isSerializedObject($serializedObject)) {
            return $this->deserializeObject($serializedObject);
        } else {
            $deserializedArray = [];
            foreach ($serializedObject as $key => $value) {
                $deserializedArray[$key] = $this->recursiveDeserialize($value);
            }

            return $deserializedArray;
        }
    }

    /**
     * @param array $serializedObject
     *
     * @return object
     */
    private function deserializeObject(array $serializedObject)
    {
        list($name, $payload) = $this->dataFormatter->getNameAndPayload($serializedObject);

        $curatedPayload = [];
        foreach ($payload as $key => $value) {
            $curatedPayload[$key] = $this->recursiveDeserialize($value);
        }

        $objectFqcn = $this->classMapper->getClassName($name);
        $object = $this->instantiator->instantiate($objectFqcn);

        return $this->hydratorFactory
            ->getHydrator($objectFqcn)
            ->hydrate($curatedPayload, $object);
    }
}
