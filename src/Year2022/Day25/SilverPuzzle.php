<?php

namespace AdventOfCode\Year2022\Day25;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $map = [
            '0' => 0,
            '1' => 1,
            '2' => 2,
            '-' => -1,
            '=' => -2,
        ];
        $reverseMap = [
            0 => '0',
            1 => '1',
            2 => '2',
            3 => '=',
            4 => '-',
            5 => '0',
        ];
        $result = 0;
        foreach ($inputData as $item) {
            //your custom code goes here
            $symbols = str_split($item);
            $symbols = array_reverse($symbols);
            $num = 0;
            foreach ($symbols as $i => $iValue) {
                $r = (5 ** $i) * $map[$iValue];
                $num += $r;
            }
            $result += $num;
        }

        $string = '';
        $prev = 0;
        while ($result > 0) {
            $i = $result % 5;
            $result = ($result - $i) / 5;
            $i += $prev;
            $cur = $reverseMap[$i];
            $string = $cur . $string;
            if ($i >= 3) {
                $prev = 1;
            } else {
                $prev = 0;
            }

        }

        return $string;
    }
}
