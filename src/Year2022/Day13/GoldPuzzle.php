<?php

namespace AdventOfCode\Year2022\Day13;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $packets = [];
        $left = $right = '';
        foreach ($inputData as $item) {
            //your custom code goes here
            $parts = explode(';', $item);
            eval('$left=' . $parts[0] . ';');
            eval('$right=' . $parts[1] . ';');
            $packets[] = $left;
            $packets[] = $right;
        }
        $find = ['[[2]]', '[[6]]'];
        eval('$left=' . $find[0] . ';');
        eval('$right=' . $find[1] . ';');
        $packets[] = $left;
        $packets[] = $right;

//        foreach ($pairs as $key => $pair) {
//            $valid = $this->valid($pair[0], $pair[1]);
//            if (true === $valid) {
//                echo $key + 1;
//                echo PHP_EOL;
//                $result += $key + 1;
//            }
//        }
        usort($packets, [$this, 'valid']);

        $packets = array_map('json_encode', $packets);
        $result = 1;
        foreach ($packets as $key => $item) {
            if(in_array($item, $find)){
                $result *= ($key+1);
            }
        }

        return $result;
    }

    private function valid($aSide, $bSide)
    {
        $i = 0;
        $continue = true;
        do {
            if (isset($aSide[$i]) && is_int($aSide[$i])
                && isset($bSide[$i]) && is_int($bSide[$i])) {
                if ($aSide[$i] < $bSide[$i]) {
                    return -1;
                }
                if ($aSide[$i] > $bSide[$i]) {
                    return 1;
                }
            } elseif (!isset($aSide[$i]) && isset($bSide[$i])) {
                return -1;
            } elseif (isset($aSide[$i]) && !isset($bSide[$i])) {
                return 1;
            } elseif (!isset($aSide[$i]) && !isset($bSide[$i])) {
                $continue = false;
            } elseif (is_array($aSide[$i]) || is_array($bSide[$i])) {
                if (!is_array($aSide[$i])) {
                    $aSide[$i] = [$aSide[$i]];
                }
                if (!is_array($bSide[$i])) {
                    $bSide[$i] = [$bSide[$i]];
                }
                $valid = $this->valid($aSide[$i], $bSide[$i]);
                if (0 !== $valid) {
                    return $valid;
                }
            }
            $i++;
        } while ($continue);

        return 0;
    }
}
