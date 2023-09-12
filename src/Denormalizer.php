<?php

namespace FileToObject;

use FileToObject\Normalizer\NodeDenormalizer;
use FileToObject\Util\ReflectionCache;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;

class Denormalizer
{
    public function __construct(protected ReflectionCache $reflections) {
    }

    public function denormalize(array $data, string $type)
    {
        $typeExtractors = [new PhpDocExtractor(), new ReflectionExtractor()];
        $extractor = new PropertyInfoExtractor([], $typeExtractors);
        $nodeDenormalizer = new NodeDenormalizer(
            $this->reflections,
            null,
            null,
            null,
            $extractor
        );

        $normalizers = [
            new DateTimeNormalizer(),
            new ArrayDenormalizer,
            $nodeDenormalizer
        ];

        $serializer = new Serializer($normalizers);

        return $serializer->denormalize($data, $type);
    }
}
