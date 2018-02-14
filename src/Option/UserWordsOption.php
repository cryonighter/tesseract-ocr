<?php

namespace Cryonighter\Tesseract\Option;

/**
 * Location of user words file
 */
class UserWordsOption extends AbstractOption
{
    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->setOption('user-words', escapeshellarg($path));
    }
}
