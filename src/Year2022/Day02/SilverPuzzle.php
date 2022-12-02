<?php

namespace AdventOfCode\Year2022\Day02;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $map = ['A' => 1, 'B' => 2, 'C' => 3, 'X' => 1, 'Y' => 2, 'Z' => 3];
        $win = [1 => 3, 3 => 2, 2 => 1];

        $result = 0;
        foreach ($inputData as $item) {
            //your custom code goes here
            $items = explode(' ', $item);
            $left = $map[$items[0]];
            $right = $map[$items[1]];
            $result += $right;
            if ($win[$right] === $left) {
                $result += 6;
            } elseif ($left === $right) {
                $result += 3;
            }
        }

        return $result;
    }
}
