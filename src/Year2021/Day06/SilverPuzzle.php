<?php

namespace AdventOfCode\Year2021\Day06;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        foreach ($inputData as $item) {
            $fishes = array_map('intval', explode(",", $item));
        }
        for ($day = 0; $day < 80; $day++) {
            foreach ($fishes as $key => $fish) {
                $fishes[$key]--;
                if ($fishes[$key] === -1) {
                    $fishes[$key] = 6;
                    $fishes[] = 8;
                }
            }
        }

        return count($fishes);
    }
}
