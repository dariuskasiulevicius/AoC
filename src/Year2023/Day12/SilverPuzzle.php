<?php

namespace AdventOfCode\Year2023\Day12;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $springs = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            [$condition, $rules] = explode(' ', $item);
            $springs[] = [$condition, explode(',', $rules)];
        }

        foreach ($springs as $spring) {
//            $rule = [[0, '.']];
//            $last = array_key_last($spring[1]);
//            foreach ($spring[1] as $key => $item) {
//                $rule[] = [$item, '#'];
//                if ($last === $key) {
//                    $rule[] = [0, '.'];
//                } else {
//                    $rule[] = [1, '.'];
//                }
//            }
            $variations = $this->getAllVariations($spring[0]);
            $filtered = $this->filtter($variations, implode('-', $spring[1]));
            $result += count($filtered);

        }

        return $result;
    }

    public function getAllVariations($pattern)
    {
        $variations = [];
        $short = str_replace(['.', '#'], ['', ''], $pattern);
        $len = strlen($short);
        $count = 2 ** $len;
        for ($i = 0; $i < $count; $i++) {
            $value = str_pad(decbin($i), $len, '0', STR_PAD_LEFT);
            $var = str_replace(['1', '0'], ['#', '.'], $value);
            $j = 0;
            $res = '';
            foreach (str_split($pattern) as $char) {
                if ($char === '?') {
                    $res .= $var[$j];
                    $j++;
                } else {
                    $res .= $char;
                }
            }
            $variations[] = $res;
        }


        return $variations;
    }

    private function filtter($variants, $key)
    {
        $res = [];
        foreach ($variants as $variant) {
            $varKey = '';
            $keyNum = null;
            foreach (str_split($variant) as $char) {
                if ($char === '#' && $keyNum === null) {
                    $keyNum = 1;
                } elseif ($char === '#') {
                    $keyNum++;
                } elseif ($keyNum !== null) {
                    if (!empty($varKey)) {
                        $varKey .= '-';
                    }
                    $varKey .= $keyNum;
                    $keyNum = null;
                }
            }
            if ($keyNum !== null) {
                if (!empty($varKey)) {
                    $varKey .= '-';
                }
                $varKey .= $keyNum;
                $keyNum = null;
            }
            if ($key === $varKey) {
                $res[] = $variant;
            }
        }

        return $res;
    }
}
