<?php

namespace AdventOfCode\Year2021\Day10;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $pairs = [')' => '(', ']' => '[', '}' => '{', '>' => '<'];
        $penalty = [')' => 3, ']' => 57, '}' => 1197, '>' => 25137];
        foreach ($inputData as $item) {
            $buffer = [];
            foreach (str_split($item) as $symbol) {
                if (in_array($symbol, ['(', '[', '{', '<'])) {
                    $buffer[] = $symbol;
                } else {
                    $last = array_pop($buffer);
                    if ($pairs[$symbol] !== $last){
                        $result += $penalty[$symbol];
                        break;
                    }
                }
            }
        }

        return $result;
    }
}
