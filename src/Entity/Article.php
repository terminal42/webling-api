<?php

namespace Terminal42\WeblingApi\Entity;

class Article extends AbstractEntity
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'article';
    }
}
