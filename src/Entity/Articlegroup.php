<?php

namespace Terminal42\WeblingApi\Entity;

class Articlegroup extends AbstractEntity implements EntityInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'articlegroup';
    }
}
