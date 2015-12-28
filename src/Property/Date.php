<?php

namespace Terminal42\WeblingApi\Property;

class Date extends \DateTime
{
    /**
     * Constructor.
     *
     * @param string $value
     */
    function __construct($value)
    {
        parent::__construct($value . ' 0:00:00');
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
