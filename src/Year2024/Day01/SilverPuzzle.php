<?php

namespace AdventOfCode\Year2024\Day01;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $list1 = $list2 = [];
        foreach ($inputData as $item) {
            [$item1, $item2] = explode('   ', $item);
            $list1[] = (int) $item1;
            $list2[] = (int) $item2;
        }

        sort($list1);
        sort($list2);

        foreach ($list1 as $key => $item) {
            $result += abs($list2[$key] - $item);
        }

        return $result;
    }
}
