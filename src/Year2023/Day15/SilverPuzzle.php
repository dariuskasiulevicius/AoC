<?php

namespace AdventOfCode\Year2023\Day15;

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
        foreach ($inputData as $item) {
            $codes = explode(',', $item);
        }

        foreach ($codes as $code) {
            $result += $this->getValue($code);
        }

        return $result;
    }

    private function getValue($code)
    {
        $iMax = strlen($code);
        $cur = 0;
        for ($i = 0; $i < $iMax; $i++) {
            $cur += ord($code[$i]);
            $cur *= 17;
            $cur %= 256;
        }

        return $cur;
    }
}
