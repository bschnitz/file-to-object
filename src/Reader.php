<?php

namespace FileToObject;

use DI\Container;
use Symfony\Component\Yaml\Yaml;

class Reader
{
    public function __construct()
    {
        $this->container = new Container();
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
