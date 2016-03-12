<?php

namespace RemiSan\Serializer\Hydrator;

use GeneratedHydrator\Configuration;
use Zend\Hydrator\HydratorInterface;

class HydratorFactory
{
    /**
     * @var string
     */
    private $cacheDir;

    /**
     * Constructor.
     *
     * @param string $cacheDir
     */
    public function __construct($cacheDir)
    {
        $this->cacheDir = $cacheDir;
    }

    /**
     * Gets an hydrator instance for the given class.
     *
     * @param string $fqcn
     * @param bool   $generateProxies
     *
     * @return HydratorInterface
     */
    public function getHydrator($fqcn, $generateProxies = false)
    {
        $hydratorClass = $this->getHydratorClassName($fqcn, $generateProxies);

        return new $hydratorClass();
    }

    /**
     * Gets the hydrator class name.
     *
     * @param string $fqcn
     * @param bool   $generateProxies
     *
     * @return string
     */
    public function getHydratorClassName($fqcn, $generateProxies = false)
    {
        $config = new Configuration($fqcn);
        $config->setAutoGenerateProxies($generateProxies);
        $config->setGeneratedClassesTargetDir($this->cacheDir);

        return $config->createFactory()->getHydratorClass();
    }
}
