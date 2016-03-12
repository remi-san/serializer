# Serializer

[![Author](https://img.shields.io/badge/author-@RemiSan-blue.svg?style=flat-square)](https://twitter.com/RemiSan)
[![Build Status](https://img.shields.io/travis/remi-san/serializer/master.svg?style=flat-square)](https://travis-ci.org/remi-san/serializer)
[![Quality Score](https://img.shields.io/scrutinizer/g/remi-san/serializer.svg?style=flat-square)](https://scrutinizer-ci.com/g/remi-san/serializer)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Packagist Version](https://img.shields.io/packagist/v/remi-san/serializer.svg?style=flat-square)](https://packagist.org/packages/remi-san/serializer)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/remi-san/serializer.svg?style=flat-square)](https://scrutinizer-ci.com/g/remi-san/serializer/code-structure)

Based on [**GeneratedHydrator**](https://github.com/Ocramius/GeneratedHydrator),
it serializes recursively, adding metadata to the generated array in order to be
able to deserialize an object without knowing its type beforehand.

Installation
------------

**Serializer** can be found on [Packagist](https://packagist.org/packages/remi-san/serializer).
The recommended way to install **Serializer** is through [composer](http://getcomposer.org).

Run the following on the command line:

```bash
composer require remi-san/serializer=@stable
```

And install dependencies:

```bash
composer install
```

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

Command usage
-------------

When installing through **composer**, a **CLI command** is also made available
(in `vendor/bin/` or `bin/` according to your `composer.json`):

```bash
bin/serializer generate:cache <cache-path> <fully-qualified-class-name>
```

It will write the cached version of the **hydrator** for the requested
class in the path you provided.

You'll have to generate **cached files** for all your serializable classes when
running in production (with the `generateProxies` option of the
`HydratorFactory` set to `false).

You'll also have to make the **autoloader** aware of your **hydrators** by
adding the following to your `composer.json`:

```json
{
    "autoload": {
        "classmap": [
            "/path/to/cache-dir"
        ]
    }
}
```

Details
-------

To be instantiated, the `Serializer` needs a `SerializableClassMapper`, a `HydratorFactory`,
a `DataFormatter` and an `Instantiator`.

`SerializableClassMapper` is used to register the classes the serializer will be able to (de-)serialize.
It needs a `SerializableClassNameExtractor` which will be able to normalize the name of the class the way you want it.

`HydratorFactory` will retrieve the hydrators needed to deserialize data. It needs the path
to the `cache directory` and whether or not, it should generate the proxies on runtime.

`DataFormatter` will provide the way the serialized array will be formatted (provided implementations
allow it to format it as a 2-level array or a flat one with a `_metadata` key).

`Instantiator` will allow to instantiate an object without the constructor based on the fully
qualified class name of the requested object.
