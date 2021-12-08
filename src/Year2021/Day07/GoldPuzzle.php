<?php

namespace AdventOfCode\Year2021\Day07;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            $crabs = array_map('intval', explode(',', $item));
        }
        $stepsFuel = [];
        $max = max($crabs);
        $min = null;
        for ($position = 0; $position <= $max; $position++) {
            $fuel = 0;
            foreach ($crabs as $crab) {
                $steps = abs($crab - $position);
                for($i = $steps; $i > 0; $i--){
                    $fuel += $i;
                }
            }
            if ($min === null) {
                $min = $fuel;
            }
            $min = min($min, $fuel);
        }


        return $min;
    }
}
