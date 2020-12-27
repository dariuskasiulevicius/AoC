<?php

namespace AdventOfCode\Year2020\Day10;

ini_set('memory_limit', '200G');

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
        $items = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $items[] = (int)$item;
        }

        sort($items);
        $items[] = end($items) + 3;
        array_unshift($items, 0);
        $variations = [0=>1];
        $len = count($items);
        for ($i = 1; $i < $len; $i++) {
            $variations[$i] = 0;
            if ($items[$i] - $items[$i-1] <=3) {
                $variations[$i] += $variations[$i-1];
            }
            if ($i > 1 && $items[$i] - $items[$i-2] <=3) {
                $variations[$i] += $variations[$i-2];
            }
            if ($i > 2 && $items[$i] - $items[$i-3] <=3) {
                $variations[$i] += $variations[$i-3];
            }

//            foreach ($variations as $key => $count) {
//                if ($items[$i] - $key <= 3) {
//                    $variations[$items[$i]] = true;
//                    $counts++;
//                } else {
//                    unset($variations[$key]);
//                    $counts--;
//                }
//
//            }
        }
//        $last =end($items);
//        foreach ($variations as $key => $var) {
//            if ($var !== $last){
//                unset($variations[$key]);
//                $counts--;
//            }
//        }

        $result = end($variations);

        return $result;
    }
}
