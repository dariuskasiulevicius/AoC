<?php

namespace AdventOfCode\Year2023\Day14;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $map = [];
        $y = 0;
        $rocks = [];
        foreach ($inputData as $item) {
            foreach (str_split($item) as $x => $char) {
                $map[$y][$x] = $char === 'O' ? '.' : $char;
                if ($char === 'O') {
                    $rocks[$x . '-' . $y] = [$x, $y];
                }
            }
            $y++;
        }

        $hashes = [];
        for ($i = 1; $i <= 500; $i++) {
            $rocks = $this->moveRocks($map, $rocks, 0, -1);
            $rocks = $this->moveRocks($map, $rocks, -1, 0);
            $rocks = $this->moveRocks($map, $rocks, 0, 1);
            $rocks = $this->moveRocks($map, $rocks, 1, 0);
            $hash = $this->getHash($rocks);
//            if (isset($hashes[$hash])) {
//                echo ' h: ' . $i . PHP_EOL;
//            }
            $hashes[$hash] = 0;
            $max = count($map);
            $result = 0;
            foreach ($rocks as $rock) {
                $result += $max - $rock[1];
            }
            echo 'r: ' . $result . PHP_EOL;
            //after print find the pattern and calculate answer manually
        }
//        $this->printMap($map, $rocks);

        $result = 0;
        $max = count($map);
        foreach ($rocks as $rock) {
            $result += $max - $rock[1];
        }
//        $maxY++;
//        foreach ($map as $line) {
//            foreach ($line as $char) {
//                if ($char === 'O') {
//                    $result += $maxY;
//                }
//            }
//            $maxY--;
//        }

        return $result;
    }

    private function moveRocks($map, $rocks, $xMove, $yMove)
    {
        do {
            $moved = false;
            foreach ($rocks as $key => $rock) {
                [$x, $y] = $rock;
                $xAfter = $x + $xMove;
                $yAfter = $y + $yMove;
                $newKey = $xAfter . '-' . $yAfter;
                if (isset($map[$yAfter][$xAfter]) && $map[$yAfter][$xAfter] === '.' && !isset($rocks[$newKey])) {
                    $moved = true;
                    $rocks[$newKey] = [$xAfter, $yAfter];
                    unset($rocks[$key]);
                }
            }
        } while ($moved);

        return $rocks;
    }

    private function printMap($map, $rocks)
    {
        foreach ($map as $y => $line) {
            foreach ($line as $x => $char) {
                $key = $x . '-' . $y;
                if (isset($rocks[$key])) {
                    echo 'O';
                } else {
                    echo $char;
                }
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }

    private function getHash($rocks)
    {
        ksort($rocks);
        $line = '';
        foreach ($rocks as $key => $rock) {
            $line .= $key;
        }

        return md5($line);
    }
}
