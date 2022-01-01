<?php

namespace AdventOfCode\Year2015\Day01;

use AdventOfCode\Year2015\DataInput;
use AdventOfCode\Year2015\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            //your custom code goes here
            $result = count_chars($item, 1);
        }

        $open = ord('(');
        $close = ord(')');

        return $result[$open] - $result[$close];
    }
}
