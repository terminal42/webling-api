<?php

namespace Terminal42\WeblingApi\Entity;

class Membergroup extends AbstractEntity implements EntityInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'membergroup';
    }
}
