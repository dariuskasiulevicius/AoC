<?php

namespace AdventOfCode\Year2021\Day21;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $playerA = [8, 0];
        $playerB = [4, 0];
        $dice = 6;
        $roll = 0;
        while (true) {
            $roll += 3;
            $playerA[0] = ($playerA[0] + $dice) % 10 === 0 ? 10 : ($playerA[0] + $dice) % 10;
            $playerA[1] += $playerA[0];
            if ($playerA[1] >= 1000) {
                break;
            }

            $roll += 3;
            $playerB[0] = ($playerB[0] + $dice) % 10 === 0 ? 10 : ($playerB[0] + $dice) % 10;
            $playerB[1] += $playerB[0];
            if ($playerB[1] >= 1000) {
                break;
            }
            $dice += 9;
        }
//        echo $roll . PHP_EOL;
//        var_export($playerA);
//        var_export($playerB);

        return min($playerA[1], $playerB[1]) * $roll;
    }
}
