<?php

namespace AdventOfCode\Year2024\Day03;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            preg_match_all('/mul\([0-9]+,[0-9]+\)/', $item, $matches);
            foreach ($matches[0] as $match) {
                $numbers = explode(',', str_replace(['mul(', ')'], '', $match));
                $result += $numbers[0] * $numbers[1];
            }
        }

        return $result;
    }
}
