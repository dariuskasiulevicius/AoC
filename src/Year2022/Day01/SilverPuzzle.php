<?php

namespace AdventOfCode\Year2022\Day01;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $elfs = [0];
        $elfNumber = 0;
        foreach ($inputData as $item) {
            //your custom code goes here
            if (empty($item)){
                $elfNumber++;
                $elfs[$elfNumber] = 0;
            } else {
                $elfs[$elfNumber] += (int) $item;
            }
        }

        return max($elfs);
    }
}
