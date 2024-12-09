<?php

namespace AdventOfCode\Year2024\Day06;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $map = [];
        $position = [];
        foreach ($inputData as $y => $item) {
            foreach (str_split($item) as $x => $char) {
                if ($char === '#') {
                    $map[$x . ';' . $y - 1] = true;
                }
                if ($char === '^') {
                    $position = [$x, $y - 1];
                }
            }
        }
        $yMax = $y;
        $xMax = strlen($item);
        $rotate = [[0, -1, '^'], [1, 0, '>'], [0, 1, 'v'], [-1, 0, '<']];
        $step = 0;
        $result = 0;

        for ($x = 0; $x < $xMax; $x++) {
            for ($y = 0; $y < $yMax; $y++) {
                if (isset($map[$x . ';' . $y]) || ($x === $position[0] && $y === $position[1])) {
                    continue;
                }
                $newMap = $map;
                $newMap[$x . ';' . $y] = true;
                if($this->walkUntilSamePoint($position, $rotate, $step, $newMap, $xMax, $yMax))
                {
                    $result++;
                }
            }
        }

        return $result;
    }

    private function walkUntilSamePoint(array $position, array $rotate, int $step, array $map, int $xMax, int $yMax): bool
    {
        $visited = [];
        do {
            if (!isset($visited[$position[0] . ';' . $position[1] . ';' . $step])) {
                $visited[$position[0] . ';' . $position[1] . ';' . $step] = true;
            }
            $next = $this->nextPosition($position, $rotate[$step]);
            if (isset($map[$next[0] . ';' . $next[1]])) {
                $step++;
                $step = $step % 4;
                continue;
            }
            if ($next[0] < 0 || $next[0] >= $xMax || $next[1] < 0 || $next[1] >= $yMax) {
                return false;
            }
            if (isset($visited[$next[0] . ';' . $next[1] . ';' . $step])) {
                return true;
            }

            $position = $next;
        } while (true);

        return false;
    }

    private function nextPosition(array $position, array $step): array
    {
        return [$position[0] + $step[0], $position[1] + $step[1]];
    }
}
