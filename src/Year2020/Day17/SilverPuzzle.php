<?php

namespace AdventOfCode\Year2020\Day17;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $items = [];
        foreach ($inputData as $y => $item) {
//            $items[0][$y] = str_pad($item, strlen($item) + 2*6, '.',STR_PAD_BOTH);
            $items[0][$y - 1] = str_split($item, 1);
        }
//        $items[-1] = $items[0];
//        $items[1] = $items[0];
        $newField = [];
        $max = count($items[0]) + 1;
        $min = -1;
        for ($k = 1; $k <= 6; $k++) {
            for ($z = $min; $z < $max; $z++) {
                for ($y = $min; $y < $max; $y++) {
                    for ($x = $min; $x < $max; $x++) {
                        $state = '.';
                        if (isset($items[$z][$y][$x])) {
                            $state = $items[$z][$y][$x];
                        }
                        $active = $this->getActive($items, $x, $y, $z);
                        if ($state === '#' && $active >= 2 && $active <= 3) {
                            $newField[$z][$y][$x] = '#';
                        } elseif ($state === '.' && $active === 3) {
                            $newField[$z][$y][$x] = '#';
                        } else {
                            $newField[$z][$y][$x] = '.';
                        }
//                        } else {
//                            $newField[$z][$y][$x] = '.';
//                        }
                    }
                }
            }
            $min--;
            $max++;
            $items = $newField;
        }
//        $result = $newField;
        foreach ($newField as $zz) {
            foreach ($zz as $yy) {
                foreach ($yy as $xx) {
                    if ($xx === '#'){
                        $result++;
                    }
                }
            }
        }


        return $result;
    }

    protected function getActive($items, $x, $y, $z)
    {
        $minz = $z - 1;
        $maxz = $z + 1;
        $minx = $x - 1;
        $maxx = $x + 1;
        $miny = $y - 1;
        $maxy = $y + 1;
        $active = 0;
        $iter = 0;
        for ($iz = $minz; $iz <= $maxz; $iz++) {
            for ($iy = $miny; $iy <= $maxy; $iy++) {
                for ($ix = $minx; $ix <= $maxx; $ix++) {
                    $iter++;
                    if (!($iz === $z && $iy === $y && $ix === $x)
                        && isset($items[$iz][$iy][$ix])
                        && ($items[$iz][$iy][$ix]) === '#') {
                        $active++;
                    }
                }
            }
        }

        return $active;
    }
}
