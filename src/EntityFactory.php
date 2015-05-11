<?php

namespace Terminal42\WeblingApi;

use Terminal42\WeblingApi\Entity\EntityInterface;

class EntityFactory implements EntityFactoryInterface
{
    /**
     * @var EntityInterface[]
     */
    protected $classes = [
        'member'      => 'Terminal42\WeblingApi\Entity\Member',
        'membergroup' => 'Terminal42\WeblingApi\Entity\Membergroup',
    ];

    /**
     * {@inheritdoc}
     */
    public function create(EntityManager $manager, array $data, $id = null)
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
