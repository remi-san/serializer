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
     * @var bool
     */
    private $generateProxies;

    /**
     * Constructor.
     *
     * @param string $cacheDir
     * @param bool   $generateProxies
     */
    public function __construct($cacheDir, $generateProxies = false)
    {
        $this->cacheDir = $cacheDir;
        $this->generateProxies = $generateProxies;
    }

    /**
     * Gets an hydrator instance for the given class.
     *
     * @param string $fqcn
     *
     * @return HydratorInterface
     */
    public function getHydrator($fqcn)
    {
        $hydratorClass = $this->getHydratorClassName($fqcn);

        return new $hydratorClass();
    }

    /**
     * Gets the hydrator class name.
     *
     * @param string $fqcn
     *
     * @return string
     */
    public function getHydratorClassName($fqcn)
    {
        $config = new Configuration($fqcn);
        $config->setAutoGenerateProxies($this->generateProxies);
        $config->setGeneratedClassesTargetDir($this->cacheDir);

        return $config->createFactory()->getHydratorClass();
    }
}
