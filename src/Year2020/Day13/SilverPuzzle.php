<?php

namespace AdventOfCode\Year2020\Day13;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $dep = 1006401;
        $result = 0;
        $buses = [];
        $dif = [];
        foreach ($inputData as $item) {
//            //your custom code goes here
        $buses = explode(',', $item);
//
        }
        foreach ($buses as $bus) {
            $bus = (int) $bus;
            if ($bus > 0) {
                $small = ceil($dep / $bus);
                $busFrom = $small * $bus;
                while($busFrom<$dep) {
                    $busFrom += $bus;
                }
                $dif[$bus] = $busFrom - $dep;
            }
        }
        $min = min($dif);
        foreach ($dif as $bus => $value) {
            if ($min === $value) {
                $result = $bus*$value;
                break;
            }
        }


        return $result;
    }

    protected function mbk($x, $y)
    {
        if ($x > $y)
        {
            $temp = $x;
            $x = $y;
            $y = $temp;
        }
        for($i = 1; $i < ($x+1); $i++)
        {
            if ($x%$i == 0 && $y%$i == 0)
                $gcd = $i;
        }

        $lcm = ($x*$y)/$gcd;
        return $lcm;
    }
}
