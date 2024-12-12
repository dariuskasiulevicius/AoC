<?php

namespace AdventOfCode\Year2024\Day11;

ini_set('memory_limit', '200G');

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $stones = [];
        foreach ($inputData as $item) {
            foreach (explode(' ', $item) as $num) {
                if (!isset($stones[$num])) {
                    $stones[$num] = 0;
                }
                $stones[$num]++;
            }
        }

        for ($i = 0; $i < 75; $i++) {
            $stones = $this->step($stones);
            echo $i . PHP_EOL;
        }

        return array_sum($stones);
    }

    private function step(array $stones): array
    {
        $afterStep = [];
        foreach ($stones as $key => $stone) {
            if ($key === 0 ){
                $key = 1;
                $count = $stone;
            } elseif(strlen((string)$key) % 2 === 0) {
                $leftNumber = (int)substr($key, 0, strlen($key) / 2);
                $key = (int)substr($key, strlen($key) / 2);
                $count = $stone;

                if(!isset($afterStep[$leftNumber])){
                    $afterStep[$leftNumber] = 0;
                }
                $afterStep[$leftNumber]+= $count;
            } else {
                $key = $key * 2024;
                $count = $stone;
            }

            if(!isset($afterStep[$key])){
                $afterStep[$key] = 0;
            }
            $afterStep[$key]+= $count;
        }

        return $afterStep;
    }
}
