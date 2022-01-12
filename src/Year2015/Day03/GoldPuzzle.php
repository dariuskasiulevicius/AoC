<?php

namespace AdventOfCode\Year2015\Day03;

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
            $data = str_split($item);
        }

        $map = [];
        $x = [0, 0];
        $y = [0, 0];
        $map[$y[0]][$x[0]] = 1;
        $turn = 0;
        foreach ($data as $char) {
            $turn = $turn % 2;
            switch ($char){
                case '>':
                    $x[$turn]++;
                    break;
                case '<':
                    $x[$turn]--;
                    break;
                case '^':
                    $y[$turn]++;
                    break;
                case 'v':
                    $y[$turn]--;
                    break;
            }
            $map[$y[$turn]][$x[$turn]] = 1;
            $turn++;
        }

        return array_sum(array_map('array_sum', $map));
    }
}
