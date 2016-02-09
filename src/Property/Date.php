<?php

namespace Terminal42\WeblingApi\Property;

class Date extends \DateTime implements \JsonSerializable
{
    /**
     * Constructor.
     *
     * @param string $value
     */
    public function __construct($value)
    {
        parent::__construct($value . ' 0:00:00');
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->format('Y-m-d');
    }

    /**
     * Converts \DateTime object back to an API-compatible date.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->format('Y-m-d');
    }
}
