<?php

namespace Terminal42\WeblingApi;

class Changes
{
    /**
     * @var int
     */
    private $fromRevision;

    /**
     * @var array
     */
    private $changes;
    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * Constructor.
     *
     * @param int           $fromRevision
     * @param array         $changes
     * @param EntityManager $manager
     */
    public function __construct($fromRevision, array $changes, EntityManager $manager)
    {
        $this->fromRevision = (int) $fromRevision;
        $this->changes      = $changes;
        $this->manager      = $manager;
    }

    /**
     * Returns the revision number where changes are started from.
     *
     * @return int
     */
    public function getRevisionFrom()
    {
        return $this->fromRevision;
    }

    /**
     * Returns the latest revision number.
     *
     * @return int
     */
    public function getRevisionTo()
    {
        return (int) $this->changes['revision'];
    }

    /**
     * Returns whether settings have changed.
     *
     * @return bool
     */
    public function hasChangedSettings()
    {
        return (bool) $this->changes['settings'];
    }

    /**
     * Returns whether quota has changed.
     *
     * @return bool
     */
    public function hasChangedQuota()
    {
        return (bool) $this->changes['quota'];
    }

    /**
     * Returns whether subscriptions has changed.
     *
     * @return bool
     */
    public function hasChangedSubscriptions()
    {
        return (bool) $this->changes['subscriptions'];
    }

    /**
     * Returns array of changed entities by type.
     *
     * @return EntityList[]
     */
    public function getAllEntities()
    {
        if (!is_array($this->changes['objects']) || 0 === count($this->changes['objects'])) {
            return [];
        }

        $objects = [];

        foreach ($this->changes['objects'] as $type => $ids) {
            $objects[$type] = new EntityList($type, $ids, $this->manager);
        }

        return $objects;
    }

    /**
     * Returns changed entities of given type.
     *
     * @param string $type
     *
     * @return EntityList
     */
    public function getEntities($type)
    {
        $ids = isset($this->changes['objects'][$type]) ? $this->changes['objects'][$type] : [];

        return new EntityList($type, $ids, $this->manager);
    }
}
