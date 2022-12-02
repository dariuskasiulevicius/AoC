<?php

namespace AdventOfCode\Year2022;

class TestCase
{
    const VARIATION_SILVER = 'Silver';
    const VARIATION_GOLD = 'Gold';

    protected string $inputFileName;
    protected string $expected;
    protected string $variation;

    public function getInputFileName(): string
    {
        return $this->inputFileName;
    }

    public function setInputFileName(string $inputFileName): void
    {
        $this->inputFileName = $inputFileName;
    }

    public function getExpected(): string
    {
        return $this->expected;
    }

    public function setExpected(string $expected): void
    {
        $this->expected = $expected;
    }

    public function getVariation(): string
    {
        return $this->variation;
    }

    public function setVariation(string $variation): void
    {
        $this->variation = $variation;
    }
}
