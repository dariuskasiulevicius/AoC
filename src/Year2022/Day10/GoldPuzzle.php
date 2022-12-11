<?php

namespace AdventOfCode\Year2022\Day10;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = '';
        $step = 0;
        $sum = 1;
        $follow = 40;
        foreach ($inputData as $item) {
            //your custom code goes here
            $items = explode(' ', $item);
            if ($items[0] === 'noop') {
                $step++;
                $result .= $this->getSymbol($step, $sum);
                if ($this->isNewLine($step, $follow)) {
                    $result .= PHP_EOL;
                    $step = 0;
                }
            } else {
                $step++;
                $result .= $this->getSymbol($step, $sum);
                if ($this->isNewLine($step, $follow)) {
                    $result .= PHP_EOL;
                    $step = 0;
                }
                $step++;
                $result .= $this->getSymbol($step, $sum);
                if ($this->isNewLine($step, $follow)) {
                    $result .= PHP_EOL;
                    $step = 0;
                }
            }

            if ($items[0] === 'addx') {
                $sum += (int)$items[1];
            }
        }

        return $result;
    }

    private function getSymbol($step, $sum)
    {
        if ($step >= $sum && $step <= $sum + 2) {
            return '#';
        }

        return '.';
    }

    private function isNewLine($step, $follow)
    {
        return $follow !== null && $step >= $follow;
    }
}
