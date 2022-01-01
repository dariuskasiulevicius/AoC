<?php

namespace AdventOfCode\Year2015\Day01;

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
            $chars = str_split($item);
        }
        $floor = 0;
        foreach ($chars as $step => $char) {
            $result = $step + 1;
            switch ($char) {
                case '(':
                    $floor++;
                    break;
                case ')':
                    $floor--;
                    break;
            }
            if($floor === -1) {
                break;
            }
        }

        return $result;
    }
}
