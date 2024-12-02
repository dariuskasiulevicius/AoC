<?php

namespace AdventOfCode\Year2023\Day06;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 1;
        $time = 62649190;
        $distance = 553101014731074;
        $win = 0;
        for ($i = 1; $i < $time; $i++) {
            if (($time - $i) * $i > $distance) {
                $win++;
            }
        }
        $result *= $win;


        return $result;
    }
}
