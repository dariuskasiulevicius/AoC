<?php

namespace AdventOfCode\Year2020\Day05;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
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
            $result[] = $minLine * 8 + $maxCol;
        }

//        $output->writeln('Result: ' . max($result));
//        sort($result);
//        $prev = null;
//        foreach ($result as $item) {
//            if (null === $prev) {
//                $prev = $item;
//                continue;
//            }
//            if ($prev + 1 !== $item) {
//                print_r($prev + 1);
//            }
//            $prev = $item;
//        }

        return max($result);
    }
}
