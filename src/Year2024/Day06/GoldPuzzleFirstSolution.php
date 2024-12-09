<?php

namespace AdventOfCode\Year2024\Day06;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class GoldPuzzleFirstSolution implements PuzzleResolver
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
//        $this->printMap([], $xMax, $yMax, [], $map);
//        var_export($position);
        $visited = [];
        $rotate = [[0, -1, '^'], [1, 0, '>'], [0, 1, 'v'], [-1, 0, '<']];
        $step = 0;
        $onMap = true;
        $result = 0;
        $obstacles = [];
        $count = 0;
        do {
//            echo $count . ': ' . $position[0] . ';' . $position[1] . PHP_EOL;
            $count++;
            if (!isset($visited[$position[0] . ';' . $position[1] . ';' . $step])) {
                $visited[$position[0] . ';' . $position[1] . ';' . $step] = true;
            }
//            $visited[$position[0] . ';' . $position[1] . ';' . $step] = [$rotate[$step][2], $visited[$position[0] . ';' . $position[1] . ';' . $step][1] + 1];
            $next = $this->nextPosition($position, $rotate[$step]);
            if (isset($map[$next[0] . ';' . $next[1]])) {
                $step++;
                $step = $step % 4;
                continue;
            }
            if ($next[0] < 0 || $next[0] >= $xMax || $next[1] < 0 || $next[1] >= $yMax) {
                $onMap = false;
            } else {
//                if (isset($visited[$next[0] . ';' . $next[1]]) && $visited[$next[0] . ';' . $next[1]][0] === $rotate[($step+1)%4][2]) {
//                    $nextNext = $this->nextPosition($next, $rotate[$step]);
//                    $obstacles[] = $nextNext;
//                    $result++;
//                } else {
                if ($this->walkUntilSamePoint($position, $rotate, $step, $map, $xMax, $yMax)
                    && !isset($visited[$next[0] . ';' . $next[1] . ';' . 0])
                    && !isset($visited[$next[0] . ';' . $next[1] . ';' . 1])
                    && !isset($visited[$next[0] . ';' . $next[1] . ';' . 2])
                    && !isset($visited[$next[0] . ';' . $next[1] . ';' . 3])
                ) {
                    $obstacles[] = $this->nextPosition($position, $rotate[$step]);
                    $result++;
                }
//                }
                $position = $next;
            }
        } while ($onMap);

        $uniq = [];
//        var_export(count($obstacles));
        sort($obstacles);
        foreach ($obstacles as [$x, $y]) {
            $uniq[$x . ' ' . $y] = true;
        }

//        $this->printMap($visited, $xMax, $yMax, $obstacles, $map);
//        var_export($uniq);

        return count($uniq);
    }

    private function walkUntilSamePoint(array $position, array $rotate, int $step, array $map, int $xMax, int $yMax): bool
    {
        $visited = [];
        $onMap = true;
        $next = $this->nextPosition($position, $rotate[$step]);
        if ($next[0] < 0 || $next[0] >= $xMax || $next[1] < 0 || $next[1] >= $yMax) {
            return false;
        }
        $map[$next[0] . ';' . $next[1]] = true;
        $obstacle = [$next];
        $result = false;
        do {
            if (!isset($visited[$position[0] . ';' . $position[1] . ';' . $step])) {
                $visited[$position[0] . ';' . $position[1] . ';' . $step] = true;
            }
            //$visited[$position[0] . ';' . $position[1] . ';' . $step] = [$rotate[$step][2], $visited[$position[0] . ';' . $position[1] . ';' . $step][1] + 1];
            $next = $this->nextPosition($position, $rotate[$step]);
            if (isset($map[$next[0] . ';' . $next[1]])) {
                $step++;
                $step = $step % 4;
                continue;
            }
            if ($next[0] < 0 || $next[0] >= $xMax || $next[1] < 0 || $next[1] >= $yMax) {
                $onMap = false;
                $result = false;
            } else {
                if (isset($visited[$next[0] . ';' . $next[1] . ';' . $step])) {
                    $result = true;
                    break;
                }
                $position = $next;
            }
        } while ($onMap);

//        if ($result) {
//            $this->printMap($visited, $xMax, $yMax, $obstacle, $map);
//        }

        return $result;
    }

    private function nextPosition(array $position, array $step): array
    {
        return [$position[0] + $step[0], $position[1] + $step[1]];
    }

    private function printMap(array $map, int $maxX, int $maxY, array $obstacles, array $map2): void
    {
        for ($y = 0; $y < $maxY; $y++) {
            for ($x = 0; $x < $maxX; $x++) {
                if (in_array([$x, $y], $obstacles)) {
                    echo "\e[1;37;42m@\e[0m";
                } elseif (isset($map[$x . ';' . $y . ';' . '0'])) {
                    echo '^';
                } elseif (isset($map[$x . ';' . $y . ';' . '1'])) {
                    echo '>';
                } elseif (isset($map[$x . ';' . $y . ';' . '2'])) {
                    echo 'v';
                } elseif (isset($map[$x . ';' . $y . ';' . '3'])) {
                    echo '<';
                } elseif (isset($map2[$x . ';' . $y])) {
                    echo '#';
                } else {
                    echo '.';
                }
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }
}
