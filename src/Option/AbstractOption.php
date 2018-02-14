<?php

namespace Cryonighter\Tesseract\Option;

abstract class AbstractOption
{
    /**
     * @var string
     */
    protected $option;

    /**
     * @param string $name
     * @param string $value
     */
    protected function setOption(string $name, string $value): void
    {
        $this->option = "--$name $value";
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->option;
    }
}
