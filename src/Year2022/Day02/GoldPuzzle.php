<?php

namespace AdventOfCode\Year2022\Day02;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $map = ['A' => 1, 'B' => 2, 'C' => 3, 'X' => 1, 'Y' => 2, 'Z' => 3];
        $win = [1 => 3, 3 => 2, 2 => 1];
        $lost = [3=>1, 2=>3, 1=>2];

        $result = 0;
        foreach ($inputData as $item) {
            //your custom code goes here
            $items = explode(' ', $item);
            $left = $map[$items[0]];
            $right = $items[1];
            if($right === 'X') {
                $result += 6 - $left - $lost[$left];
            } elseif($right === 'Y'){
                $result += $left;
                $result += 3;
            } elseif($right === 'Z') {
                $result += $win[$win[$left]];
                $result += 6;
            }
        }

        return $result;
    }
}
