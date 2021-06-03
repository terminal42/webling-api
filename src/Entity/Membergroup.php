<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Entity;

class Membergroup extends AbstractEntity
{
    public function getType(): string
    {
        return 'membergroup';
    }
}
