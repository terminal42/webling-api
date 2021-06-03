<?php

declare(strict_types=1);

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

    public function __construct(int $fromRevision, array $changes, EntityManager $manager)
    {
        $this->fromRevision = $fromRevision;
        $this->changes = $changes;
        $this->manager = $manager;
    }

    /**
     * Returns the revision number where changes are started from.
     */
    public function getRevisionFrom(): int
    {
        return $this->fromRevision;
    }

    /**
     * Returns the latest revision number.
     */
    public function getRevisionTo(): int
    {
        return (int) $this->changes['revision'];
    }

    /**
     * Returns whether settings have changed.
     */
    public function hasChangedSettings(): bool
    {
        return (bool) $this->changes['settings'];
    }

    /**
     * Returns whether quota has changed.
     */
    public function hasChangedQuota(): bool
    {
        return (bool) $this->changes['quota'];
    }

    /**
     * Returns whether subscriptions has changed.
     */
    public function hasChangedSubscriptions(): bool
    {
        return (bool) $this->changes['subscriptions'];
    }

    /**
     * Returns array of changed entities by type.
     *
     * @return EntityList[]
     */
    public function getAllEntities(): array
    {
        if (!\is_array($this->changes['objects']) || 0 === \count($this->changes['objects'])) {
            return [];
        }

        $objects = [];

        foreach ((array) $this->changes['objects'] as $type => $ids) {
            $objects[$type] = new EntityList($type, $ids, $this->manager);
        }

        return $objects;
    }

    /**
     * Returns changed entities of given type.
     */
    public function getEntities(string $type): EntityList
    {
        $ids = $this->changes['objects'][$type] ?? [];

        return new EntityList($type, $ids, $this->manager);
    }
}
