<?php

namespace AdventOfCode\Year2020\Day18;

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
        $inputs = [];
        foreach ($inputData as $item) {
            //your custom code goes here
//            $inputs[] = $item;
            $item = str_replace(['(', ')'], ['( ', ' )'], $item);
            $result += $this->calculate(explode(" ", $item));
        }


        return $result;
    }

    protected function calculate($var)
    {
        $result = 0;
        $action = null;
        $memory = [];
        foreach ($var as $item) {
            if ((string)(int)$item === $item) {
                if ($action === null) {
                    $result = (int)$item;
                } elseif ($action === "*") {
                    $result *= (int)$item;
                    $action = null;
                } elseif ($action === "+") {
                    $result += (int)$item;
                    $action = null;
                }
            } elseif ($item === "*") {
                $action = "*";
            } elseif ($item === "+") {
                $action = "+";
            } elseif ($item === '(') {
                $memory[] = ['res' => $result, 'act' => $action];
                $result = 0;
                $action = null;
            } elseif ($item === ')') {
                $mem = array_pop($memory);
                $item = $result;
                $action = $mem['act'];
                $result = $mem['res'];

                if ($action === null) {
                    $result = (int)$item;
                } elseif ($action === "*") {
                    $result *= (int)$item;
                    $action = null;
                } elseif ($action === "+") {
                    $result += (int)$item;
                    $action = null;
                }
            }
        }

        return $result;
    }
}
