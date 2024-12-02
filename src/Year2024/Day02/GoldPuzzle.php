<?php

namespace AdventOfCode\Year2024\Day02;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */

    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $inputItem) {
            $list = explode(' ', $inputItem);
            $end = false;
            $i = 0;
            $count = count($list);
            $testList = $list;
            do {
                $safe = $this->isItSafe($testList);
                if($safe){
                    break;
                }
                $testList = $list;
                if(isset($testList[$i])) {
                    unset($testList[$i]);
                }
                $i++;
                if($i > $count) {
                    $end = true;
                }
            } while (!$end);
            if ($safe) {
                var_export($inputItem);
                var_export(PHP_EOL);
                $result++;
            }
        }

        return $result;
    }

    private function isItSafe(array $list): bool
    {
        $previous = null;
        $side = null;
        $safe = true;
        foreach ($list as $item) {
            if ($previous !== null) {
                if ($side === null) {
                    $side = $previous < $item ? 'up' : 'down';
                }
                if ($side === 'up' && $previous > $item) {
                    $safe = false;
                    break;
                }
                if ($side === 'down' && $previous < $item) {
                    $safe = false;
                    break;
                }
                if (abs($previous - $item) > 3 || abs($previous - $item) === 0) {
                    $safe = false;
                    break;
                }
            }
            $previous = $item;
        }

        return $safe;
    }
}
