<?php

namespace AdventOfCode\Year2022\Day21;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $monkeys = [];
        $humn = 'humn';
        $reverseActions = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            [$monkey, $action] = explode(':', $item);
            $action = explode(' ', trim($action));
            if ($monkey === 'root') {
                $action[1] = '=';
                $monkeys[$monkey] = $action;
            } elseif (count($action) > 1) {
                $monkeys[$monkey] = $action;
                switch ($action[1]) {
                    case '-':
                        $sign = '+';
                        $reverseActions[$action[2]] = [$action[0], '-', $monkey];
                        break;
                    case'+':
                        $sign = '-';
                        $reverseActions[$action[2]] = [$monkey, '-', $action[0]];
                        break;
                    case'/':
                        $sign = '*';
                        $reverseActions[$action[2]] = [$action[0], '/', $monkey];
                        break;
                    case'*':
                        $sign = '/';
                        $reverseActions[$action[2]] = [$monkey, '/', $action[0]];
                        break;
                }
                $reverseActions[$action[0]] = [$monkey, $sign, $action[2]];
            } else {
                $monkeys[$monkey] = (int)$action[0];
            }
        }

        unset($monkeys[$humn]);
        do {
            $didAction = false;
            foreach ($monkeys as $monkey => $action) {
                [$left, $sign, $right] = $action;
                if (
                    $monkey !== 'root'
                    && isset($monkeys[$left]) && is_int($monkeys[$left])
                    && isset($monkeys[$right]) && is_int($monkeys[$right])
                ) {
                    $number = null;
                    $string = '$number = ' . $monkeys[$left] . ' ' . $sign . ' ' . $monkeys[$right] . ';';
                    try {
                        eval($string);
                    } catch (\ParseError $exp) {
                        echo $exp->getMessage();
                    }
                    $monkeys[$monkey] = $number;
                    $didAction = true;
                }
            }

        } while ($didAction);

        foreach ($monkeys as $key => $action) {
            if (is_int($action) && $key !== $humn) {
                $reverseActions[$key] = $action;
            }
        }

        [$left, $action, $right] = $monkeys['root'];
        $rightResult = $this->count($right, $monkeys);

        $reverseActions[$left] = $rightResult;

        return $this->count($humn, $reverseActions);
    }

    private function count($from, $monkeys, $asked = [])
    {
        if (is_int($monkeys[$from])) {
            return $monkeys[$from];
        }

        $number = 0;
        [$left, $action, $right] = $monkeys[$from];
        $asked[$from] = true;
        eval('$number=' . $this->count($left, $monkeys, $asked) . ' ' . $action . ' ' . $this->count($right, $monkeys, $asked) . ';');

        return $number;
    }
}
