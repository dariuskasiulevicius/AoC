<?php

namespace AdventOfCode\Year2021\Day01;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $items = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $items[] = (int)$item;
            $lastKey = array_key_last($items) - 1;
            $until = $lastKey - 2;
            for ($i = $lastKey; $i > $until; $i--) {
                if (isset($items[$i])) {
                    $items[$i] += (int)$item;
                }
            }
        }
        $prev = 0;
        foreach ($items as $item) {
            if ($prev > 0 && $prev < $item) {
                $result++;
            }
            $prev = $item;
        }

        return $result;
    }
}
