<?php

namespace Cryonighter\Tesseract\Option;

/**
 * Location of tessdata path
 */
class TessdataDirOption extends AbstractOption
{
    /**
     * @param string $path
     */
    public function __construct(string $path)
	{
		$this->setOption('tessdata-dir', escapeshellarg($path));
	}
}
