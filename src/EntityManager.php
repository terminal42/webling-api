<?php

namespace Terminal42\WeblingApi;

use Terminal42\WeblingApi\Entity\EntityInterface;
use Terminal42\WeblingApi\Exception\ApiErrorException;
use Terminal42\WeblingApi\Exception\HttpStatusException;
use Terminal42\WeblingApi\Exception\NotFoundException;
use Terminal42\WeblingApi\Exception\ParseException;
use Terminal42\WeblingApi\Query\Query;
use Terminal42\WeblingApi\Repository\RepositoryInterface;

class EntityManager
{
    const API_VERSION = 1;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var EntityFactoryInterface
     */
    private $factory;

    /**
     * @var array
     */
    private $entities = [];

    /**
     * @var array
     */
    private $definition;

    /**
     * Constructor.
     *
     * @param ClientInterface        $client  The HTTP client to make requests to the server.
     * @param EntityFactoryInterface $factory A factory capable of creating entities.
     */
    public function __construct(ClientInterface $client, EntityFactoryInterface $factory)
    {
        $this->client  = $client;
        $this->factory = $factory;
    }

    /**
     * Returns the definition of entities
     *
     * @return array
     *
     * @throws HttpStatusException If there was a problem with the request
     * @throws ParseException      If the JSON data could not be parsed
     * @throws NotFoundException   If the API returned a HTTP status code 404
     * @throws ApiErrorException   If the API returned an error message
     */
    public function getDefinition()
    {
        if (null === $this->definition) {
            $this->definition = $this->client->get('/definition');
        }

        return $this->definition;
    }

    /**
     * Returns the latest revision number from replication dataset.
     *
     * @return int
     */
    public function getLatestRevisionId()
    {
        $result = $this->client->get('/replicate');

        return (int) $result['revision'];
    }

    /**
     * Returns the changeset for latest revision compared to given ID.
     *
     * @param int $revisionId
     *
     * @return Changes
     */
    public function getChanges($revisionId)
    {
        return new Changes($revisionId, $this->client->get('/replicate/' . (int) $revisionId), $this);
    }

    /**
     * Gets the factory instance used by this entity manager.
     *
     * @return EntityFactoryInterface
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * Finds all entities for a given type.
     *
     * @param string $type  The entity type
     * @param Query  $query A property query from the QueryBuilder
     * @param array $order  A sorting array where key is property and value is direction (see constants).
     *
     * @return EntityList
     *
     * @throws \InvalidArgumentException If the order contains invalid sorting directions.
     * @throws HttpStatusException       If there was a problem with the request
     * @throws ParseException            If the JSON data could not be parsed
     * @throws NotFoundException         If the API returned a HTTP status code 404
     * @throws ApiErrorException         If the API returned an error message
     */
    public function findAll($type, Query $query = null, array $order = [])
    {
        $params = [
            'filter'    => (string) $query,
            'order'     => $this->prepareOrder($order),
        ];

        $data = $this->client->get("/$type", array_filter($params));

        return new EntityList($type, $data['objects'], $this);
    }

    /**
     * Find an entity by ID of given type.
     *
     * @param string $type The entity type
     * @param int    $id   The entity ID
     *
     * @return mixed
     *
     * @throws HttpStatusException If there was a problem with the request
     * @throws ParseException      If the JSON data could not be parsed
     * @throws NotFoundException   If the API returned a HTTP status code 404
     * @throws ApiErrorException   If the API returned an error message
     */
    public function find($type, $id)
    {
        if (!isset($this->entities[$type][$id])) {
            $data   = $this->client->get("/$type/$id");
            $entity = $this->factory->create($this, $data, $id);

            $this->entities[$type][$id] = $entity;
        }

        return $this->entities[$type][$id];
    }

    /**
     * Add or update the entity in Webling.
     *
     * @param EntityInterface $entity
     *
     * @throws \InvalidArgumentException If the entity is readonly
     * @throws HttpStatusException       If there was a problem with the request
     * @throws NotFoundException         If the API returned a HTTP status code 404
     * @throws ApiErrorException         If the API returned an error message
     */
    public function persist(EntityInterface $entity)
    {
        if ($entity->isReadonly()) {
            throw new \InvalidArgumentException('The entity must not be readonly.');
        }

        if (null === $entity->getId()) {
            $this->create($entity);
        } else {
            $this->update($entity);
        }

        $this->entities[$entity->getType()][$entity->getId()] = $entity;
    }

    /**
     * Delete entity from Webling.
     *
     * @param EntityInterface $entity
     *
     * @throws \UnexpectedValueException If the entity does not have an ID
     * @throws \InvalidArgumentException If the entity is readonly
     * @throws HttpStatusException       If there was a problem with the request
     * @throws NotFoundException         If the API returned a HTTP status code 404
     * @throws ApiErrorException         If the API returned an error message
     */
    public function remove(EntityInterface $entity)
    {
        $this->validateHasId($entity);

        if ($entity->isReadonly()) {
            throw new \InvalidArgumentException('The entity must not be readonly.');
        }

        $id   = $entity->getId();
        $type = $entity->getType();

        $this->client->delete("/$type/$id");

        unset($this->entities[$type][$id]);
        $entity->unsetId();
    }

    /**
     * Creates an entity in Webling.
     *
     * @param EntityInterface $entity
     *
     * @throws HttpStatusException If there was a problem with the request
     * @throws NotFoundException   If the API returned a HTTP status code 404
     * @throws ApiErrorException   If the API returned an error message
     */
    private function create(EntityInterface $entity)
    {
        $type = $entity->getType();
        $data = $entity->serialize();

        $result = $this->client->post("/$type", $data);

        $entity->setId($result);
    }

    /**
     * Updates an entity in Webling.
     *
     * @param EntityInterface $entity
     *
     * @throws HttpStatusException If there was a problem with the request
     * @throws NotFoundException   If the API returned a HTTP status code 404
     * @throws ApiErrorException   If the API returned an error message
     */
    private function update(EntityInterface $entity)
    {
        $id   = $entity->getId();
        $type = $entity->getType();
        $data = $entity->serialize();

        $this->client->put("/$type/$id", $data);
    }

    /**
     * Throws exception if entity does not have an ID.
     *
     * @param EntityInterface $entity
     *
     * @throws \UnexpectedValueException
     */
    private function validateHasId(EntityInterface $entity)
    {
        if (null === $entity->getId()) {
            throw new \UnexpectedValueException('The entity must have an ID.');
        }
    }

    /**
     * Creates a new entity manager for the given Webling account.
     *
     * @param string $subdomain Your Webling subdomain.
     * @param string $apiKey    Your Webling API key.
     *
     * @return static
     */
    public static function createForAccount($subdomain, $apiKey)
    {
        return new static(new Client($subdomain, $apiKey, static::API_VERSION), new EntityFactory());
    }

    /**
     * Validates an order config and converts to query string.
     *
     * @param array $order
     *
     * @return string
     *
     * @throws \InvalidArgumentException If the order contains invalid sorting directions.
     */
    private function prepareOrder(array $order)
    {
        $invalidDirections = array_diff(
            $order,
            [RepositoryInterface::DIRECTION_ASC, RepositoryInterface::DIRECTION_DESC]
        );

        if (count($invalidDirections) > 0) {
            throw new \InvalidArgumentException(
                sprintf('Invalid sorting direction(s) "%s"', implode('", "', $invalidDirections))
            );
        }

        return http_build_query($order, null, ', ');
    }
}
