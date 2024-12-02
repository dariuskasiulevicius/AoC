<?php

namespace AdventOfCode\Year2023\Day11;

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
        $map = [];
        $xs = [];
        $ys = [];
        foreach ($inputData as $y => $item) {
            //your custom code goes here
            foreach (str_split($item) as $x => $char) {
                if ($char === '#') {
                    $map[] = ['x' => $x, 'y' => $y-1];
                    $xs[] = $x;
                    $ys[] = $y-1;
                }
            }
        }

        $xs = array_unique($xs);
        $ys = array_unique($ys);
        sort($xs);
        sort($ys);
        $xs = $this->expand($xs);
        $ys = $this->expand($ys);
        foreach ($map as $key => $item) {
            $map[$key] = ['x' => $xs[$item['x']], 'y' => $ys[$item['y']]];
        }
        $max = count($map) - 1;
        foreach ($map as $i => $item) {
            for ($j = $i + 1; $j <= $max; $j++){
                $result += $this->getDistance($item, $map[$j]);
            }
        }

        return $result;
    }

    private function expand(array $coordinates): array
    {
        $expanded = [];
        $prev = -1;
        $increase = 0;
        foreach ($coordinates as $k) {
            if ($prev + 1 !== $k) {
                $increase += 999999;
            }
            $expanded[$k] = $k + $increase;
            $prev = $k;
        }

        return $expanded;
    }

    private function getDistance($first, $second): int
    {
        return abs($first['x'] - $second['x']) + abs($first['y'] - $second['y']);
    }
}