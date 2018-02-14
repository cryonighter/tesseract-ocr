<?php

namespace Cryonighter\Tesseract;

use Cryonighter\Tesseract\Exception\TesseractException;
use Cryonighter\Tesseract\Option\AbstractOption;

class Ocr
{
    /**
     * @var Tesseract
     */
    private $tesseract;

    /**
     * @var Image
     */
    private $image;

    /**
     * @var array | AbstractOption[]
     */
    private $options = [];

    /**
     * @param Tesseract                $tesseract
     * @param Image                    $image
     * @param array | AbstractOption[] ...$options
     */
    public function __construct(Tesseract $tesseract, Image $image, AbstractOption ...$options)
    {
        $this->tesseract = $tesseract;
        $this->image = $image;

        foreach ($options as $option) {
            $this->options[get_class($option)] = $option;
        }
    }

    /**
     * @return string
     *
     * @throws TesseractException
     */
    public function execute(): string
    {
        return $this->tesseract->execute($this->build());
    }

    /**
     * @param AbstractOption $option
     *
     * @return Ocr
     */
    public function setOptions(AbstractOption $option): self
    {
        $this->options[get_class($option)] = $option;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "$this->tesseract {$this->build()}";
    }

    /**
     * @return string
     */
    private function build(): string
    {
        return "$this->image stdout " . implode(' ', $this->options);
    }
}
