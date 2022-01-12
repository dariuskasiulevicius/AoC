<?php

namespace AdventOfCode\Year2015\Day04;

use AdventOfCode\Year2015\DataInput;
use AdventOfCode\Year2015\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            //your custom code goes here
            $input = $item;
        }

        $step = 0;
        do {
            $hash = md5($input . $step);
            if (substr($hash, 0, 6) === '000000') {
                break;
            }
            $step++;
        } while (true);

        return $step;
    }
}
