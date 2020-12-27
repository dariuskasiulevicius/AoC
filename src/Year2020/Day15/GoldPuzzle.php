<?php

namespace AdventOfCode\Year2020\Day15;

ini_set('memory_limit', '200G');

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $input = [2, 15, 0, 9, 1, 20];
//        $input = [0,3,6];
        $freq = [];
        foreach ($input as $key => $item) {
            $freq[$item] = [$key + 1];
        }
        $lastNumber = end($input);
        $count = count($input);
        for ($i = count($input); $i < 30000000; $i++) {
            if (count($freq[$lastNumber]) === 1) {
                $lastNumber = 0;
            } else {
                $len = count($freq[$lastNumber]);
                $lastNumber = $freq[$lastNumber][$len - 1] - $freq[$lastNumber][$len - 2];
            }

            $count++;
            $freq[$lastNumber][] = $count;
            $len = count($freq[$lastNumber]);
            if ($len > 2) {
                $freq[$lastNumber] = [$freq[$lastNumber][$len - 2], $freq[$lastNumber][$len - 1]];
            }
        }
        $result = $lastNumber;


        echo 'mem peak ' . memory_get_peak_usage(true) . PHP_EOL;
        echo 'mem usage ' . memory_get_usage(true) . PHP_EOL;

        return $result;
    }
}
