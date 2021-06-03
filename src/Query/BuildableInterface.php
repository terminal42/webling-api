<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Query;

interface BuildableInterface
{
    /**
     * Converts the object to a string.
     */
    public function build(): string;
}
