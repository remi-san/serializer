<?php
require_once __DIR__ . '/../vendor/autoload.php';

$classMapper = new \RemiSan\Serializer\Mapper\DefaultMapper(
    new RemiSan\Serializer\NameExtractor\DefaultNameExtractor()
);
$classMapper->register(\RemiSan\Serializer\Sample\MySampleClass::class);

$serializer = new \RemiSan\Serializer\Serializer(
    $classMapper,
    new \RemiSan\Serializer\Hydrator\HydratorFactory(__DIR__ . '/proxies'),
    new \RemiSan\Serializer\Formatter\ArrayFormatter(),
    true
);

$object = new \RemiSan\Serializer\Sample\MySampleClass(new \RemiSan\Serializer\Sample\MySampleClass());
$serialized = $serializer->serialize($object);
$deserialized = $serializer->deserialize($serialized);
