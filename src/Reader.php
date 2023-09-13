<?php

namespace FileToObject;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;

class Reader
{
    public function __construct()
    {
        $this->container = new ContainerBuilder();
    }

    public function fileToObject(string $filePath, string $rootClassPath): object
    {
        $data = Yaml::parseFile($filePath);
        return $this->dataToObject($data, $rootClassPath);
    }

    public function dataToObject(array $data, string $rootClassPath): object
    {
        /** @var Denormalizer */
        $denormalizer = $this->container->get(Denormalizer::class);
        return $denormalizer->denormalize($data, $rootClassPath);
    }
}
