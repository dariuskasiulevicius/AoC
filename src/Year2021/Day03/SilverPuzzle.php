<?php

namespace AdventOfCode\Year2021\Day03;

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
        $counts = null;
        $total = 0;
        foreach ($inputData as $item) {
            if ($counts === null) {
                $counts = array_fill(0, strlen($item), 0);
            }
            $items = str_split($item);
            foreach ($items as $index => $val) {
                if ((int)$val === 1) {
                    $counts[$index]++;
                }
            }
            $total++;
        }

        $half = $total / 2;

        $gamma = "";
        $epsilon = "";
        foreach ($counts as $count) {
            if ($count > $half) {
                $gamma .= "1";
                $epsilon .= "0";
            } else {
                $gamma .= "0";
                $epsilon .= "1";
            }
        }

        $result = bindec($gamma) * bindec($epsilon);

        return $result;
    }
}
