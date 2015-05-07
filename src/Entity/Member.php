<?php

namespace Terminal42\WeblingApi\Entity;

class Member extends AbstractEntity implements EntityInterface
{
    const IMAGE_ORIGINAL = 'original';
    const IMAGE_THUMB    = 'thumb';
    const IMAGE_MINI     = 'mini';

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'member';
    }

    public function getImage($property, $size = self::IMAGE_ORIGINAL)
    {
        // TODO: implement method
    }

    public function getFile($property)
    {
        // TODO: implement method
    }
}
