<?php

namespace AdventOfCode\Year2024\Day06;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
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

        $visited = [];
        $rotate = [[0, -1], [1, 0], [0, 1], [-1, 0]];
        $step = array_shift($rotate);
        $onMap = true;
        do {
            $visited[$position[0] . ';' . $position[1]] = true;
            $next = $this->nextPosition($position, $step);
            if(isset($map[$next[0] . ';' . $next[1]])) {
                $rotate[] = $step;
                $step = array_shift($rotate);
                continue;
            }
            if($next[0] < 0 || $next[0] >= $xMax || $next[1] < 0 || $next[1] >= $yMax) {
                $onMap = false;
            } else {
                $position = $next;
            }
        } while ($onMap);


        return count($visited);
    }

    private function nextPosition(array $position, array $step): array
    {
        return [$position[0] + $step[0], $position[1] + $step[1]];
    }
}
