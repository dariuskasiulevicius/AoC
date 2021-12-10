<?php

namespace AdventOfCode\Year2021\Day10;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $pairs = [')' => '(', ']' => '[', '}' => '{', '>' => '<'];
        $openPairs = array_flip([')' => '(', ']' => '[', '}' => '{', '>' => '<']);
        $penalty = [')' => 1, ']' => 2, '}' => 3, '>' => 4];
        $middle = [];
        foreach ($inputData as $item) {
            $buffer = [];
            $corrupted = false;
            foreach (str_split($item) as $symbol) {
                if (in_array($symbol, ['(', '[', '{', '<'])) {
                    $buffer[] = $symbol;
                } else {
                    $last = array_pop($buffer);
                    if ($pairs[$symbol] !== $last) {
                        $result += $penalty[$symbol];
                        $corrupted = true;
                        break;
                    }
                }
            }
            $score = 0;
            if (!$corrupted) {
                foreach (array_reverse($buffer) as $symbol) {
                    $score = $score * 5 + $penalty[$openPairs[$symbol]];
                }
                $middle[] = $score;
            }
        }
        sort($middle);
        $result = $middle[floor(count($middle) / 2)];

        return $result;
    }
}
