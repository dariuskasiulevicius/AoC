<?php

namespace AdventOfCode\Year2022\Day10;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $steps = [20, 60, 100, 140, 180, 220];
        $step = 0;
        $sum = 1;
        $follow = array_shift($steps);
        foreach ($inputData as $item) {
            //your custom code goes here
            $items = explode(' ', $item);
            if($items[0] === 'noop'){
                $step++;
            } else {
                $step += 2;
            }
            if($follow !== null && $step >= $follow) {
                $result += $follow * $sum;
                $follow = array_shift($steps);
            }
            if($items[0] === 'addx'){
                $sum += (int)$items[1];
            }
        }

        return $result;
    }
}
