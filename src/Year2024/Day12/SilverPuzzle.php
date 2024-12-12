<?php

namespace AdventOfCode\Year2024\Day12;

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
        $map = [];
        $ymax = 0;
        $xmax = 0;
        foreach ($inputData as $key => $item) {
            $y = $key - 1;
            $ymax = $y;
            $xmax = strlen($item) - 1;
            foreach (str_split($item) as $x => $value) {
                $map[$this->getKey($x, $y)] = $value;
            }
        }

        $orgMap = $map;
        for ($y = 0; $y <= $ymax; $y++) {
            for ($x = 0; $x <= $xmax; $x++) {
                if (isset($map[$this->getKey($x, $y)])) {
                    [$area, $all] = $this->getArea($map, $x, $y);
                    $orgChar = $orgMap[$this->getKey($x, $y)];
                    $perimeter = 0;
                    foreach ($all as $item) {
                        if(!isset($orgMap[$this->getKey($item[0], $item[1])]) || $orgMap[$this->getKey($item[0], $item[1])] !== $orgChar) {
                            $perimeter ++;
                        }
                    }
                    if (count($area) > 0) {
                        $result += count($area) * $perimeter;
                    }
                }
            }
        }

        return $result;
    }

    private function getArea(array &$map, int $x, int $y): array
    {
        $area = [];
        $check = [[$x, $y]];
        $findChar = $map[$this->getKey($x, $y)];
        $all = [];
        while (count($check) > 0) {
            $current = array_shift($check);
            $x = $current[0];
            $y = $current[1];
            $key = $this->getKey($x, $y);
            if (isset($map[$key]) && $map[$key] === $findChar) {
                $area[] = [$x, $y];
                unset($map[$key]);
                $check[] = [$x + 1, $y];
                $check[] = [$x - 1, $y];
                $check[] = [$x, $y + 1];
                $check[] = [$x, $y - 1];
            }
            $all[] = [$x,$y];
        }

        return [$area, $all];
    }

    private function getKey(int $x, int $y)
    {
        return $x . '-' . $y;
    }
}
