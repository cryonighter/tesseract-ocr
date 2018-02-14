<?php

namespace Cryonighter\Tesseract\Option;

use Cryonighter\Tesseract\Exception\TesseractOptionException;

/**
 * Page segmentation modes
 */
class PsmOption extends AbstractOption
{
    /**
     * Available modes list
     */
    public const MODES = [
        0,  // Orientation and script detection (OSD) only
        1,  // Automatic page segmentation with OSD
        2,  // Automatic page segmentation, but no OSD, or OCR
        3,  // Fully automatic page segmentation, but no OSD. (Default)
        4,  // Assume a single column of text of variable sizes
        5,  // Assume a single uniform block of vertically aligned text
        6,  // Assume a single uniform block of text
        7,  // Treat the image as a single text line
        8,  // Treat the image as a single word
        9,  // Treat the image as a single word in a circle
        10, // Treat the image as a single character
        11, // Sparse text. Find as much text as possible in no particular order
        12, // Sparse text with OSD
        13, // Raw line. Treat the image as a single text line, bypassing hacks that are Tesseract-specific
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

        $this->setOption('psm', $mode);
    }
}
