<?php

namespace AdventOfCode\Year2021\Day05;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $map = [];
        $actions = [];
        foreach ($inputData as $item) {
            if (false === preg_match('/(\d+),(\d+)[^\d]+(\d+),(\d+)/', $item, $matches)) {
                echo 'error ' . $item . PHP_EOL;

                return 0;
            }
            array_shift($matches);
            $actions[] = array_map('intval', $matches);
        }

        foreach ($actions as $action) {
            $x1 = $action[0];
            $x2 = $action[2];
            $y1 = $action[1];
            $y2 = $action[3];

            do {
                $map = $this->addPoint($map, $x1, $y1);
                if ($x1 > $x2) {
                    $x1--;
                } elseif ($x1 < $x2) {
                    $x1++;
                }
                if ($y1 > $y2) {
                    $y1--;
                } elseif ($y1 < $y2) {
                    $y1++;
                }
            } while ($x1 !== $x2 || $y1 !== $y2);
            $map = $this->addPoint($map, $x1, $y1);
        }

        return $this->mapResult($map);
    }

    private function addPoint($map, $x, $y)
    {
        if (!isset($map[$y][$x])) {
            $map[$y][$x] = 0;
        }
        $map[$y][$x]++;

        return $map;
    }

    private function mapResult(array $map): int
    {
        $result = 0;

        foreach ($map as $line) {
            foreach ($line as $item) {
                if ($item >= 2) {
                    $result++;
                }
            }
        }

        return $result;
    }
}
