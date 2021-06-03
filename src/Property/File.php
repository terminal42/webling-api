<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Property;

class File implements \JsonSerializable
{
    private $href;
    private $size;
    private $ext;
    private $mime;
    private $timestamp;

    public function __construct($href, $size, $ext, $mime, Timestamp $timestamp)
    {
        $this->href = $href;
        $this->size = $size;
        $this->ext = $ext;
        $this->mime = $mime;
        $this->timestamp = $timestamp;
    }

    public function getHref(): string
    {
        return $this->href;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getExt(): string
    {
        return $this->ext;
    }

    public function getMime(): string
    {
        return $this->mime;
    }

    public function getTimestamp(): Timestamp
    {
        return $this->timestamp;
    }

    public function jsonSerialize()
    {
        return [
            'href' => $this->href,
            'size' => $this->size,
            'ext' => $this->ext,
            'mime' => $this->mime,
            'timestamp' => (string) $this->timestamp,
        ];
    }
}
