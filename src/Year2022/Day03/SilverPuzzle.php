<?php

namespace AdventOfCode\Year2022\Day03;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $scores = $this->getScores();
        $result = 0;
        foreach ($inputData as $item) {
            //your custom code goes here
            $lentgh = strlen($item);
            $left = array_unique(str_split(substr($item, 0, $lentgh/2), 1));
            $right = array_unique(str_split(substr($item, $lentgh/2), 1));
            $identical = array_values(array_intersect($left, $right));
            if (count($identical) !== 1) {
                echo $item .PHP_EOL;
                var_export($identical);
                exit(255);
            }
            $result += $scores[$identical[0]];
        }

        return $result;
    }

    private function getScores()
    {
        $result = [];
        for($a = 1; $a <= 26; $a++){
            $result[chr($a+96)] = $a;
        }
        for($A = 27; $A <= 52; $A++){
            $result[chr($A+38)] = $A;
        }

        return $result;
    }
}
