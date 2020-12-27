<?php

namespace AdventOfCode\Year2020\Day06;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $answer = '';
        $lines = 0;

        foreach ($inputData as $item) {
            if (empty($item)) {
                foreach (count_chars($answer, 1) as $countChar) {
                    if ($lines === $countChar) {
                        $result++;
                    }
                }
                $answer = '';
                $lines = 0;
            } else {
                $answer .= $item;
                $lines++;
            }
        }
        foreach (count_chars($answer, 1) as $countChar) {
            if ($lines === $countChar) {
                $result++;
            }
        }

        return $result;
    }
}
