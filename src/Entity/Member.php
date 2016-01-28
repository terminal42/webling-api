<?php

namespace Terminal42\WeblingApi\Entity;

class Member extends AbstractEntity
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

    /**
     * @internal not yet implemented
     */
    public function getImage($property, $size = self::IMAGE_ORIGINAL)
    {
        // TODO: implement method
    }

    /**
     * @internal not yet implemented
     */
    public function getFile($property)
    {
        // TODO: implement method
    }
}
