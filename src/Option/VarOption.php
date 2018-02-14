<?php

namespace Cryonighter\Tesseract\Option;

/**
 * Values for config variables
 */
class VarOption extends AbstractOption
{
    /**
     * @param array $vars
     */
    public function __construct(array $vars)
    {
        $this->option = implode(
            ' ',
            array_map(
                function(string $key, string $value): string {
                    return '- c '.escapeshellarg($key).' '.escapeshellarg($value);
                },
                array_keys($vars),
                array_values($vars)
            )
        );
    }
}
