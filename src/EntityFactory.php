<?php

namespace Terminal42\WeblingApi;

use Terminal42\WeblingApi\Entity\EntityInterface;

class EntityFactory implements EntityFactoryInterface
{
    /**
     * @var EntityInterface[]
     */
    private $classes = [
        'member' => 'Terminal42\WeblingApi\Entity\Member',
    ];

    /**
     * {@inheritdoc}
     */
    public function create(EntityManager $manager, $data, $id = null)
    {
        $class = $this->classes[$data['type']];

        $children = [];

        foreach ($data['children'] as $type => $ids) {
            $children[$type] = new EntityList($type, $ids, $manager);
        }

        return new $class(
            $id,
            $data['readyonly'],
            $data['properties'],
            $children,
            new EntityList($data['type'], $data['parents'], $manager),
            new EntityList($data['type'], $data['links'], $manager)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function supports($type)
    {
        return isset($this->classes[$type]);
    }
}
