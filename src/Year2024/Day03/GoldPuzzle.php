<?php

namespace AdventOfCode\Year2024\Day03;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $multiply = true;
        foreach ($inputData as $item) {
            preg_match_all('/(do\(\))|(don\'t\(\))|(mul\([0-9]+,[0-9]+\))/', $item, $matches);
            foreach ($matches[0] as $match) {
                if ($match === 'do()') {
                    $multiply = true;
                    continue;
                }
                if ($match === 'don\'t()') {
                    $multiply = false;
                    continue;
                }
                if ($multiply) {
                    $numbers = explode(',', str_replace(['mul(', ')'], '', $match));
                    $result += $numbers[0] * $numbers[1];
                }
            }
        }

        return $result;
    }
}
