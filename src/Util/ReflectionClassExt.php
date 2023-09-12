<?php

namespace FileToObject\Util;

use Fp\Collections\ArrayList;
use Fp\Collections\HashMap;
use ReflectionClass;
use ReflectionMethod;

class ReflectionClassExt extends ReflectionClass
{

    /**
     * Removes $prefix from $methodName and convert the first letter of the
     * result to lowercase.
     */
    protected static function removeMethodPrefix(string $methodName, string $prefix = 'get'): string
    {
        return lcfirst(substr($methodName, strlen($prefix)));
    }

    /**
     * Get a list of all reflections of all getters.
     *
     * A getter is a public method, which has no required parameters and starts
     * with 'get'.
     *
     * @return ArrayList<ReflectionMethod>
     */
    public function getGetterReflections(): ArrayList
    {
        return ArrayList::collect($this->getMethods(ReflectionMethod::IS_PUBLIC))
            ->filter(fn ($method) => str_starts_with($method->getName(), 'get'))
            ->filter(fn ($method) => $method->getNumberOfRequiredParameters() == 0);
    }

    /**
     * Returns a map of method-getter-name (without 'get'-prefix) to its
     * reflection (only public getters are considered).
     *
     * @return HashMap<string, ReflectionMethod>
     */
    public function getGetterReflectionMap(): HashMap
    {
        return $this->getGetterReflections()
            ->map(fn ($method) => [$method->getName(), $method])
            ->toHashMap()
            ->reindex(fn ($method) => self::removeMethodPrefix($method->getName()));
    }

    /**
     * Returns a map of property-name => reflection.
     *
     * @return HashMap<string, ReflectionProperty>
     */
    public function getPropertyReflectionMap(): HashMap
    {
        return ArrayList::collect($this->getProperties())
            ->map(fn ($refl) => [$refl->getName(), $refl])
            ->toHashMap();
    }

    /**
     * Returns a map of (property name => List of Attributes for the property).
     *
     * @param ?string $attributeClass
     *     fully qualified attribute classname; if provided, the results are
     *     filtered to attribues of this class.
     *
     * @return HashMap<string, object>
     */
    public function getAccessablePropertyAttributes(?string $attributeClass): HashMap
    {
        return $this->getGetterReflectionMap()
             ->appendedAll($this->getPropertyReflectionMap())
             ->map(fn ($refl) => $refl->getAttributes($attributeClass))
             ->map(fn ($attrs) => array_shift($attrs))
             ->filter(fn ($attr) => isset($attr))
             ->map(fn ($attr) => $attr->newInstance());
    }
    
}
