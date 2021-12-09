<?php

namespace AdventOfCode\Year2021\Day09;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $map = [];
        foreach ($inputData as $item) {
            $map[] = str_split($item);
        }
        $maxX = count($map[0]);
        $maxY = count($map);

        for ($y = 0; $y < $maxY; $y++) {
            for ($x = 0; $x < $maxX; $x++) {
                if ($this->isLow($map, $x, $y)) {
                    $result += $map[$y][$x] + 1;
                }
            }
        }


        return $result;
    }

    private function isLow($map, $x, $y)
    {
        $number = $map[$y][$x];

        return !(
            (isset($map[$y - 1]) && $map[$y - 1][$x] <= $number)
            || (isset($map[$y + 1]) && $map[$y + 1][$x] <= $number)
            || (isset($map[$y][$x - 1]) && $map[$y][$x - 1] <= $number)
            || (isset($map[$y][$x + 1]) && $map[$y][$x + 1] <= $number)
        );
    }
}
