<?php

namespace AdventOfCode\Year2023\Day15;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            $codes = explode(',', $item);
        }

        $boxes = [];
        foreach ($codes as $code) {
            $box = $this->getValue($code);
            if (strpos($code, '=') !== false) {
                [$key, $power] = explode('=', $code);
//                if(isset($boxes[$box][$key])){
//                    $boxes[$box][$key] = $power;
//                } else {
                    $boxes[$box][$key] = $power;
//                }
            } else {
                [$key] = explode('-', $code);
                unset($boxes[$box][$key]);
            }
        }

        foreach ($boxes as $i => $box) {
            $x = 1;
            foreach ($box as $item) {
                $result += ($i+1) * $x * $item;
                $x++;
            }
        }

        return $result;
    }

    private function getValue($code)
    {
        $iMax = strlen($code);
        $cur = 0;
        for ($i = 0; $i < $iMax; $i++) {
            $ascii = ord($code[$i]);
            if (($ascii >= 65 && $ascii <= 90) || ($ascii >= 97 && $ascii <= 122)) {
                $cur += ord($code[$i]);
                $cur *= 17;
                $cur %= 256;
            }
        }

        return $cur;
    }
}