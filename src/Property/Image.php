<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi\Property;

class Image extends File
{
    private $dimensions;

    public function __construct($href, $size, $ext, $mime, Timestamp $timestamp, array $dimensions)
    {
        parent::__construct($href, $size, $ext, $mime, $timestamp);

        $this->dimensions = $dimensions;
    }

    public function getDimensions(): array
    {
        return $this->dimensions;
    }

    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();
        $data['dimensions'] = $this->dimensions;

        return $data;
    }
}
