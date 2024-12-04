<?php

namespace AdventOfCode\Year2024\Day04;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    public array $newMap = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $map = [];
        foreach ($inputData as $item) {
            $map[] = str_split($item, 1);
        }
        $maxX = count($map[0]);
        $maxY = count($map);
        for ($y = 0; $y < $maxY; $y++) {
            for ($x = 0; $x < $maxX; $x++) {
                $this->newMap($map, 3, $x, $y, 'MAS'); //MAS
            }
        }

        $this->printMap($this->newMap, $maxX, $maxY);
        foreach ($this->newMap as $y => $line) {
            foreach ($line as $x => $item) {
                if ($item === 'A'
                    && isset(
                        $this->newMap[$y - 1][$x - 1],
                        $this->newMap[$y + 1][$x + 1],
                        $this->newMap[$y - 1][$x + 1],
                        $this->newMap[$y + 1][$x - 1]
                    )) {
                    $chars =
                        $this->newMap[$y - 1][$x - 1].
                        $this->newMap[$y + 1][$x + 1].
                        $this->newMap[$y - 1][$x + 1].
                        $this->newMap[$y + 1][$x - 1]
                    ;
                    $charCounts = count_chars($chars, 1);
                    if(isset($charCounts[ord('M')]) && $charCounts[ord('M')] === 2
                    && isset($charCounts[ord('S')]) && $charCounts[ord('S')] === 2) {
                        $result++;
                    }
                }
            }
        }

        return $result;
    }

    private function newMap(array $map, int $wordLength, int $x, int $y, string $findWord): void
    {
        if (isset($map[$y + $wordLength - 1][$x + $wordLength - 1])) {
            $word = $map[$y][$x] . $map[$y + 1][$x + 1] . $map[$y + 2][$x + 2];
            if ($word === $findWord) {
                $this->newMap[$y][$x] = $map[$y][$x];
                $this->newMap[$y + 1][$x + 1] = $map[$y + 1][$x + 1];
                $this->newMap[$y + 2][$x + 2] = $map[$y + 2][$x + 2];
            }
        }
        if (isset($map[$y - $wordLength + 1][$x - $wordLength + 1])) {
            $word = $map[$y][$x] . $map[$y - 1][$x - 1] . $map[$y - 2][$x - 2];
            if ($word === $findWord) {
                $this->newMap[$y][$x] = $map[$y][$x];
                $this->newMap[$y - 1][$x - 1] = $map[$y - 1][$x - 1];
                $this->newMap[$y - 2][$x - 2] = $map[$y - 2][$x - 2];
            }
        }
        if (isset($map[$y + $wordLength - 1][$x - $wordLength + 1])) {
            $word = $map[$y][$x] . $map[$y + 1][$x - 1] . $map[$y + 2][$x - 2];
            if ($word === $findWord) {
                $this->newMap[$y][$x] = $map[$y][$x];
                $this->newMap[$y + 1][$x - 1] = $map[$y + 1][$x - 1];
                $this->newMap[$y + 2][$x - 2] = $map[$y + 2][$x - 2];
            }
        }
        if (isset($map[$y - $wordLength + 1][$x + $wordLength - 1])) {
            $word = $map[$y][$x] . $map[$y - 1][$x + 1] . $map[$y - 2][$x + 2];
            if ($word === $findWord) {
                $this->newMap[$y][$x] = $map[$y][$x];
                $this->newMap[$y - 1][$x + 1] = $map[$y - 1][$x + 1];
                $this->newMap[$y - 2][$x + 2] = $map[$y - 2][$x + 2];
            }
        }

    }

    private function printMap(array $map, int $maxX, int $maxY): void
    {
        for ($y = 0; $y < $maxY; $y++) {
            for ($x = 0; $x < $maxX; $x++) {
                if (isset($map[$y][$x])) {
                    echo $map[$y][$x];
                } else {
                    echo '.';
                }
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }
}
