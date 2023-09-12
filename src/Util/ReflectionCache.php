<?php

namespace FileToObject\Util;

class ReflectionCache
{
    private $reflectionClassCache = [];

    public function getClassReflection(string $class): ReflectionClassExt
    {
        if (!isset($this->reflectionClassCache[$class])) {
            $this->reflectionClassCache[$class] = new ReflectionClassExt($class);
        }

        return $this->reflectionClassCache[$class];
    }
    
    public function getReflectedObject(object $object) {
        return new ReflectedObject($object, $this);
    }
}
