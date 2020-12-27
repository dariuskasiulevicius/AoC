<?php

namespace AdventOfCode\Year2020\Day24;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $directions = ['e', 'ne', 'nw', 'w', 'sw', 'se'];
        $map = [];
        $start = ['row' => 0, 'col' => 0];
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
            if (!isset($map[$position['row']][$position['col']])){
                $map[$position['row']][$position['col']] = 0;
            }
            $map[$position['row']][$position['col']] = 1 - $map[$position['row']][$position['col']];
        }

        foreach ($map as $line) {
            $result += array_sum($line);
        }

        return $result;
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
