<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Entity;

class Member extends AbstractEntity
{
    public const IMAGE_ORIGINAL = 'original';
    public const IMAGE_THUMB = 'thumb';
    public const IMAGE_MINI = 'mini';

    public static function getType(): string
    {
        return 'member';
    }

    public static function getParentType(): string
    {
        return 'membergroup';
    }

    /**
     * @internal not yet implemented
     */
    public function getImage($property, $size = self::IMAGE_ORIGINAL): void
    {
        // TODO: implement method
    }

    /**
     * @internal not yet implemented
     */
    public function getFile($property): void
    {
        // TODO: implement method
    }
}
