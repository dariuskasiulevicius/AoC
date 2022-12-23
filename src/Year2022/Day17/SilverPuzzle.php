<?php

namespace AdventOfCode\Year2022\Day17;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
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
        $count = 0;
        do {
            $number = $count % 5;
            $this->dropRock($rocks[$number]);
            $count++;
//            $this->drawMap();
        } while ($count < 2022);

//        $this->drawMap();

        return count($this->map);
    }

    private function dropRock($rock)
    {
        $position = [2, 3];
        $offset = count($this->map);
        $position[1] += $offset;

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

    private function validMove($rock)
    {
        foreach ($rock as $item) {
            if (isset($this->map[$item[1]][$item[0]]) || $item[1] < 0) {
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

    private function drawMap()
    {
        $yy = count($this->map);
        for ($y = $yy; $y >= 0; $y--) {
            for ($x = 0; $x < 7; $x++) {
                if(isset($this->map[$y][$x])){
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
