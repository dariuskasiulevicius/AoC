<?php

namespace AdventOfCode\Year2024\Day01;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

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
            [$item1, $item2] = explode('   ', $item);
            $item1 = (int) $item1;
            if(!isset($list1[$item1])){
                $list1[$item1] = 0;
            }
            $list1[$item1]++;

            $item2 = (int) $item2;
            if(!isset($list2[$item2])){
                $list2[$item2] = 0;
            }
            $list2[$item2]++;
        }

        foreach ($list1 as $key => $item) {
            if(isset($list2[$key])){
                $result += $item * $list2[$key] * $key;
            }
        }

        return $result;
    }
}
