<?php

namespace AdventOfCode\Year2021\Day13;

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
            if (strpos($item, ',')) {
                [$x, $y] = explode(',', $item);
                $map[$y][$x] = 1;
            } elseif (strpos($item, 'fold') !== false) {
                $actions[] = explode('=', str_replace('fold along ', '', $item));
            }
        }
        $map = $this->sortMap($map);

        foreach ($actions as $action) {
            if ($action[0] === 'y') {
                $map = $this->foldY($map, $action[1]);
            } else {
                $map = $this->foldX($map, $action[1]);
            }
            $map = $this->sortMap($map);
        }

        $result = array_sum(array_map('array_sum', $map));

        foreach ($map as $row) {
            $max = array_key_last($row);
            for ($x = 0; $x <= $max; $x++) {
                $item = '.';
                if (isset($row[$x])) {
                    $item = '#';
                }
                echo $item;
            }
            echo PHP_EOL;
        }

        return $result;
    }

    private function foldY($map, $action)
    {
        $newMap = [];
        foreach ($map as $y => $row) {
            if ($y > $action) {
                $newY = $action - ($y - $action);
                foreach ($row as $x => $item) {
                    $newMap[$newY][$x] = $item;
                }
            } elseif ($y < $action) {
                $newMap[$y] = $row;
            }
        }

        return $newMap;
    }

    private function foldX($map, $action)
    {
        $newMap = [];
        foreach ($map as $y => $row) {
            foreach ($row as $x => $item) {
                if ($x > $action) {
                    $newX = $action - ($x - $action);
                    $newMap[$y][$newX] = $item;
                } elseif ($x < $action) {
                    $newMap[$y][$x] = $item;
                }
            }
        }

        return $newMap;
    }

    private function sortMap(array $map): array
    {
        ksort($map);
        foreach ($map as $key => $item) {
            ksort($map[$key]);
        }

        return $map;
    }
}
