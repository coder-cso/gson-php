<?php
/*
 * Copyright (c) Nate Brunette.
 * Distributed under the MIT License (http://opensource.org/licenses/MIT)
 */

namespace Tebru\Gson\Internal;

use Tebru\Gson\ClassMetadata;
use Tebru\Gson\Internal\Data\AnnotationCollectionFactory;
use Tebru\Gson\Internal\Data\AnnotationSet;
use Tebru\Gson\Internal\Data\Property;
use Tebru\Gson\PropertyMetadata;

/**
 * Class MetadataFactory
 *
 * @author Nate Brunette <n@tebru.net>
 */
final class MetadataFactory
{
    /**
     * Reads annotations from a class, property, or method and returns
     * an [@see AnnotationSet]
     *
     * @var AnnotationCollectionFactory
     */
    private $annotationCollectionFactory;

    /**
     * Constructor
     *
     * @param AnnotationCollectionFactory $annotationCollectionFactory
     */
    public function __construct(AnnotationCollectionFactory $annotationCollectionFactory)
    {
        $this->annotationCollectionFactory = $annotationCollectionFactory;
    }

    /**
     * Create class metadata
     *
     * @param string $className
     * @return ClassMetadata
     * @throws \InvalidArgumentException If the type does not exist
     */
    public function createClassMetadata(string $className): ClassMetadata
    {
        return new ClassMetadata($className, $this->annotationCollectionFactory->createClassAnnotations($className));
    }

    /**
     * Creates property metadata
     *
     * @param Property $property
     * @param ClassMetadata $classMetadata
     * @return PropertyMetadata
     */
    public function createPropertyMetadata(Property $property, ClassMetadata $classMetadata): PropertyMetadata
    {
        return new PropertyMetadata(
            $property->getRealName(),
            $property->getSerializedName(),
            $property->getType(),
            $property->getModifiers(),
            $classMetadata,
            $property->getAnnotations(),
            $property->isVirtual()
        );
    }
}