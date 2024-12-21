<?php

namespace AdventOfCode\Year2024\Day19;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    private array $dp = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $towels = [];
        $patterns = [];
        $empty = false;
        foreach ($inputData as $item) {
            if ($empty) {
                $patterns[] = $item;
            } else {
                if ($item === '') {
                    $empty = true;
                } else {
                    $towels = explode(', ', $item);
                }
            }
        }
        $towels = $this->splitTowels($towels);

        foreach ($patterns as $key => $pattern) {
            $start = microtime(true);
            if ($this->canCreateTowel($pattern, $towels)) {
                $result++;
            }
            echo $key . ' time: ' . microtime(true) - $start . PHP_EOL;
        }

        return $result;
    }

    private function splitTowels(array $towels): array
    {
        foreach ($towels as $towel) {
            $result[$towel] = strlen($towel);
        }
        arsort($result);

        return $result;
    }

    private function canCreateTowel(string $pattern, array $towels): bool
    {
        if (isset($this->dp[$pattern])) {
            return $this->dp[$pattern];
        }
        $canMake = false;
        if (empty($pattern)) {
            $canMake = true;
        }
        foreach ($towels as $towel => $length) {
            if (strpos($pattern, $towel) === 0 && $this->canCreateTowel(substr($pattern, strlen($towel)), $towels)) {
                $canMake = true;
            }
        }
        $this->dp[$pattern] = $canMake;

        return $canMake;
    }
}
