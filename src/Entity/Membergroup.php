<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Entity;

class Membergroup extends AbstractEntity
{
    public static function getType(): string
    {
        return 'membergroup';
    }

    public static function getParentType(): string
    {
        return 'membergroup';
    }
}
