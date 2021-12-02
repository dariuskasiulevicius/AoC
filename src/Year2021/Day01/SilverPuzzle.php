<?php

namespace AdventOfCode\Year2021\Day01;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $prev = 0;
        foreach ($inputData as $item) {
            if ($prev > 0 && $prev < $item) {
                $result++;
            }
            $prev = $item;
        }

        return $result;
    }
}
