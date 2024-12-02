<?php

namespace AdventOfCode\Year2023\Day01;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            $org = $item;
            $len = strlen($item);
            for ($i = 1; $i < $len; $i++) {
                $subString = substr($item, 0, $i);
                preg_match('/[1-9]/', $subString, $matches);
                if (!empty($matches)) {
                    break;
                }
                $replaced = str_replace([
                    'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'
                ], [
                    '1', '2', '3', '4', '5', '6', '7', '8', '9'
                ], $subString);
                if ($subString !== $replaced) {
                    $item = $replaced . substr($item, $i);
                    break;
                }
            }
            $len = strlen($item);
            for ($i = $len-1; $i >= 0; $i--) {
                $subString = substr($item, $i);
                preg_match('/[1-9]/', $subString, $matches);
                if (!empty($matches)) {
                    break;
                }
                $replaced = str_replace([
                    'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'
                ], [
                    '1', '2', '3', '4', '5', '6', '7', '8', '9'
                ], $subString);
                if ($subString !== $replaced) {
                    $item = substr($item, 0, $i) . $replaced;
                    break;
                }
            }


//            $item = str_replace([
//                'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'
//            ], [
//                '1', '2', '3', '4', '5', '6', '7', '8', '9'
//            ], $item);
            $numbers = preg_replace('/[a-z]/', '', $item);
            $step = (int)substr($numbers, 0, 1) * 10 + (int)substr($numbers, -1, 1);
            echo $org . ' ' .$step . PHP_EOL;
            $result += $step;
        }

        return $result;
    }
}
