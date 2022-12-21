<?php

namespace AdventOfCode\Year2022\Day18;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    private $map = [];
    private $sides = 0;

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        foreach ($inputData as $item) {
            //your custom code goes here
            $cube = explode(',', $item);
            $this->addToMap($cube);
        }

        return $this->sides;
    }

    private function addToMap($cube)
    {
        $key = implode(',', $cube);
        if (isset($this->map[$key])) {
            return;
        }
//        [$x, $y, $z] = $cube;
        $this->sides += 6;
        $this->map[$key] = '';

        $transformations = [
            [1, 0, 0], [-1, 0, 0],
            [0, 1, 0], [0, -1, 0],
            [0, 0, 1], [0, 0, -1],
        ];
        foreach ($transformations as $transformation) {
            $point = [
                $cube[0] + $transformation[0],
                $cube[1] + $transformation[1],
                $cube[2] + $transformation[2],
            ];
            $key = implode(',', $point);
            if (isset($this->map[$key])) {
                $this->sides -= 2;
            }
        }
    }
}
