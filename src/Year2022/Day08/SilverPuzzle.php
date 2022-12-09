<?php

namespace AdventOfCode\Year2022\Day08;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    private array $visible = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
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

        foreach ($map as $key => $line) {
            $this->mapVisible($line, 0, $key, 'E');
//            $this->print($this->visible);
            $this->mapVisible(array_reverse($line), $maxX-1, $key, 'W');
            $collumn = [];
            for ($y = 0; $y < $maxY; $y++) {
                $collumn[] = $map[$y][$key];
            }
            $this->mapVisible($collumn, $key, 0, 'S');
            $this->mapVisible(array_reverse($collumn), $key, $maxY-1, 'N');
        }

        return array_sum(array_map('array_sum', $this->visible));
    }

    private function mapVisible(array $items, int $x, int $y, string $direction)
    {
        $lastVisible = -1;
        foreach ($items as $item) {
            if ($item > $lastVisible) {
                $this->visible[$y][$x] = 1;
                $lastVisible = $item;
            }
            switch ($direction) {
                case 'E':
                    $x++;
                    break;
                case 'W';
                    $x--;
                    break;
                case 'N';
                    $y--;
                    break;
                case 'S':
                    $y++;
                    break;
            }
        }
    }

    private function print(array $items)
    {
        foreach ($items as $item) {
            echo implode('', $item) . PHP_EOL;
        }
        echo PHP_EOL;
    }
}
