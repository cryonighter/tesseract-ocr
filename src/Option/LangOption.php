<?php

namespace Cryonighter\Tesseract\Option;

/**
 * Language(s) used for OCR
 */
class LangOption extends AbstractOption
{
    /**
     * @param array | string[] ...$languages
     */
    public function __construct(string ...$languages)
	{
		$this->option = '-l '.escapeshellarg(implode('+', $languages));
	}
}
