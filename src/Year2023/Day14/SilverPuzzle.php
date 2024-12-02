<?php

namespace AdventOfCode\Year2023\Day14;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

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
            $map[] = str_split($item);
        }
        $maxY = count($map) - 1;
        $maxX = count($map[0]) - 1;

        for ($x = 0; $x <= $maxX; $x++) {
            $y = 0;
            do {
                $moved = false;
                if (isset($map[$y][$x]) && $map[$y][$x] === 'O') {
                    if (isset($map[$y - 1][$x]) && $map[$y - 1][$x] === '.') {
                        $moved = true;
                        $map[$y - 1][$x] = 'O';
                        $map[$y][$x] = '.';
                        $y--;
                    }
                }
                if (!$moved) {
                    $y++;
                }
            } while ($moved || $y <= $maxY);
        }

        $maxY++;
        foreach ($map as $line) {
            foreach ($line as $char) {
                if ($char === 'O') {
                    $result += $maxY;
                }
            }
            $maxY--;
        }

        return $result;
    }
}
