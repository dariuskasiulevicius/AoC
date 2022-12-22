<?php

namespace AdventOfCode\Year2022\Day22;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    private array $point = [];
    private string $facing = 'E';
    private array $map = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $empty = false;
        $actionLine = [];
        foreach ($inputData as $item) {
            if (empty($item)) {
                $empty = true;
                continue;
            }
            if (!$empty) {
                $item = $inputData->getFullLine();
                $line = str_split($item, 1);
                $this->map[] = array_filter($line, 'trim');
            } else {
                preg_match_all('/\d+[RL]?/', $item, $matches);
                foreach ($matches[0] as $match) {
                    if ($match[strlen($match) - 1] === 'R' || $match[strlen($match) - 1] === 'L') {
                        $actionLine[] = (int)substr($match, 0, -1);
                        $actionLine[] = $match[strlen($match) - 1];
                    } else {
                        $actionLine[] = (int)$match;
                    }
                }
            }
        }

        $this->point = [array_key_first($this->map[0]), 0];

        foreach ($actionLine as $key => $item) {
            if (is_int($item)) {
                $this->move($item);
            } else {
                $this->rotate($item);
            }
        }

        $faceSide = ['E' => 0, 'S' => 1, 'W' => 2, 'N' => 3];

        return 1000 * ($this->point[1] + 1) + 4 * ($this->point[0] + 1) + $faceSide[$this->facing];
    }

    private function move($steps)
    {
        for ($i = 0; $i < $steps; $i++) {
            switch ($this->facing) {
                case 'E':
                    $offset = [1, 0];
                    break;
                case 'W':
                    $offset = [-1, 0];
                    break;
                case 'N':
                    $offset = [0, -1];
                    break;
                case 'S':
                    $offset = [0, 1];
                    break;
            }
            $newPoint = [$this->point[0] + $offset[0], $this->point[1] + $offset[1]];
            $valid = $this->validMapPoint($newPoint);
            if ($valid === 'empty') {
                $this->point = $newPoint;
            } elseif ($valid === 'wall') {
                break;
            } elseif ($valid === 'space') {
                $jumpPoint = $this->jump($newPoint);
                if ($jumpPoint[0] === $newPoint[0] && $jumpPoint[1] === $newPoint[1]) {
                    break;
                }
                $this->point = $jumpPoint;
            }
        }
    }

    private function jump($point)
    {
        // transform coordinates
        [$x, $y] = $point;
        if (
            $y >= 0 && $y <= 49
            && $x >= 150
            && $this->facing === 'E'
        ) {
            // 2 -> 5
            $newPoint = [99, abs($point[1] - 149)];
            $newFacing = 'W';
        } elseif (
            // 5 -> 2
            $y >= 100 && $y <= 149
            && $x >= 100
            && $this->facing === 'E'
        ) {
            $newPoint = [149, abs($point[1] - 149)];
            $newFacing = 'W';
        } elseif (
            // 2 -> 3
            $y >= 50
            && $x >= 100 && $x <= 149
            && $this->facing === 'S'
        ) {
            $newPoint = [99, $point[0] - 50];
            $newFacing = 'W';
        } elseif (
            // 3 -> 2
            $y >= 50 && $y <= 99
            && $x >= 100
            && $this->facing === 'E'
        ) {
            $newPoint = [$point[1] + 50, 49];
            $newFacing = 'N';
        } elseif (
            // 5 -> 6
            $y >= 150
            && $x >= 50 && $x <= 99
            && $this->facing === 'S'
        ) {
            $newPoint = [49, $point[0] + 100];
            $newFacing = 'W';
        } elseif (
            // 6 -> 5
            $y >= 150 && $y <= 199
            && $x >= 50
            && $this->facing === 'E'
        ) {
            $newPoint = [$point[1] -100, 149];
            $newFacing = 'N';
        } elseif (
            // 6 -> 2
            $y >= 200
            && $x >= 0 && $x <= 49
            && $this->facing === 'S'
        ) {
            $newPoint = [$point[0] + 100, 0];
            $newFacing = 'S';
        } elseif (
            // 2 -> 6
            $y <= -1
            && $x >= 100 && $x <= 149
            && $this->facing === 'N'
        ) {
            $newPoint = [$point[0] - 100, 199];
            $newFacing = 'N';
        } elseif (
            // 6 -> 1
            $y >= 150 && $y <= 199
            && $x <= -1
            && $this->facing === 'W'
        ) {
            $newPoint = [$point[1] - 100, 0];
            $newFacing = 'S';
        } elseif (
            // 1 -> 6
            $y <= -1
            && $x >= 50 && $x <= 99
            && $this->facing === 'N'
        ) {
            $newPoint = [0, $point[0] + 100];
            $newFacing = 'E';
        } elseif (
            // 4 -> 1
            $y >= 100 && $y <= 149
            && $x <= -1
            && $this->facing === 'W'
        ) {
            $newPoint = [50, abs($point[1] - 149)];
            $newFacing = 'E';
        } elseif (
            // 1 -> 4
            $y >= 0 && $y <= 49
            && $x <= 49
            && $this->facing === 'W'
        ) {
            $newPoint = [0, abs($point[1] - 149)];
            $newFacing = 'E';
        } elseif (
            // 4 -> 3
            $y <= 99
            && $x >= 0 && $x <= 49
            && $this->facing === 'N'
        ) {
            $newPoint = [50, $point[0] + 50];
            $newFacing = 'E';
        } elseif (
            // 3 -> 4
            $y >= 50 && $y <= 99
            && $x <= 49
            && $this->facing === 'W'
        ) {
            $newPoint = [$point[1] - 50, 100];
            $newFacing = 'S';
        } else {
            throw new \Exception('Wrong turn');
        }

        $valid = $this->validMapPoint($newPoint);
        if ($valid === 'wall') {
            return $point;
        }
        if ($valid === 'empty') {
            $this->facing = $newFacing;
            return $newPoint;
        }
        if ($valid === 'space') {
            throw new \Exception('Imposible');
        }
    }

    private function validMapPoint($point)
    {
        if (isset($this->map[$point[1]][$point[0]])) {
            if ($this->map[$point[1]][$point[0]] === '#') {
                return 'wall';
            }
            return 'empty';
        }

        return 'space';
    }

    private function rotate($side)
    {
        $rotateMap = [
            'L' => ['E' => 'N', 'N' => 'W', 'W' => 'S', 'S' => 'E'],
            'R' => ['E' => 'S', 'S' => 'W', 'W' => 'N', 'N' => 'E'],
        ];
        $this->facing = $rotateMap[$side][$this->facing];
    }
}
