<?php

namespace AdventOfCode\Year2024\Day12;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
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
                    $filtered = [];
                    ksort($all);
                    foreach ($all as $key => $item) {
                        [$ki, $kj, $kl, $kk] = $this->getCoordinate($key);
                        $kn = $this->getKey($ki, $kj);
                        if (!isset($orgMap[$kn]) || $orgMap[$kn] !== $orgChar) {
                            $filtered[$key] = $item;
                        }
                    }
                    while (count($filtered) > 0) {
                        $key = array_key_first($filtered);
                        $firstCount = array_shift($filtered);
                        [$orgx, $orgy, $ni, $nj] = $this->getCoordinate($key);
                        $sides = [[1, 0], [-1, 0], [0, 1], [0, -1]];
                        foreach ($sides as $side) {
                            $xx = $orgx + $side[0];
                            $yy = $orgy + $side[1];
                            $newKey = $this->getKey($xx, $yy, $ni, $nj);
                            while (isset($filtered[$newKey])) {
                                $filtered[$newKey]--;
                                if ($filtered[$newKey] === 0) {
                                    unset($filtered[$newKey]);
                                }
                                $xx += $side[0];
                                $yy += $side[1];
                                $newKey = $this->getKey($xx, $yy, $ni, $nj);
                            }
                        }
                        $perimeter += $firstCount;
                    }
                    if (count($area) > 0) {
//                        echo 'Area: ' . count($area) . ' Perimeter: ' . $perimeter . ' Char: ' . $orgChar . PHP_EOL;
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
        $check = [[$x, $y, 0, 0]];
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
                $check[] = [$x + 1, $y, 1, 0];
                $check[] = [$x - 1, $y, -1, 0];
                $check[] = [$x, $y + 1, 0, 1];
                $check[] = [$x, $y - 1, 0, -1];
            }
            if (!isset($all[$this->getKey($x, $y, $current[2], $current[3])])) {
                $all[$this->getKey($x, $y, $current[2], $current[3])] = 0;
            }
            $all[$this->getKey($x, $y, $current[2], $current[3])]++;
        }

        return [$area, $all];
    }

    private function getKey(int ...$x)
    {
        return implode(';', $x);
    }

    private function getCoordinate(string $key): array
    {
        return array_map('intval', explode(';', $key));
    }
}
