<?php

namespace AdventOfCode\Year2022\Day13;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $pairs = [];
        $left = $right = '';
        foreach ($inputData as $item) {
            //your custom code goes here
            $parts = explode(';', $item);
            eval('$left=' . $parts[0] . ';');
            eval('$right=' . $parts[1] . ';');
            $pairs[] = [$left, $right];
        }

        foreach ($pairs as $key => $pair) {
            $valid = $this->valid($pair[0], $pair[1]);
            if (true === $valid) {
                echo $key + 1;
                echo PHP_EOL;
                $result += $key + 1;
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
                    return true;
                }
                if ($aSide[$i] > $bSide[$i]) {
                    return false;
                }
            } elseif (!isset($aSide[$i]) && isset($bSide[$i])) {
                return true;
            } elseif (isset($aSide[$i]) && !isset($bSide[$i])) {
                return false;
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
                if (null !== $valid) {
                    return $valid;
                }
            }
            $i++;
        } while ($continue);
        return null;
    }
}
