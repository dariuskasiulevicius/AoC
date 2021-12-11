<?php

namespace AdventOfCode\Year2021\Day11;

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
            $map[] = array_map('intval', str_split($item));
        }

        for ($step = 0; $step < 100; $step++) {
            $map = $this->increaseMapValue($map);
            $map = $this->shine($map);
            $result += $this->getShineCount($map);
        }

        return $result;
    }

    private function increaseMapValue($map)
    {
        $maxX = count($map[0]);
        $maxY = count($map);
        for ($y = 0; $y < $maxY; $y++) {
            for ($x = 0; $x < $maxX; $x++) {
                $map[$y][$x]++;
            }
        }

        return $map;
    }

    private function getShineCount($map): int
    {
        $result = 0;
        $maxX = count($map[0]);
        $maxY = count($map);
        for ($y = 0; $y < $maxY; $y++) {
            for ($x = 0; $x < $maxX; $x++) {
                if ($map[$y][$x] === 0) {
                    $result++;
                }
            }
        }

        return $result;
    }

    private function shine($map)
    {
        $maxX = count($map[0]);
        $maxY = count($map);
        do {
            $hasMoreThenNine = false;
            for ($y = 0; $y < $maxY; $y++) {
                for ($x = 0; $x < $maxX; $x++) {
                    if ($map[$y][$x] > 9) {
                        $map[$y][$x] = 0;
                        $map = $this->increaseAdjacents($map, $x, $y);
                        $hasMoreThenNine = true;
                    }
                }
            }
        } while ($hasMoreThenNine);

        return $map;
    }

    private function increaseAdjacents($map, $x, $y)
    {
        if (isset($map[$y][$x - 1]) && $map[$y][$x - 1] !== 0) {
            $map[$y][$x - 1]++;
        }
        if (isset($map[$y][$x + 1]) && $map[$y][$x + 1] !== 0) {
            $map[$y][$x + 1]++;
        }
        if (isset($map[$y - 1][$x]) && $map[$y - 1][$x] !== 0) {
            $map[$y - 1][$x]++;
        }
        if (isset($map[$y + 1][$x]) && $map[$y + 1][$x] !== 0) {
            $map[$y + 1][$x]++;
        }
        if (isset($map[$y + 1][$x - 1]) && $map[$y + 1][$x - 1] !== 0) {
            $map[$y + 1][$x - 1]++;
        }
        if (isset($map[$y + 1][$x + 1]) && $map[$y + 1][$x + 1] !== 0) {
            $map[$y + 1][$x + 1]++;
        }
        if (isset($map[$y - 1][$x - 1]) && $map[$y - 1][$x - 1] !== 0) {
            $map[$y - 1][$x - 1]++;
        }
        if (isset($map[$y - 1][$x + 1]) && $map[$y - 1][$x + 1] !== 0) {
            $map[$y - 1][$x + 1]++;
        }

        return $map;
    }
}
