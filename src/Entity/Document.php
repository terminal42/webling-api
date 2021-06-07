<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Entity;

class Document extends AbstractEntity
{
    public static function getType(): string
    {
        return 'document';
    }

    public static function getParentType(): string
    {
        return 'documentgroup';
    }

    /**
     * Get the content of the file.
     *
     * @internal not yet implemented
     */
    public function getContent()
    {
        // TODO: implement method
    }
}
