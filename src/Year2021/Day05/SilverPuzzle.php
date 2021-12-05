<?php

namespace AdventOfCode\Year2021\Day05;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
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
            if ($x1 > $x2) {
                $x1 = $action[2];
                $x2 = $action[0];
            }
            if ($y1 > $y2) {
                $y1 = $action[3];
                $y2 = $action[1];
            }
            if ($x1 === $x2 || $y1 === $y2) {
                for ($x = $x1; $x <= $x2; $x++) {
                    for ($y = $y1; $y <= $y2; $y++) {
                        if (!isset($map[$y][$x])) {
                            $map[$y][$x] = 0;
                        }
                        $map[$y][$x]++;
                    }
                }
            }
        }

        return $this->mapResult($map);
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
