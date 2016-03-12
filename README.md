# serializer

[![Author](https://img.shields.io/badge/author-@RemiSan-blue.svg?style=flat-square)](https://twitter.com/RemiSan)
[![Build Status](https://img.shields.io/travis/remi-san/serializer/master.svg?style=flat-square)](https://travis-ci.org/remi-san/serializer)
[![Quality Score](https://img.shields.io/scrutinizer/g/remi-san/serializer.svg?style=flat-square)](https://scrutinizer-ci.com/g/remi-san/serializer)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Packagist Version](https://img.shields.io/packagist/v/remi-san/serializer.svg?style=flat-square)](https://packagist.org/packages/remi-san/serializer)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/remi-san/serializer.svg?style=flat-square)](https://scrutinizer-ci.com/g/remi-san/serializer/code-structure)

A universal, configless PHP serializer for all purpose

Usage
-----

```php

    $classMapper = new RemiSan\Serializer\Mapper\DefaultMapper(
        new RemiSan\Serializer\NameExtractor\DefaultNameExtractor()
    );
    $classMapper->register(RemiSan\Serializer\Sample\MySampleClass::class);
    
    $serializer = new RemiSan\Serializer\Serializer(
        $classMapper,
        new RemiSan\Serializer\Hydrator\HydratorFactory(__DIR__ . '/proxies', true),
        new RemiSan\Serializer\Formatter\FlatFormatter(),
        new Doctrine\Instantiator\Instantiator()
    );
    
    $object = new MySampleClass(new MySampleClass());
    $serialized = $serializer->serialize($object);
    $deserialized = $serializer->deserialize($serialized);
    
```
