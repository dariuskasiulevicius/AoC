<?php

namespace AdventOfCode\Year2020\Day10;

ini_set('memory_limit', '200G');

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class GoldPuzzle3 implements PuzzleResolver
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
        $three = 0;
        $variations = [[0]];
        for ($i = 0; $i < count($items); $i++) {
            foreach ($variations as $key => $var) {
                $volt = end($var);
                if ($items[$i] - $volt <= 3) {
                    $new = $var;
                    $new[] = $items[$i];
                    $variations[] = $new;
                } else {
                    unset($variations[$key]);
                }

            }
        }
        $last =end($items);
        foreach ($variations as $key => $var) {
            if (end($var) !== $last){
                unset($variations[$key]);
            }
        }
        $result = count($variations);

        return $result;
    }
}
