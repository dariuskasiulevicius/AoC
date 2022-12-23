<?php

namespace AdventOfCode\Year2022\Day17;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    private array $jets = [];
    private int $count = 0;
    private array $map = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        foreach ($inputData as $item) {
            //your custom code goes here
            $this->jets = str_split($item, 1);
        }
        $rocks = [
            [[0, 0], [1, 0], [2, 0], [3, 0]],
            [[1, 0], [0, 1], [1, 1], [2, 1], [1, 2]],
            [[0, 0], [1, 0], [2, 0], [2, 1], [2, 2]],
            [[0, 0], [0, 1], [0, 2], [0, 3]],
            [[0, 0], [1, 0], [0, 1], [1, 1]],
        ];
        $limit = 1000000000000;
        $count = 0;
        $heightDiff = [];
        $moved = false;
        do {
            $number = $count % 5;
            $before = array_key_last($this->map);
            $this->dropRock($rocks[$number]);
            $heightDiff[] = array_key_last($this->map) - $before;
            $count++;
            if ($moved === false) {
                $pattern = $this->findPattern();
                if (false !== $pattern) {
                    $countHeight = 0;
                    $countDelta = 0;
                    $lastKey = array_key_last($heightDiff);
                    while ($countHeight < $pattern && $lastKey > 0) {
                        $countHeight += $heightDiff[$lastKey];
                        $countDelta++;
                        $lastKey--;
                    }

                    $delta = floor(($limit - $count) / $countDelta) - 1;
                    $count += $delta * $countDelta;
                    $this->modifyMap($delta * $countHeight);
                    $moved = true;
                }
            }
        } while ($count < $limit);

        return array_key_last($this->map);
    }

    private function findPattern()
    {
        $result = false;
        $numbers = [];
        $last = array_key_last($this->map);
        $first = array_key_first($this->map);
        for ($y = $last; $y >= $first; $y--) {
            $line = $this->map[$y];
            $byte = '';
            for ($x = 0; $x <= 7; $x++) {
                if (isset($line[$x])) {
                    $byte .= '1';
                } else {
                    $byte .= '0';
                }
            }
            $numbers[] = bindec($byte);
        }
        $slow = 0;
        $fast = $fastStart = 10;
        while ($slow < $fastStart && $fast < $last) {
            while ($fast < $last && $numbers[$slow] !== $numbers[$fast]) {
                $fast++;
            }
            $fastStart = $fast;
            $identical = true;
            for ($i = $slow; $i < $fast; $i++) {
                if (!isset($numbers[$fast + $i]) || $numbers[$i] !== $numbers[$fast + $i]) {
                    $identical = false;
                    break;
                }
            }
            if ($identical) {
                $result = $fastStart;
                break;
            }
            $fast++;
        }

        return $result;
    }

    private function dropRock($rock)
    {
        $position = [2, 3];
        $offset = array_key_last($this->map);
        $position[1] += ($offset ?? 0) + 1;

        $rock = $this->rockOffset($rock, $position);
        do {
            $rock = $this->jetPush($rock);
            //rock falls
            $newRock = $this->rockOffset($rock, [0, -1]);
            $valid = $this->validMove($newRock);
            if ($valid) {
                $rock = $newRock;
            } else {
                $this->addToMap($rock);
            }
        } while ($valid);
    }

    private function addToMap($rock)
    {
        foreach ($rock as $item) {
            $this->map[$item[1]][$item[0]] = '#';
        }
    }

    private function modifyMap($delta)
    {
        $newMap = [];
        foreach ($this->map as $key => $item) {
            $newMap[$key + $delta] = $item;
        }
        $this->map = $newMap;
        unset($newMap);
    }

    private function validMove($rock)
    {
        foreach ($rock as $item) {
            if (isset($this->map[$item[1]][$item[0]]) || $item[1] < 1) {
                return false;
            }
        }
        return true;
    }

    private function rockOffset($rock, $offset)
    {
        $newRock = [];
        foreach ($rock as $item) {
            $newRock[] = [$item[0] + $offset[0], $item[1] + $offset[1]];
        }

        return $newRock;
    }

    private function jetPush($rock)
    {
        $side = $this->jets[$this->count % count($this->jets)];
        if ($side === '<') {
            $offset = [-1, 0];
        } else {
            $offset = [1, 0];
        }
        $result = $rock;
        $newRock = $this->rockOffset($rock, $offset);
        if ($this->validSide($newRock) && $this->validMove($newRock)) {
            $result = $newRock;
        }
        $this->count++;

        return $result;
    }

    private function validSide($rock)
    {
        foreach ($rock as $item) {
            if ($item[0] < 0 || $item[0] > 6) {
                return false;
            }
        }
        return true;
    }
}
