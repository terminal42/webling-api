<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Entity;

class Document extends AbstractEntity
{
    public function getType(): string
    {
        return 'document';
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
