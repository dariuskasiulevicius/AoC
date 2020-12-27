<?php

namespace AdventOfCode\Year2020\Day10;

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
        $items = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $items[] = (int)$item;
        }

        sort($items);
        $items[] = end($items) + 3;
        $start = 0;
        $one = 0;
        $two = 0;
        $three = 0;
        for ($i = 0; $i < count($items); $i++) {
            if ($items[$i] - $start === 1) {
                $one++;
            } elseif ($items[$i] - $start === 3) {
                $three++;
            } elseif ($items[$i] - $start === 2) {
                $two++;
            }

            $start = $items[$i];
        }
//        var_export($one);
//        echo PHP_EOL;
//        var_export($two);
//        echo PHP_EOL;
//        var_export($three);
//        echo PHP_EOL;
//        exit;

        return $one * $three;
    }
}
