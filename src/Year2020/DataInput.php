<?php

namespace AdventOfCode\Year2020;

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

    public function current()
    {
        return trim($this->line);
    }

    public function next()
    {
        $this->lineNumber++;
    }

    public function key()
    {
        return $this->lineNumber;
    }

    public function valid()
    {
        $this->line = fgets($this->fileHandler);

        return false !== $this->line && !(feof($this->fileHandler) && empty($this->line));
    }

    public function rewind()
    {
        if (null !== $this->fileHandler) {
            fclose($this->fileHandler);
        }
        $this->fileHandler = fopen($this->file, 'rb');
        $this->lineNumber = 1;
    }
}
