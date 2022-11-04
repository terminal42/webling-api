<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Entity;

use Terminal42\WeblingApi\Property\Date;
use Terminal42\WeblingApi\Property\File;
use Terminal42\WeblingApi\Property\Image;
use Terminal42\WeblingApi\Property\Timestamp;

trait GeneratorTrait
{
    /**
     * @var array
     */
    private $definition;

    public function setDefinition(array $definition): void
    {
        $this->definition = $definition;
    }

    protected function valueFromProperty($name, $value)
    {
        $property = null;
        foreach ((array) $this->definition['properties'] as $data) {
            if ($name === $data['title']) {
                $property = $data;
                break;
            }
        }

        if (null === $property) {
            throw new \UnderflowException(sprintf('Webling Error: Property with title "%s" does not exist in the %s definition.', $name, __CLASS__));
        }

        $datatype = $property['datatype'];

        switch ($datatype) {
            case 'autoincrement':
            case 'int':
            case 'numeric':
            case 'bool':
            case 'text':
            case 'longtext':
                return $value;

            case 'file':
                return new File(
                    $value['href'],
                    $value['size'],
                    $value['ext'],
                    $value['mime'],
                    new Timestamp($value['timestamp'])
                );

            case 'image':
                return new Image(
                    $value['href'],
                    $value['size'],
                    $value['ext'],
                    $value['mime'],
                    new Timestamp($value['timestamp']),
                    $value['dimensions']
                );

            case 'date':
                return null === $value ? null : new Date($value);

            case 'timestamp':
                return null === $value ? null : new Timestamp($value);

            default:
                throw new \InvalidArgumentException(sprintf('Type "%s" is not supported.', $datatype));
        }
    }

    protected function getPropertyNameById($id)
    {
        foreach ((array) $this->definition['properties'] as $data) {
            if ($id === $data['id']) {
                return $data['title'];
            }
        }

        throw new \UnderflowException(sprintf('Webling Error: Property with ID %s does not exist in the %s definition.', $id, __CLASS__));
    }
}
