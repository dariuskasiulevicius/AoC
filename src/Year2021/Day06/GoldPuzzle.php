<?php

namespace AdventOfCode\Year2021\Day06;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        foreach ($inputData as $item) {
            $fishes = array_map('intval', explode(",", $item));
        }
        $map = [];
        foreach ($fishes as $fish) {
            if(!isset($map[$fish])) {
                $map[$fish] = 0;
            }
            $map[$fish]++;
        }

        for ($day = 0; $day < 256; $day++) {
            ksort($map);
            $new = [];
            foreach ($map as $age => $count) {
                $age--;
                $new[$age] = $count;
            }
            if (isset($new[-1])) {
                if(!isset($new[6])) {
                    $new[6] = 0;
                }
                $new[6] += $new[-1];
                $new[8] = $new[-1];
                unset($new[-1]);
            }
            $map = $new;
        }

        return array_sum($map);
    }
}
