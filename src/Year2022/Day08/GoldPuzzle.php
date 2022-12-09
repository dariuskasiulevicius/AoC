<?php

namespace AdventOfCode\Year2022\Day08;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $map = [];
        $maxX = 0;
        $maxY = 0;
        foreach ($inputData as $item) {
            //your custom code goes here
            $line = str_split($item, 1);
            $map[] = $line;
            $maxX = max($maxX, count($line));
            $maxY++;
        }
        for ($i = 0; $i < $maxY; $i++) {
            $this->visible[] = array_fill(0, $maxX, 0);
        }

        for ($y = 0; $y < $maxY; $y++) {
            for ($x = 0; $x < $maxX; $x++) {
                $score = $this->getScore($map, $x, $y, $maxX - 1, $maxY - 1);
//                $this->visible[$y][$x] = $score;
                $result = max($result, $score);
            }
        }
//        $this->print($this->visible);

        return $result;
    }

    private function getScore($map, $x, $y, $maxX, $maxY)
    {
        $value = $map[$y][$x];
        $scoreE = 0;
        for ($i = $x + 1; $i <= $maxX; $i++) {
            $scoreE++;
            if ($map[$y][$i] >= $value) {
                break;
            }
        }
        $scoreW = 0;
        for ($i = $x - 1; $i >= 0; $i--) {
            $scoreW++;
            if ($map[$y][$i] >= $value) {
                break;
            }
        }
        $scoreS = 0;
        for ($i = $y + 1; $i <= $maxY; $i++) {
            $scoreS++;
            if ($map[$i][$x] >= $value) {
                break;
            }
        }
        $scoreN = 0;
        for ($i = $y - 1; $i >= 0; $i--) {
            $scoreN++;
            if ($map[$i][$x] >= $value) {
                break;
            }
        }
        $this->visible[$y][$x] = $scoreE . ',' . $scoreW . ',' . $scoreS . ',' . $scoreN;
        return $scoreE * $scoreW * $scoreS * $scoreN;
    }

    private function print(array $items)
    {
        foreach ($items as $item) {
            echo implode(';  ', $item) . PHP_EOL;
        }
        echo PHP_EOL;
    }
}
