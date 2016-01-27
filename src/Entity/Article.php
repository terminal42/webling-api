<?php

namespace Terminal42\WeblingApi\Entity;

class Article extends AbstractEntity implements EntityInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'article';
    }
}
