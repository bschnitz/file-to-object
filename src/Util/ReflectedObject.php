<?php

namespace FileToObject\Util;

class ReflectedObject
{
    public function __construct(private object $object, private ReflectionCache $cache)
    {
    }

    public function get(string $propertyName)
    {
        $reflection = $this->cache->getClassReflection(get_class($this->object));
        if( $reflection->getProperty($propertyName)->isPublic() ) {
            return $this->object->$propertyName;
        }

        $getter = "get" . ucfirst($propertyName);
        return $this->object->$getter();
    }

    public function set(string $propertyName, mixed $value)
    {
        $reflection = $this->cache->getClassReflection(get_class($this->object));
        if( $reflection->getProperty($propertyName)->isPublic() ) {
            $this->object->$propertyName = $value;
        }
        else {
            $setter = "set" . ucfirst($propertyName);
            $this->object->$setter($value);
        }
        
    }
}
