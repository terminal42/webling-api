<?php

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
        $this->href      = $href;
        $this->size      = $size;
        $this->ext       = $ext;
        $this->mime      = $mime;
        $this->timestamp = $timestamp;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * @return Timestamp
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'href'      => $this->href,
            'size'      => $this->size,
            'ext'       => $this->ext,
            'mime'      => $this->mime,
            'timestamp' => $this->timestamp->jsonSerialize(),
        ];
    }
}
