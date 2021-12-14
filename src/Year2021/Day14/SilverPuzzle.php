<?php

namespace AdventOfCode\Year2021\Day14;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $actions = [];
        foreach ($inputData as $item) {
            if (strpos($item, '->') !== false) {
                [$from, $to] = explode(' -> ', $item);
                $actions[$from] = $to;
            } elseif (!empty($item)) {
                $polymer = $item;
            }
        }

        for ($step = 0; $step < 10; $step++) {
            $next = '';
            $lenght = strlen($polymer) - 1;
            for ($position = 0; $position < $lenght; $position++) {
                $pair = $polymer[$position] . $polymer[$position + 1];
                $next .= $polymer[$position] . $actions[$pair];
            }
            $polymer = $next . $polymer[$position];
        }

        $counts = count_chars($polymer, 1);
        sort($counts);

        return end($counts) - $counts[0];
    }
}
