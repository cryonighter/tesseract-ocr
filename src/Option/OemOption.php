<?php

namespace Cryonighter\Tesseract\Option;

use Cryonighter\Tesseract\Exception\TesseractOptionException;

/**
 * OCR Engine mode
 */
class OemOption extends AbstractOption
{
    /**
     * Original Tesseract only
     */
    public const MODE_TESSERACT = 0;

    /**
     * Cube only
     */
    public const MODE_CUBE = 1;

    /**
     * Tesseract + cube
     */
    public const MODE_TESSERACT_AND_CUBE = 2;

    /**
     * Default, based on what is available
     */
    public const MODE_DEFAULT = 3;

    /**
     * Available modes list
     */
    public const MODES = [
        self::MODE_TESSERACT,
        self::MODE_CUBE,
        self::MODE_TESSERACT_AND_CUBE,
        self::MODE_DEFAULT,
    ];

    /**
     * @param int $mode
     *
     * @throws TesseractOptionException
     */
    public function __construct(int $mode)
    {
        if (!in_array($mode, self::MODES)) {
            throw new TesseractOptionException("Not available mod '$mode', expected: ".implode(', ', self::MODES));
        }

        $this->setOption('oem', $mode);
    }
}
