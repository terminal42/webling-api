<?php

namespace Terminal42\WeblingApi;

use Terminal42\WeblingApi\Entity\DefinitionAwareInterface;
use Terminal42\WeblingApi\Entity\EntityInterface;

class EntityFactory implements EntityFactoryInterface
{
    /**
     * @var EntityInterface[]
     */
    protected static $classes = [
        'member'        => 'Terminal42\\WeblingApi\\Entity\\Member',
        'membergroup'   => 'Terminal42\\WeblingApi\\Entity\\Membergroup',
        'article'       => 'Terminal42\\WeblingApi\\Entity\\Article',
        'articlegroup'  => 'Terminal42\\WeblingApi\\Entity\\Articlegroup',
        'document'      => 'Terminal42\\WeblingApi\\Entity\\Document',
        'documentgroup' => 'Terminal42\\WeblingApi\\Entity\\Documentgroup',
    ];

    /**
     * {@inheritdoc}
     */
    public function create(EntityManager $manager, array $data, $id = null)
    {
        $class = static::$classes[$data['type']];

        $children = [];

        foreach ((array) $data['children'] as $type => $ids) {
            $children[$type] = new EntityList($type, $ids, $manager);
        }

        $entity = new $class(
            $id,
            $data['readonly'],
            $data['properties'],
            $children,
            new EntityList($data['type'], $data['parents'], $manager),
            new EntityList($data['type'], $data['links'], $manager)
        );

        if ($entity instanceof DefinitionAwareInterface) {
            $definition = $manager->getDefinition();
            $entity->setDefinition($definition[$data['type']]);
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($type)
    {
        return isset(static::$classes[$type]);
    }
}
