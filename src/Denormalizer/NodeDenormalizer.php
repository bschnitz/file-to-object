<?php

namespace FileToObject\Normalizer;

use FileToObject\Attribute\Keyed;
use FileToObject\Util\ReflectionCache;
use Fp\Collections\HashMap;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorResolverInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class NodeDenormalizer extends ObjectNormalizer
{
    /** @var array<string, string> (class path) -> (property name) */
    private array $keyedPropertyCache;

    public function __construct(
        protected ReflectionCache $reflections,
        ClassMetadataFactoryInterface $classMetadataFactory = null,
        NameConverterInterface $nameConverter = null,
        PropertyAccessorInterface $propertyAccessor = null,
        PropertyTypeExtractorInterface $propertyTypeExtractor = null,
        ClassDiscriminatorResolverInterface $classDiscriminatorResolver = null,
        callable $objectClassResolver = null,
        array $defaultContext = []
    ) {
        parent::__construct($classMetadataFactory, $nameConverter, $propertyAccessor, $propertyTypeExtractor, $classDiscriminatorResolver, $objectClassResolver, $defaultContext);
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = [])
    {

        $object = parent::denormalize($data, $type, $format, $context);

        [$keyedPropertyName, $class, $key] = $this->getKeyedProperty($type);

        if ($keyedPropertyName === null) {
            return $object;
        }

        $reflectedObject = $this->reflections->getReflectedObject($object);

        $keyedData = $reflectedObject->get($keyedPropertyName);

        $keyedObjects = $this->denormalizeKeydPropertyData(
            $keyedData,
            $class,
            $key,
            $format,
            $context
        );

        $reflectedObject->set($keyedPropertyName, $keyedObjects);

        return $object;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null)
    {
        return parent::supportsDenormalization($data, $type, $format);
    }

    public function denormalizeKeydPropertyData($data, $class, $keyProperty, $format, $context)
    {
        return HashMap::collect($data)
            ->mapKV(fn($keyValue, $data) => $data + [$keyProperty => $keyValue])
            ->map(fn($data) => parent::denormalize($data, $class, $format, $context))
            ->toArray();
    }

    public function getKeyedProperty(string $type)
    {
        return $this->keyedPropertyCache[$type] ??= $this->reflections
             ->getClassReflection($type)
             ->getAccessablePropertyAttributes(Keyed::class)
             ->toArrayList()
             ->at(0)
             ->mapN(fn($propName, $attr) => [$propName, $attr->class, $attr->key])
             ->getOrElse([null, null, null]);
    }
}
