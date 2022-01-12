<?php

namespace AdventOfCode\Year2015\Day03;

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
            $data = str_split($item);
        }

        $map = [];
        $x = 0;
        $y = 0;
        $map[$y][$x] = 1;
        foreach ($data as $char) {
            switch ($char){
                case '>':
                    $x++;
                    break;
                case '<':
                    $x--;
                    break;
                case '^':
                    $y++;
                    break;
                case 'v':
                    $y--;
                    break;
            }
            $map[$y][$x] = 1;
        }

        return array_sum(array_map('array_sum', $map));
    }
}
