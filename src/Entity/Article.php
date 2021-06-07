<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Entity;

class Article extends AbstractEntity
{
    public static function getType(): string
    {
        return 'article';
    }

    public static function getParentType(): string
    {
        return 'articlegroup';
    }
}
