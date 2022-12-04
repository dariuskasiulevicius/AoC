<?php

namespace AdventOfCode\Year2022\Day03;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $scores = $this->getScores();
        $result = 0;
        $groups = [];
        $group = 0;
        $i = 1;
        foreach ($inputData as $item) {
            //your custom code goes here
            $one = array_unique(str_split($item, 1));
            if ($i > 3) {
                $group++;
                $i = 1;
            }
            if ($i === 1) {
                $groups[$group] = [];
            }
            $groups[$group][] = $one;
            $i++;
        }

        foreach ($groups as $group) {
            $identical = array_values(array_intersect(...$group));
            if (count($identical) !== 1) {
                echo $item . PHP_EOL;
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
        for ($a = 1; $a <= 26; $a++) {
            $result[chr($a + 96)] = $a;
        }
        for ($A = 27; $A <= 52; $A++) {
            $result[chr($A + 38)] = $A;
        }

        return $result;
    }
}
