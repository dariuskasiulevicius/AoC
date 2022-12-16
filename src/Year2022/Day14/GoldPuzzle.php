<?php

namespace AdventOfCode\Year2022\Day14;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    protected $map = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $this->map = [];
        $minY = PHP_INT_MAX;
        $maxY = 0;
        $minX = PHP_INT_MAX;
        $maxX = 0;
        foreach ($inputData as $item) {
            //your custom code goes here
            [$minX, $maxX, $minY, $maxY] = $this->addLineToMap($item, $minX, $maxX, $minY, $maxY);
        }
        $item = sprintf('%s,%s -> %s,%s', 500 + $maxY+2, $maxY+2, 500 - $maxY-2, $maxY+2);
        [$minX, $maxX, $minY, $maxY] = $this->addLineToMap($item, $minX, $maxX, $minY, $maxY);

        do {
            $lost = $this->drop([500, 0]);
            $result++;
        } while ($lost === false);

        $this->printMap($this->map, $minX, $maxX, 0, $maxY);

        return $result;
    }

    private function drop($start)
    {
        $overflow = false;
        [$x, $y] = $start;
        do {
            if(!isset($this->map[$y+1][$x])){
                $y++;
            } elseif(!isset($this->map[$y+1][$x-1])){
                $y++;
                $x--;
            } elseif(!isset($this->map[$y+1][$x+1])){
                $y++;
                $x++;
            } else {
                $this->map[$y][$x] = 'o';
                if($y === 0) {
                    $overflow = true;
                }
                break;
            }
        } while ($overflow === false);

        return $overflow;
    }

    private function printMap(array $map, $minX, $maxX, $minY, $maxY)
    {
        for ($y = $minY; $y <= $maxY; $y++) {
            for ($x = $minX; $x <= $maxX; $x++) {
                if (isset($map[$y][$x])) {
                    echo $map[$y][$x];
                } else {
                    echo '.';
                }
            }
            echo PHP_EOL;
        }
    }

    public function addLineToMap(string $item, int $minX, int $maxX, int $minY, int $maxY): array
    {
        $points = explode(' -> ', $item);
        $prev = null;
        foreach ($points as $point) {
            [$x, $y] = explode(',', $point);
            $x = (int)$x;
            $y = (int)$y;
            $minY = min($minY, $y);
            $maxY = max($maxY, $y);
            $minX = min($minX, $x);
            $maxX = max($maxX, $x);
            $this->map[$y][$x] = '#';
            if ($prev !== null) {
                if ($prev[0] === $x) {
                    $from = min($prev[1], $y);
                    $to = max($prev[1], $y);
                    for ($i = $from; $i <= $to; $i++) {
                        $this->map[$i][$x] = '#';
                    }
                } else {
                    $from = min($prev[0], $x);
                    $to = max($prev[0], $x);
                    for ($i = $from; $i <= $to; $i++) {
                        $this->map[$y][$i] = '#';
                    }
                }
            }
            $prev = [$x, $y];
        }

        return [$minX, $maxX, $minY, $maxY];
    }
}
