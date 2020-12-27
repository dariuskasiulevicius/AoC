<?php

namespace AdventOfCode\Year2020\Day15;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $input = [2, 15, 0, 9, 1, 20];
//        $input = [0, 3, 6];
        $freq = [];
        foreach ($input as $key => $item) {
            $freq[$item] = [$key + 1];
        }

        for ($i = count($input); $i < 2020; $i++) {
            if (count($freq[$input[$i - 1]]) === 1) {
                $input[] = 0;
                $freq[0][] = count($input);
            } else {
                $key = end($input);
                $len = count($freq[$key]);
                $new = $freq[$key][$len -1] - $freq[$key][$len -2];
                $input[]=$new;
                $freq[$new][] = count($input);
            }
        }
        $result = end($input);
//        var_export($input);


        return $result;
    }
}
