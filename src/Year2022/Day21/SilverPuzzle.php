<?php

namespace AdventOfCode\Year2022\Day21;

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
        $monkeys = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            [$monkey, $action] = explode(':', $item);
            $action = explode(' ', trim($action));
            if (count($action) > 1) {
                $monkeys[$monkey] = $action;
            } else {
                $monkeys[$monkey] = (int)$action[0];
            }
        }

        $result = $this->count('root', $monkeys);

        return $result;
    }

    private function count($from, $monkeys)
    {
        if (is_int($monkeys[$from])) {
            return $monkeys[$from];
        }

        $number = 0;
        [$left, $action, $right] = $monkeys[$from];
        eval('$number=' . $this->count($left, $monkeys) . ' ' . $action . ' ' . $this->count($right, $monkeys) . ';');
        return $number;
    }
}
