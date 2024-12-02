<?php

namespace AdventOfCode\Year2023\Day09;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            $numbers = array_map('intval', explode(' ', $item));
            $begins = [];
            $begins[] = reset($numbers);
            do {
                $zero = true;
                $count = count($numbers) - 1;
                $tmp = [];
                for ($i = 0; $i < $count; $i++) {
                    $diff = $numbers[$i + 1] - $numbers[$i];
                    $tmp[] = $diff;
                    if ($diff !== 0) {
                        $zero = false;
                    }
                }
                $begins[] = reset($tmp);
                $numbers = $tmp;
            } while (!$zero);
//            var_export($begins);
//            echo PHP_EOL;
//            $result += array_sum($begins);
//            $a = $begins;
            $begins = array_reverse($begins);
            $prev = null;
            foreach ($begins as $num) {
                if ($prev !== null) {
                    $prev = $num - $prev;
                } else {
                    $prev = $num;
                }
            }
            $result += $prev;
        }

        return $result;
    }
}
