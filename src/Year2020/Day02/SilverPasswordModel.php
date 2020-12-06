<?php

namespace AdventOfCode\Year2020\Day02;

class SilverPasswordModel
{
    protected int $minSymbol;
    protected int $maxSymbol;
    protected string $char;
    protected string $password;
    protected string $initLine;

    public function __construct(string $line)
    {
        $this->initLine = $line;
        $this->parse();
    }

    public function isValid()
    {
        if (null === $this->password) {
            return false;
        }

        $valid = false;
        $charCount = substr_count($this->password, $this->char);
        if ($charCount >= $this->minSymbol && $charCount <= $this->maxSymbol) {
            $valid = true;
        }

        return $valid;
    }

    protected function parse()
    {
        $pattern = '/(?P<min>\d+)-(?P<max>\d+) (?P<char>[^\:]+):\s+(?P<pass>\S+)/';
        if (1 === preg_match($pattern, $this->initLine, $matches)) {
            $this->minSymbol = $matches['min'];
            $this->maxSymbol = $matches['max'];
            $this->char = $matches['char'];
            $this->password = $matches['pass'];
        }
    }
}
