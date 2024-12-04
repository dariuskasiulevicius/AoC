<?php

namespace AdventOfCode\Year2024\Day04;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

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
            $map[] = str_split($item, 1);
        }
        $maxX = count($map[0]);
        $maxY = count($map);
        for ($y = 0; $y < $maxY; $y++) {
            for ($x = 0; $x < $maxX; $x++) {
                $words = $this->getWords($map, 4, $x, $y); //XMAS
                foreach ($words as $word) {
                    if ($word === 'XMAS') {
                        $result++;
                    }
                }
            }
        }

        return $result;
    }

    private function getWords(array $map, int $wordLength, int $x, int $y): array
    {
        $words = [];
        if(isset($map[$y][$x + $wordLength - 1])) {
            $words[] = $map[$y][$x] . $map[$y][$x + 1] . $map[$y][$x + 2] . $map[$y][$x + 3];
        }
        if(isset($map[$y][$x - $wordLength + 1])) {
            $words[] = $map[$y][$x] . $map[$y][$x - 1] . $map[$y][$x - 2] . $map[$y][$x - 3];
        }
        if(isset($map[$y + $wordLength - 1][$x])) {
            $words[] = $map[$y][$x] . $map[$y + 1][$x] . $map[$y + 2][$x] . $map[$y + 3][$x];
        }
        if(isset($map[$y - $wordLength + 1][$x])) {
            $words[] = $map[$y][$x] . $map[$y - 1][$x] . $map[$y - 2][$x] . $map[$y - 3][$x];
        }
        if(isset($map[$y + $wordLength - 1][$x + $wordLength - 1])) {
            $words[] = $map[$y][$x] . $map[$y + 1][$x + 1] . $map[$y + 2][$x + 2] . $map[$y + 3][$x + 3];
        }
        if(isset($map[$y - $wordLength + 1][$x - $wordLength + 1])) {
            $words[] = $map[$y][$x] . $map[$y - 1][$x - 1] . $map[$y - 2][$x - 2] . $map[$y - 3][$x - 3];
        }
        if(isset($map[$y + $wordLength - 1][$x - $wordLength + 1])) {
            $words[] = $map[$y][$x] . $map[$y + 1][$x - 1] . $map[$y + 2][$x - 2] . $map[$y + 3][$x - 3];
        }
        if(isset($map[$y - $wordLength + 1][$x + $wordLength - 1])) {
            $words[] = $map[$y][$x] . $map[$y - 1][$x + 1] . $map[$y - 2][$x + 2] . $map[$y - 3][$x + 3];
        }

        return $words;
    }
}
