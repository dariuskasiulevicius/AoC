<?php

namespace AdventOfCode\Year2022\Day06;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

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
            $letters = str_split($item);
        }
        $buffer = [];
        for($i =0; $i < 14;$i++){
            $buffer[] = array_shift($letters);
            $result++;
        }

        while (count(array_unique($buffer)) !== 14) {
            array_shift($buffer);
            $buffer[] = array_shift($letters);
            $result++;
        }

        return $result;
    }
}
