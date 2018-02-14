<?php

namespace Cryonighter\Tesseract;

use Cryonighter\Tesseract\Exception\TesseractException;
use Cryonighter\Tesseract\Option\TessdataDirOption;

class Tesseract
{
    /**
     * @var string
     */
    private $binPath;

    /**
     * @param string $binPath
     */
    public function __construct(string $binPath)
    {
        $this->binPath = "\"$binPath\"";
    }

    /**
     * @param string $binPath
     *
     * @return Tesseract
     */
    public static function create(string $binPath): self
    {
        return new self($binPath);
    }

    /**
     * @return Tesseract
     */
    public static function createDefault(): self
    {
        return new self('tesseract');
    }

    /**
     * Returns the original help message
     *
     * @return string
     *
     * @throws TesseractException
     */
    public function getHelp(): string
    {
        return $this->execute('--help');
    }

    /**
     * @return string
     *
     * @throws TesseractException
     */
    public function getHelpPsm(): string
    {
        return $this->execute('--help-psm');
    }


    /**
     * @return string
     *
     * @throws TesseractException
     */
    public function getHelpOem(): string
    {
        return $this->execute('--help-oem');
    }

    /**
     * @return string
     *
     * @throws TesseractException
     */
    public function getVersion(): string
    {
        return $this->execute('--version');
    }

    /**
     * @param TessdataDirOption $option
     *
     * @return string
     *
     * @throws TesseractException
     */
    public function getPrintParameters(TessdataDirOption $option): string
    {
        return $this->execute("--print-parameters $option");
    }

    /**
     * @param TessdataDirOption $option
     *
     * @return array
     *
     * @throws TesseractException
     */
    public function getListLangs(TessdataDirOption $option): array
    {
        // First element contain message "List of available languages (107):"
        return array_slice(explode(PHP_EOL, trim($this->execute("--list-langs $option"))), 1);
    }

    /**
     * @param string $command
     * @param string $content
     *
     * @return string
     *
     * @throws TesseractException
     */
    public function execute(string $command, string $content = ''): string
    {
        $cmd = "$this->binPath $command";

        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $pipes = [];

        $process = proc_open($cmd, $descriptors, $pipes, null, null, ['bypass_shell' => true]);

        fwrite($pipes[0], $content);
        pclose($pipes[0]);

        $output = stream_get_contents($pipes[1]);
        $errors = stream_get_contents($pipes[2]);

        pclose($pipes[1]);
        pclose($pipes[2]);

        $processStatus = proc_get_status($process);

        proc_close($process);

        $exitCode = $processStatus['exitcode'];

        if (0 !== $exitCode) {
            throw new TesseractException($errors, $exitCode);
        }

        return $output;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->binPath;
    }
}
