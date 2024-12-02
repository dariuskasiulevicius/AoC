<?php

namespace AdventOfCode\Year2023\Day04;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            [$play, $cards] = explode(': ', $item);
            [$win, $my] = explode(' | ', $cards);
            $win = array_values(array_filter(explode(' ', $win)));
            $my = array_values(array_filter(explode(' ', $my)));
            $count = count(array_intersect($my, $win));
            if ($count > 0) {
                $result += 2 ** ($count-1);
            }
        }


        return $result;
    }
}
