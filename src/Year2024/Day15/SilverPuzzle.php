<?php

namespace AdventOfCode\Year2024\Day15;

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
        $next = false;
        $map = [];
        $pos = [];
        $actions = '';
        foreach ($inputData as $key => $item) {
            $y = $key - 1;
            if (empty($item)) {
                $next = true;
            } elseif ($next) {
                $actions .= $item;
            } else {
                foreach (str_split($item) as $x => $char) {
                    if ($char === '@') {
                        $pos = [$x, $y];
                    } elseif ($char !== '.') {
                        $map[$this->getKey($x, $y)] = $char;
                    }
                }
            }
        }
        $steps = ['v' => [0, 1], '>' => [1, 0], '^' => [0, -1], '<' => [-1, 0]];
        foreach (str_split($actions) as $step) {
            [$xEmpty, $yEmpty] = $this->getEmptyCell($map, $pos, $steps[$step]);
            if ($xEmpty !== 0 && $yEmpty !== 0) {
                $pos[0] += $steps[$step][0];
                $pos[1] += $steps[$step][1];
                $key = $this->getKey($pos[0], $pos[1]);
                if (isset($map[$key])) {
                    unset($map[$key]);
                    $map[$this->getKey($xEmpty, $yEmpty)] = 'O';
                }
            }
        }

        foreach ($map as $key => $item) {
            if ($item === 'O') {
                [$x, $y] = $this->splitKey($key);
                $result += 100 * $y + $x;
            }
        }


        return $result;
    }

    private function getEmptyCell(array $map, array $pos, array $step): array
    {
        $continue = true;
        $x = $pos[0];
        $y = $pos[1];
        do {
            $x += $step[0];
            $y += $step[1];
            $key = $this->getKey($x, $y);
            if (isset($map[$key]) && $map[$key] === '#') {
                return [0, 0];
            } elseif (isset($map[$key]) && $map[$key] === 'O') {
                $continue = true;
            } else {
                $continue = false;
            }
        } while ($continue);

        return [$x, $y];
    }

    private function getKey(int $x, int $y)
    {
        return $x . ';' . $y;
    }

    private function splitKey(string $key): array
    {
        return explode(';', $key);
    }
}
