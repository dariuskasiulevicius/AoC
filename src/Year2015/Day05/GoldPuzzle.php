<?php

namespace AdventOfCode\Year2015\Day05;

use AdventOfCode\Year2015\DataInput;
use AdventOfCode\Year2015\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            //your custom code goes here
            if ($this->isValid($item)) {
                $result++;
            }
        }

        return $result;
    }


    private function isValid($line): bool
    {
        $words = array_merge(str_split($line, 2), str_split(substr($line, 3), 2));
        $count = count($words);
        $valid = false;
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                if ($words[$i] === $words[$j]) {
                    $valid = true;
                    break 2;
                }
            }
        }
        if (!$valid) {
            return false;
        }

        $words = array_merge(str_split($line, 3), str_split(substr($line, 1), 3));
        $valid = false;
        foreach ($words as $word) {
            $letters = str_split($word);
            if (strlen($word) >= 3 && $letters[0] === $letters[2]) {
                $valid = true;
                break;
            }
        }

        return $valid;
    }
}
