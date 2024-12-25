<?php

namespace AdventOfCode\Year2024\Day22;

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
        $initialNumbers = [];
        foreach ($inputData as $item) {
            $initialNumbers[] = (int)$item;
        }

//        $memory = [];
        foreach ($initialNumbers as $initialNumber) {
            $num = $initialNumber;
            for ($i = 0; $i < 2000; $i++) {
                $num = $this->getNextNumber($num);
            }
            $result += $num;
        }

        return $result;
    }

    private function getNextNumber(int $num): int
    {
        $num = ($num ^ ($num * 64)) % 16777216;
        $num = ($num ^ floor($num /32)) % 16777216;
        $num = ($num ^ ($num * 2048)) % 16777216;

        return $num;
    }
}
