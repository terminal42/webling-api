<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Entity;

class Articlegroup extends AbstractEntity
{
    public static function getType(): string
    {
        return 'articlegroup';
    }

    public static function getParentType(): ?string
    {
        return null;
    }
}
