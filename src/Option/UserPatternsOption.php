<?php

namespace Cryonighter\Tesseract\Option;

/**
 * Location of user patterns file
 */
class UserPatternsOption extends AbstractOption
{
    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->setOption('user-patterns', escapeshellarg($path));
    }
}
