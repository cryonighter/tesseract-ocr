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

        [$stdin, $stdout, $stderr] = $pipes;

        fwrite($stdin, $content);
        pclose($stdin);

        $output = stream_get_contents($stdout);
        $errors = stream_get_contents($stderr);

        pclose($stdout);
        pclose($stderr);

        // Waiting until the process is complete (otherwise it's impossible to get the exit code)
        usleep(10);

        $processStatus = proc_get_status($process);

        proc_close($process);

        if (true === $processStatus['running']) {
            throw new TesseractException('Tesseract process is not completed');
        }

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
