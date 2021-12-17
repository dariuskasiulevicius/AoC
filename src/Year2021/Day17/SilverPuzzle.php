<?php

namespace AdventOfCode\Year2021\Day17;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $data = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $data[] = explode('..', explode('=', $item)[1]);
        }
        $targetX = array_map('intval', $data[0]);
        $targetY = array_map('intval', $data[1]);

        $maxY = 0;
        for ($x = 1; $x <= $targetX[1]; $x++) {
            for ($y = 1; $y < 500; $y++) {
                [$result, $max] = $this->fire($targetX, $targetY, [$x, $y]);
                if ($result === 0) {
                    $maxY = max($maxY, $max);
                }
            }
        }

        return $maxY;
    }

    /**
     * @param array $targetX
     * @param array $targetY
     * @param array $velocity
     * @return array
     */
    private function fire(array $targetX, array $targetY, array $velocity): array
    {
        $position = [0, 0];
        $goal = false;
        $maxY = 0;
        while ($position[0] < $targetX[1] && $position[1] > $targetY[0]) {
            $position[0] += $velocity[0];
            $position[1] += $velocity[1];
            $maxY = max($maxY, $position[1]);
            if ($velocity[0] > 0) {
                $velocity[0]--;
            } elseif ($velocity[0] < 0) {
                $velocity[0]++;
            }
            $velocity[1]--;
            if ($position[0] >= $targetX[0] && $position[0] <= $targetX[1]
                && $position[1] >= $targetY[0] && $position[1] <= $targetY[1]) {
                $goal = true;
                break;
            }
        }

        $result = -1;
        if ($goal) {
            $result = 0;
            if ($position[0] < $targetX[0]) {
                $result = -1;
            } elseif ($position[0] > $targetX[1]) {
                $result = 1;
            } elseif ($position[1] < $targetY[0]) {
                $result = 2;
            }
        }

        return [$result, $maxY];
    }
}