<?php

namespace AdventOfCode\Year2021\Day25;

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $map = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $map[] = str_split($item);
        }
        $yMax = count($map) - 1;
        $xMax = count($map[0]) - 1;

        $step = 0;
        do {
            $newMap = [];
            $moved = false;
            foreach ($map as $y => $row) {
                foreach ($row as $x => $value) {
                    if ($value === '.' || $value === 'v') {
                        if (!isset($newMap[$y][$x])) {
                            $newMap[$y][$x] = $value;
                        }
                    } else {
                        $newX = $x + 1;
                        if ($newX > $xMax) {
                            $newX = 0;
                        }
                        if ($map[$y][$newX] === '.') {
                            $newMap[$y][$x] = '.';
                            $newMap[$y][$newX] = '>';
                            $moved = true;
                        } else {
                            $newMap[$y][$x] = $map[$y][$x];
                        }
                    }
                }
            }
            $map = $newMap;
            foreach ($map as $y => $row) {
                foreach ($row as $x => $value) {
                    if ($value === '.' || $value === '>') {
                        if (!isset($newMap[$y][$x])) {
                            $newMap[$y][$x] = $value;
                        }
                    } else {
                        $newY = $y + 1;
                        if ($newY > $yMax) {
                            $newY = 0;
                        }
                        if ($map[$newY][$x] === '.') {
                            $newMap[$y][$x] = '.';
                            $newMap[$newY][$x] = 'v';
                            $moved = true;
                        } else {
                            $newMap[$y][$x] = $map[$y][$x];
                        }
                    }
                }
            }
            $map = $newMap;
//            $this->print($map);
            $step++;
//            echo $step . PHP_EOL;
        } while ($moved);

        return $step;
    }

    private function print(array $map)
    {
        foreach ($map as $row) {
            echo implode('', $row) . PHP_EOL;
        }
        echo PHP_EOL;
    }
}
