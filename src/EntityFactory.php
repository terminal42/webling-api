<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi;

use Terminal42\WeblingApi\Entity\DefinitionAwareInterface;
use Terminal42\WeblingApi\Entity\EntityInterface;

class EntityFactory implements EntityFactoryInterface
{
    /**
     * @var EntityInterface[]
     */
    protected static $classes = [
        'member' => 'Terminal42\\WeblingApi\\Entity\\Member',
        'membergroup' => 'Terminal42\\WeblingApi\\Entity\\Membergroup',
        'article' => 'Terminal42\\WeblingApi\\Entity\\Article',
        'articlegroup' => 'Terminal42\\WeblingApi\\Entity\\Articlegroup',
        'document' => 'Terminal42\\WeblingApi\\Entity\\Document',
        'documentgroup' => 'Terminal42\\WeblingApi\\Entity\\Documentgroup',
    ];

    public function create(EntityManager $manager, array $data, int $id = null): EntityInterface
    {
        $class = static::$classes[$data['type']];

        $children = [];
        $parents = null;
        $links = [];

        foreach ((array) $data['children'] as $type => $ids) {
            $children[$type] = new EntityList($type, $ids, $manager);
        }

        if (null !== $class::getParentType()) {
            $parents = new EntityList($class::getParentType(), $data['parents'], $manager);
        }

        foreach ((array) $data['links'] as $type => $ids) {
            $links[$type] = new EntityList($type, $ids, $manager);
        }

        $entity = new $class(
            $id,
            $data['readonly'],
            $data['properties'],
            $children,
            $parents,
            $links
        );

        if ($entity instanceof DefinitionAwareInterface) {
            $definition = $manager->getDefinition();
            $entity->setDefinition($definition[$data['type']]);
        }

        return $entity;
    }

    public function supports(string $type): bool
    {
        return isset(static::$classes[$type]);
    }
}
