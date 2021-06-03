<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Entity;

class Article extends AbstractEntity
{
    public function getType(): string
    {
        return 'article';
    }
}
