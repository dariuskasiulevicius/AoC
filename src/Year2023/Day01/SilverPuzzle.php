<?php

namespace AdventOfCode\Year2023\Day01;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            $numbers = preg_replace('/[a-z]/', '', $item);
            $result += (int)substr($numbers, 0, 1) * 10 + (int)substr($numbers, -1, 1);
        }

        return $result;
    }
}
