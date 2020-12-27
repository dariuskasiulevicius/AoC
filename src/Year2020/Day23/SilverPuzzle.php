<?php

namespace AdventOfCode\Year2020\Day23;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        return $result = 0;
        $cups = str_split(624397158, 1);
        $max = count($cups);
        $place = 0;
        $move = 1;

        for ($step = 0; $step < 100; $step++) {
            $currentCup = $cups[$place];
            $three = [];
            for ($x = 1; $x <= 3; $x++) {
                $key = ($place + $x) % $max;
                $three[] = $cups[$key];
                unset($cups[$key]);
            }
            $cups = array_values($cups);
            $destinationCupPlace = null;
            $destinationCup = $currentCup - 1;
            if ($destinationCup < 1) {
                $destinationCup += $max;
            }
            do {
                if (in_array($destinationCup, $cups)) {
                    $destinationCupPlace = strpos(implode('', $cups), (string)$destinationCup);
                } else {
                    $destinationCup--;
                    if ($destinationCup < 1) {
                        $destinationCup += $max;
                    }
                }
            } while ($destinationCupPlace === null);

            $destinationCupPlace = $destinationCupPlace + 1;
            $tmp = implode('', $cups);
            $t1 = substr($tmp, 0, $destinationCupPlace);
            $t2 = implode('', $three);
            $t3 = substr($tmp, $destinationCupPlace);
            $tmp = $t1 . $t2 . $t3;
            $cups = str_split($tmp, 1);

            $place = strpos(implode('', $cups), (string)$currentCup);
            $place++;
            $place = $place % $max;
            $move++;
        }

        return implode('', $cups);
    }
}
