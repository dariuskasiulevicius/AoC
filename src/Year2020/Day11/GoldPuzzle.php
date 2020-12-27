<?php

namespace AdventOfCode\Year2020\Day11;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
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
                    } elseif ($this->lines[$y][$x] === '#' && $count >= 5) {
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
        $positions = [
            [$x - 1, $y - 1, -1, -1],
            [$x, $y - 1, 0, -1],
            [$x - 1, $y, -1, 0],
            [$x + 1, $y + 1, 1, 1],
            [$x + 1, $y, 1, 0],
            [$x, $y + 1, 0, 1],
            [$x - 1, $y + 1, -1, 1],
            [$x + 1, $y - 1, 1, -1],
        ];
        $full = 0;

        do {
            $newPos = [];
            foreach ($positions as $key => $position) {
                $i = $position[0];
                $j = $position[1];
                if (!isset($this->lines[$j][$i])) {
                    unset($positions[$key]);
                } elseif ($this->lines[$j][$i] === '#') {
                    $full++;
                    unset($positions[$key]);
                } elseif ($this->lines[$j][$i] === 'L') {
                    unset($positions[$key]);
                } else {
                    $position[0] += $position[2];
                    $position[1] += $position[3];
                    $newPos[] = $position;
                }
            }
            $positions = $newPos;
        } while (count($positions) > 0);


        return $full;
    }
}
