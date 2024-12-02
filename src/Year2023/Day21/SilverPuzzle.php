<?php

namespace AdventOfCode\Year2023\Day21;

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
        $start = null;
        foreach ($inputData as $y => $item) {
            $y--;
            foreach (str_split($item) as $x => $char) {
                if ($char === 'S') {
                    $char = '.';
                    $start = [$x, $y];
                }
                if ($char === '.') {
                       $map[$this->getKey($x, $y)] = 1;
                }
            }
        }

        $moves = 10;
        $points = [$this->getKey($start[0], $start[1]) => $start];
        for ($i = 0; $i < $moves; $i++) {
            $tmp = [];
            foreach ($points as $point) {
                $tmp = array_merge($tmp, $this->move($point, $map));
            }
            $points = $tmp;
        }

        return count($points);
    }

    private function move($point, $map)
    {
        $diff = [[0, 1], [1, 0], [0, -1], [-1, 0]];
        $res = [];
        foreach ($diff as $item) {
            $x = $point[0] + $item[0];
            $y = $point[1] + $item[1];
            if (isset($map[$this->getKey($x, $y)])) {
                $res[$this->getKey($x, $y)] = [$x, $y];
            }
        }
        return $res;
    }

    private function getKey($x, $y)
    {
        return $x . '-' . $y;
    }
}
