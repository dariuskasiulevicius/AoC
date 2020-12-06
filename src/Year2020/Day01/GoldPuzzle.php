<?php

namespace AdventOfCode\Year2020\Day01;

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
        $items = $inputData->getAllLines();

        $len = count($items);
        for($index1 = 0; $index1 < $len; $index1++) {
            $value1 = $items[$index1];
            $from2 = $index1 + 1;
            for ($index2 = $from2; $index2 < $len; $index2++) {
                $value2 = $items[$index2];
                $from3 = $index2 + 1;
                for ($index3 = $from3; $index3 < $len; $index3++){
                    $value3 = $items[$index3];
                    if ($value1 + $value2 + $value3 == 2020) {
                        $result = $value1 * $value2 * $value3;
                        break 3;
                    }
                }
            }
        }


        return $result;
    }
}
