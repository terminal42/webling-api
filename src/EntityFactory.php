<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi;

use Terminal42\WeblingApi\Entity\DefinitionAwareInterface;
use Terminal42\WeblingApi\Entity\EntityInterface;
use Terminal42\WeblingApi\Entity\Member;
use Terminal42\WeblingApi\Entity\Membergroup;
use Terminal42\WeblingApi\Entity\Article;
use Terminal42\WeblingApi\Entity\Articlegroup;
use Terminal42\WeblingApi\Entity\Document;
use Terminal42\WeblingApi\Entity\Documentgroup;

class EntityFactory implements EntityFactoryInterface
{
    /**
     * @var array<string, string>
     */
    protected static $classes = [
        'member' => Member::class,
        'membergroup' => Membergroup::class,
        'article' => Article::class,
        'articlegroup' => Articlegroup::class,
        'document' => Document::class,
        'documentgroup' => Documentgroup::class,
    ];

    public function create(EntityManager $manager, array $data, int $id = null): EntityInterface
    {
        $class = static::$classes[$data['type']];

        $children = [];
        $parents = null;
        $links = [];

        if (isset($data['children'])) {
            foreach ((array) $data['children'] as $type => $ids) {
                $children[$type] = new EntityList($type, $ids, $manager);
            }
        }

        if (isset($data['parents']) && null !== $class::getParentType()) {
            $parents = new EntityList($class::getParentType(), $data['parents'], $manager);
        }

        if (isset($data['links'])) {
            foreach ((array) $data['links'] as $type => $ids) {
                $links[$type] = new EntityList($type, $ids, $manager);
            }
        }

        $entity = new $class(
            $id,
            $data['readonly'] ?? false,
            $data['properties'] ?? [],
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
