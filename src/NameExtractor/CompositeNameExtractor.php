<?php
namespace RemiSan\Serializer\NameExtractor;

use RemiSan\Serializer\SerializableClassNameExtractor;

class CompositeNameExtractor implements SerializableClassNameExtractor
{
    /**
     * @var SerializableClassNameExtractor[]
     */
    private $extractors;

    /**
     * @param SerializableClassNameExtractor $extractor
     */
    public function addExtractor(SerializableClassNameExtractor $extractor)
    {
        $this->extractors[] = $extractor;
    }

    /**
     * @param  string $class
     * @return string
     */
    public function extractName($class)
    {
        foreach ($this->extractors as $extractor) {
            if ($extractor->canExtractName($class)) {
                return $extractor->extractName($class);
            }
        }

        throw new \InvalidArgumentException();
    }

    /**
     * @param  string $class
     * @return bool
     */
    public function canExtractName($class)
    {
        foreach ($this->extractors as $extractor) {
            if ($extractor->canExtractName($class)) {
                return true;
            }
        }

        return false;
    }
}
