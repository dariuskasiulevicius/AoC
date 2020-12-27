<?php

namespace AdventOfCode\Year2020\Day06;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $answer = '';

        foreach ($inputData as $item) {
            if (empty($item)) {
                foreach (count_chars($answer, 1) as $countChar) {
                    $result++;
                }
                $answer = '';
            } else {
                $answer .= $item;
            }
        }
        foreach (count_chars($answer, 1) as $countChar) {
            $result++;
        }


        return $result;
    }
}
