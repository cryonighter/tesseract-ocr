<?php

namespace Cryonighter\Tesseract;

class Image {

    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->path;
    }
}
