<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Property;

class Timestamp extends \DateTime implements \JsonSerializable
{
    public function __construct(string $value)
    {
        parent::__construct($value.':00');
    }

    /**
     * Converts \DateTime object back to an API-compatible date.
     */
    public function __toString(): string
    {
        return $this->format('Y-m-d H:i');
    }

    public function jsonSerialize()
    {
        return (string) $this;
    }
}
