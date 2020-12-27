<?php

namespace AdventOfCode\Year2020\Day11;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    protected $lines;
    protected $lineCounts;
    protected $max;

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $this->lines = [];
        $this->max = 0;
        foreach ($inputData as $item) {
            $this->max = max(strlen($item), $this->max);
            $this->lines[] = str_split($item);
        }

        $this->lineCounts = count($this->lines);
        $newMap = [];
        $step = 0;
        do {
            $changes = 0;
            foreach ($this->lines as $y => $line) {
                foreach ($line as $x => $seat) {
                    if ($this->lines[$y][$x] === '.') {
                        $newMap[$y][$x] = '.';
                        continue;
                    }
                    $count = $this->getOccupiedCount($x, $y);
                    if ($this->lines[$y][$x] === 'L' && $count === 0) {
                        $newMap[$y][$x] = '#';
                        $changes++;
                    } elseif ($this->lines[$y][$x] === '#' && $count >= 4) {
                        $newMap[$y][$x] = 'L';
                        $changes++;
                    }
                }
            }
            $step++;
            $this->lines = $newMap;
            echo $changes;
            echo PHP_EOL;
        } while ($changes > 0);
        $a = $newMap;
        foreach ($this->lines as $line) {
            foreach ($line as $pos) {
                if ($pos === '#') {
                    $result++;
                }
            }
        }

        return $result;
    }

    protected function getOccupiedCount($x, $y)
    {
        $full = 0;
        $xFrom = $x - 1;
        $xTo = $x + 1;
        $yFrom = $y - 1;
        $yTo = $y + 1;
        for ($i = $xFrom; $i <= $xTo; $i++) {
            for ($j = $yFrom; $j <= $yTo; $j++) {
                if (!($i === $x && $j === $y)
                    && isset($this->lines[$j][$i]) && $this->lines[$j][$i] === '#') {
                    $full++;
                }
            }
        }

        return $full;
    }
}
