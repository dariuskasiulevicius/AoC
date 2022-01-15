<?php

namespace AdventOfCode\Year2015\Day05;

use AdventOfCode\Year2015\DataInput;
use AdventOfCode\Year2015\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
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
        $chars = count_chars($line, 1);
        $vowels = 0;
        foreach (['a', 'e', 'i', 'o', 'u'] as $letter) {
            $key = ord($letter);
            if (isset($chars[$key])) {
                $vowels += $chars[$key];
            }
        }
        if ($vowels < 3) {
            return false;
        }

        $hasIdentical = false;
        $prev = null;
        foreach (str_split($line) as $letter) {
            if ($prev === $letter) {
                $hasIdentical = true;
                break;
            }
            $prev = $letter;
        }
        if (!$hasIdentical) {
            return false;
        }


        foreach (['ab', 'cd', 'pq', 'xy'] as $item) {
            if (strpos($line, $item) !== false) {
                return false;
            }
        }

        return true;
    }
}
