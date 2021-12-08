<?php

namespace AdventOfCode\Year2021\Day08;

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
        foreach ($inputData as $item) {
            $signals = explode(' | ', $item);
            $after = explode(' ', $signals[1]);
            foreach ($after as $segment) {
                $len = strlen($segment);
                if ($len === 2 || $len === 4 || $len === 3 || $len === 7) {
                    $result++;
                }
            }
        }

        return $result;
    }
}
