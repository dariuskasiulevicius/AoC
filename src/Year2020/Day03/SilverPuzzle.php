<?php

namespace AdventOfCode\Year2020\Day03;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $positionLine => $item) {
            $position = ($positionLine - 1) * 3 % strlen($item);
            if ($item[$position] === '#') {
                $result++;
            }
        }

        return $result;
    }
}
