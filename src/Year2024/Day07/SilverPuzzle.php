<?php

namespace AdventOfCode\Year2024\Day07;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;

        foreach ($inputData as $item) {
            [$testSum, $elements] = explode(': ', $item);
            $numbers = array_map('intval', explode(' ', $elements));
            $count = count($numbers);
            $sums = [$numbers[0]];
            for ($i = 1; $i < $count; $i++) {
                $newSums = [];
                foreach ($sums as $sum) {
                    if($sum + $numbers[$i] <= $testSum) {
                        $newSums[] = $sum + $numbers[$i];
                    }
                    if($sum * $numbers[$i] <= $testSum) {
                        $newSums[] = $sum * $numbers[$i];
                    }
                }
                $sums = $newSums;
            }
            foreach ($sums as $sum) {
                if($sum == $testSum) {
                    $result += $sum;
                    break;
                }
            }
        }

        return $result;
    }
}
