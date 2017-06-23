<?php

namespace Terminal42\WeblingApi\Query;

interface BuildableInterface
{
    /**
     * Converts the object to a string.
     *
     * @return string
     */
    public function build();
}
