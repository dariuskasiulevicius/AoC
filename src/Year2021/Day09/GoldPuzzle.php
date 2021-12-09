<?php

namespace AdventOfCode\Year2021\Day09;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    private $map;

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

        $lowestPoints = [];
        for ($y = 0; $y < $maxY; $y++) {
            for ($x = 0; $x < $maxX; $x++) {
                if ($this->isLow($map, $x, $y)) {
                    $this->map = $map;
                    $lowestPoints[] = $this->climbe($x, $y);
                }
            }
        }
        var_export($lowestPoints);
        rsort($lowestPoints, SORT_NUMERIC);


        return $lowestPoints[0] * $lowestPoints[1] * $lowestPoints[2];
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

    private function climbe($x, $y)
    {
        $result = 0;
        if ($this->map[$y][$x] === 'X') {
            return $result;
        }
        if ($this->map[$y][$x] !== '9') {
            $result++;
            $this->map[$y][$x] = 'X';
        } else {
            return $result;
        }
        if (isset($this->map[$y - 1])) {
            $result += $this->climbe($x, $y - 1);
        }
        if (isset($this->map[$y + 1])) {
            $result += $this->climbe($x, $y + 1);
        }
        if (isset($this->map[$y][$x - 1])) {
            $result += $this->climbe($x - 1, $y);
        }
        if (isset($this->map[$y][$x + 1])) {
            $result += $this->climbe($x + 1, $y);
        }

        return $result;
    }
}
