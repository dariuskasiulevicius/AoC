<?php

namespace AdventOfCode\Year2015\Day02;

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
        $rows = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $rows[] = explode('x', $item);
        }
        foreach ($rows as $row) {
            sort($row);
            $result += 2 * $row[0] + 2 * $row[1] + $row[0] * $row[1] * $row[2];
        }

        return $result;
    }
}
