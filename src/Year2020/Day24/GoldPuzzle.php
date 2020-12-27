<?php

namespace AdventOfCode\Year2020\Day24;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    protected $map;

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $directions = ['e', 'ne', 'nw', 'w', 'sw', 'se'];
        $map = [];
        $start = ['row' => 0, 'col' => 0];
        $minRow = 0;
        $maxRow = 0;
        $minCol = 0;
        $maxCol = 0;
        foreach ($inputData as $item) {
            $position = $start;
            $letters = str_split($item, 1);
            while (!empty($letters)) {
                $dir = '';
                do {
                    $dir .= array_shift($letters);
                } while (!in_array($dir, $directions));
                $position = $this->goToDirection($position['col'], $position['row'], $dir);
            }
            if (!isset($map[$position['row']][$position['col']])) {
                $map[$position['row']][$position['col']] = 0;
                $minRow = min($minRow, $position['row']);
                $maxRow = max($maxRow, $position['row']);
                $minCol = min($minCol, $position['col']);
                $maxCol = max($maxCol, $position['col']);
            }
            $map[$position['row']][$position['col']] = 1 - $map[$position['row']][$position['col']];
        }

        echo 'minRow-' . $minRow . PHP_EOL;
        echo 'maxRow-' . $maxRow . PHP_EOL;
        echo 'minCol-' . $minCol . PHP_EOL;
        echo 'maxCol-' . $maxCol . PHP_EOL;

        $this->map = $map;

        for ($day = 1; $day <= 100; $day++) {
            $newMap = [];
            $minCol--;
            $maxCol++;
            $minRow--;
            $maxRow++;
            for ($row = $minRow; $row <= $maxRow; $row++) {
                for ($col = $minCol; $col <= $maxCol; $col++) {
                    $color = 0;
                    if (isset($this->map[$row][$col])) {
                        $color = $this->map[$row][$col];
                    }
                    $count = $this->getCountOfBlack($col, $row);
                    if ($color === 1
                        && ($count === 0 || $count > 2)) {
                        $color = 1 - $color;
                    } elseif ($color === 0 && $count === 2) {
                        $color = 1 - $color;
                    }
                    $newMap[$row][$col] = $color;
                }
            }

            $this->map = $newMap;
            $tmp = 0;
            foreach ($this->map as $line) {
                $tmp += array_sum($line);
            }
            echo $day . ': ' . $tmp . PHP_EOL;
        }

        foreach ($this->map as $line) {
            $result += array_sum($line);
        }

        return $result;
    }

    public function getCountOfBlack($col, $row)
    {
        $count = 0;
        foreach (['e', 'ne', 'nw', 'w', 'sw', 'se'] as $dir) {
            $neighbour = $this->goToDirection($col, $row, $dir);
            if ($this->isBlack($neighbour['col'], $neighbour['row'])) {
                $count++;
            }
        }

        return $count;
    }

    public function isBlack($col, $row)
    {
        if (!isset($this->map[$row][$col])) {
            return false;
        }
        if ($this->map[$row][$col] === 0) {
            return false;
        }

        return true;
    }

    public function goToDirection($col, $row, $direction)
    {
        static $oddrDirections = [
            [
                'e'  => [+1, 0],
                'ne' => [0, -1],
                'nw' => [-1, -1],
                'w'  => [-1, 0],
                'sw' => [-1, +1],
                'se' => [0, +1],
            ],
            [
                'e'  => [+1, 0],
                'ne' => [+1, -1],
                'nw' => [0, -1],
                'w'  => [-1, 0],
                'sw' => [0, +1],
                'se' => [+1, +1],
            ],
        ];
        $parity = abs($row) % 2;
        $dir = $oddrDirections[$parity][$direction];

        return ['col' => $col + $dir[0], 'row' => $row + $dir[1]];
    }
}
