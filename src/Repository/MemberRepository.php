<?php

namespace Terminal42\WeblingApi\Repository;

use Terminal42\WeblingApi\EntityList;

class MemberRepository extends AbstractRepository
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'member';
    }

    /**
     * Find member containing given first or lastname.
     *
     * @param string|array $value     A value or multiple values to filter for
     * @param string       $sort      Sort result by this property
     * @param string       $direction Sort order (see RepositoryInterface constants)
     *
     * @return EntityList
     */
    public function findByFirstnameOrLastname($value, $sort = '', $direction = '')
    {
        if (is_array($value)) {
            $value = implode(' ', $value);
        }

        return $this->manager->findAll($this->getType(), $value, $sort, $direction);
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $properties, $sort = '', $direction = '')
    {
        $filter = [];

        if (isset($properties['Vorname'])) {
            $filter[] = $properties['Vorname'];
            unset($properties['Vorname']);
        }

        if (isset($properties['Name'])) {
            $filter[] = $properties['Name'];
            unset($properties['Name']);
        }

        $filter = empty($filter) ? '' : implode(' ', $filter);

        $entities = $this->manager->findAll($this->getType(), $filter, $sort, $direction);

        return empty($properties) ? $entities : new PropertyFilter($entities, $properties);
    }
}
