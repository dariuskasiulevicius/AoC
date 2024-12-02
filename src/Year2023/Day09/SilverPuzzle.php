<?php

namespace AdventOfCode\Year2023\Day09;

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
            $numbers = array_map('intval', explode(' ', $item));
            $ends = [];
            $ends[] = end($numbers);
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
                $ends[] = end($tmp);
                $numbers = $tmp;
            } while (!$zero);
            $result += array_sum($ends);
        }

        return $result;
    }
}
