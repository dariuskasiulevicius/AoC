<?php

namespace AdventOfCode\Year2015;

class DataInput implements \Iterator
{
    protected string $file;

    protected $fileHandler;

    protected string $line;
    protected int $lineNumber;

    public static function getDataInputIterator(string $file)
    {
        return new self($file);
    }

    public function __construct(string $file)
    {
        $this->file = $file;
        if (!file_exists($file)) {
            throw new \UnexpectedValueException('File not found ' . $file);
        }
        $this->rewind();
    }

    /**
     * @return mixed
     */
    public function current(): mixed
    {
        return trim($this->line);
    }

    public function next(): void
    {
        $this->lineNumber++;
    }

    public function key(): mixed
    {
        return $this->lineNumber;
    }

    public function valid(): bool
    {
        $this->line = fgets($this->fileHandler);

        return false !== $this->line && !(feof($this->fileHandler) && empty($this->line));
    }

    public function rewind(): void
    {
        if (null !== $this->fileHandler) {
            fclose($this->fileHandler);
        }
        $this->fileHandler = fopen($this->file, 'rb');
        $this->lineNumber = 1;
    }

    public function getAllLines(): array
    {
        $fileContent = file_get_contents($this->file);

        return explode(PHP_EOL, $fileContent);
    }
}
