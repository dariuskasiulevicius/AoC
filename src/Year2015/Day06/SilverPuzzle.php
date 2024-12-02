<?php

namespace AdventOfCode\Year2015\Day06;

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

        }
        $map = [
            0   => 6,
            1   => 2,
            2   => 5,
            3   => 5,
            4   => 4,
            5   => 5,
            6   => 6,
            7   => 3,
            8   => 7,
            9   => 6,
            ':' => 1,
        ];

        $toTime = strtotime('1970-01-01T4:00:00');
        $sum = 0;

        for ($i = 0; $i < $toTime; $i++) {
            $string = date('h:i:s', $i);
            foreach (str_split($string) as $char) {
                if(!isset($map[$char])) {
                    throw new \Exception('error on map');
                }
                $sum += $map[$char];
            }
        }

        return $sum;
    }
}
