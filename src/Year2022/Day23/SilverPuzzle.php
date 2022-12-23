<?php

namespace AdventOfCode\Year2022\Day23;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    private $map = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        foreach ($inputData as $item) {
            //your custom code goes here
            $items = str_split($item);
            $this->map[] = array_filter($items, fn($value): bool => $value === "#");
        }
//        $this->printMap($this->map);
        $steps = 10;
        for ($i = 0; $i < $steps; $i++) {
//            echo 'Step ' . $i + 1 . PHP_EOL;
            $this->move();
        }


        return $this->printMap($this->map);
    }

    private function move()
    {
        $proposeMap = [];
        foreach ($this->map as $y => $line) {
            foreach ($line as $x => $value) {
                $hasKaimynas = $this->hasAdjacent($x, $y);
                if ($hasKaimynas) {
                    $item = $this->moveToSide($x, $y);
                    $xx = $item[0] + $x;
                    $yy = $item[1] + $y;
                } else {
                    $xx = $x;
                    $yy = $y;
                }
                if (!isset($proposeMap[$yy][$xx])) {
                    $proposeMap[$yy][$xx] = 0;
                }
                $proposeMap[$yy][$xx]++;
            }
        }

        $newMap = [];
        foreach ($this->map as $y => $line) {
            foreach ($line as $x => $value) {
                $hasKaimynas = $this->hasAdjacent($x, $y);
                if ($hasKaimynas) {
                    $item = $this->moveToSide($x, $y);
                    $xx = $item[0] + $x;
                    $yy = $item[1] + $y;
                    if ($proposeMap[$yy][$xx] === 1) {
                        $newMap[$yy][$xx] = '#';
                    } else {
                        $newMap[$y][$x] = '#';
                    }
                } else {
                    $newMap[$y][$x] = '#';
                }
            }
        }
//        $this->printMap($newMap);
        $this->map = $newMap;
        $this->shiftSide();
    }

    private function hasAdjacent($x, $y)
    {
        $test = [
            [1, 0], [-1, 0],
            [0, 1], [0, -1],
            [1, 1], [-1, -1],
            [-1, 1], [1, -1],
        ];
        $result = false;
        foreach ($test as $item) {
            $xx = $item[0] + $x;
            $yy = $item[1] + $y;
            if (isset($this->map[$yy][$xx])) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    private function isEmptySide($x, $y, $side)
    {
        $sides = [
            'N' => [[-1, -1], [0, -1], [1, -1]],
            'S' => [[-1, 1], [0, 1], [1, 1]],
            'W' => [[-1, -1], [-1, 0], [-1, 1]],
            'E' => [[1, -1], [1, 0], [1, 1]],
        ];
        $result = true;
        foreach ($sides[$side] as $item) {
            $xx = $item[0] + $x;
            $yy = $item[1] + $y;
            if (isset($this->map[$yy][$xx])) {
                $result = false;
                break;
            }
        }

        return $result;
    }

    private function printMap($map)
    {
        $keys = array_keys($map);
        $last = max($keys);
        $first = min($keys);
        $xmin = 0;
        $xmax = 0;
        foreach ($map as $item) {
            $keys = array_keys($item);
            $xmin = min($xmin, ...$keys);
            $xmax = max($xmax, ...$keys);
        }

        $countEmpty = 0;
        for ($y = $first; $y <= $last; $y++) {
            for ($x = $xmin; $x <= $xmax; $x++) {
                if (isset($map[$y][$x])) {
//                    echo '#';
                } else {
//                    echo '.';
                    $countEmpty++;
                }
            }
//            echo PHP_EOL;
        }
//        echo PHP_EOL;

        return $countEmpty;
    }

    private function shiftSide()
    {
        $key = array_key_first($this->sides);
        $item = array_shift($this->sides);
        $this->sides[$key] = $item;
    }

    private $sides = ['N' => [0, -1], 'S' => [0, 1], 'W' => [-1, 0], 'E' => [1, 0]];

    public function moveToSide(int $x, int $y): array
    {
        $item = [0, 0];
        foreach ($this->sides as $side => $newItem) {
            if ($this->isEmptySide($x, $y, $side)) {
                $item = $newItem;
                break;
            }
        }

        return $item;
    }
}
