<?php

namespace AdventOfCode\Year2020\Day02;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            $password = new SilverPasswordModel($item);
            if ($password->isValid()) {
                $result++;
            }
        }

        return $result;
    }
}
