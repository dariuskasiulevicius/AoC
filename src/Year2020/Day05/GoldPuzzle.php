<?php

namespace AdventOfCode\Year2020\Day05;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        foreach ($inputData as $item) {
            $minLine = 0;
            $maxLine = 127;
            $len = strlen($item);
            $minCol = 0;
            $maxCol = 7;
            for ($index = 0; $index < $len; $index++) {
                if ($item[$index] === 'F') {
                    $maxLine = ($maxLine + $minLine + 1) / 2 - 1;
                } elseif ($item[$index] === 'B') {
                    $minLine = ($maxLine + $minLine + 1) / 2;
                } elseif ($item[$index] === 'R') {
                    $minCol = ($maxCol + $minCol + 1) / 2;
                } elseif ($item[$index] === 'L') {
                    $maxCol = ($maxCol + $minCol + 1) / 2 - 1;
                }
            }
            $seats[] = $minLine * 8 + $maxCol;
        }


        sort($seats);
        $prev = null;
        foreach ($seats as $item) {
            if (null === $prev) {
                $prev = $item;
                continue;
            }
            if ($prev + 1 !== $item) {
                $result = $prev + 1;
                break;
            }
            $prev = $item;
        }

        return $result;
    }
}
