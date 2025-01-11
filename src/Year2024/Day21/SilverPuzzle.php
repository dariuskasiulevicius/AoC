<?php

namespace AdventOfCode\Year2024\Day21;

ini_set('memory_limit', '100G');

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    private array $keyPad = [
        ['7', '8', '9'],
        ['4', '5', '6'],
        ['1', '2', '3'],
        ['', '0', 'A'],
    ];

    private array $keyPadStart = [3, 2];

    private array $arrowPad = [
        ['', '^', 'A'],
        ['<', 'v', '>'],
    ];

    private array $arrowPadStart = [0, 2];

    private array $moves = [
        '^' => [-1, 0],
        'v' => [1, 0],
        '<' => [0, -1],
        '>' => [0, 1],
    ];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $input = [];
        foreach ($inputData as $item) {
            $input[] = str_split($item);
        }

        foreach ($input as $item) {
            $firstPaths = $this->getPath($item, $this->keyPadStart, $this->keyPad);
            $secondPaths = [];
            foreach ($firstPaths as $path) {
                $innerPaths = $this->getPath(str_split($path), $this->arrowPadStart, $this->arrowPad);
                $secondPaths = array_merge($secondPaths, $innerPaths);
            }
            $minSecond = PHP_INT_MAX;
            array_map(function ($path) use (&$minSecond) {
                $minSecond = min(strlen($path), $minSecond);
            }, $secondPaths);
            $secondPaths = array_filter($secondPaths, function ($path) use ($minSecond) {
                return strlen($path) === $minSecond;
            });

            $thirdPaths = [];
            foreach ($secondPaths as $path) {
                $innerPaths = $this->getPath(str_split($path), $this->arrowPadStart, $this->arrowPad);
                $thirdPaths = array_merge($thirdPaths, $innerPaths);
            }
            $minThird = PHP_INT_MAX;
            array_map(function ($path) use (&$minThird) {
                $minThird = min(strlen($path), $minThird);
            }, $thirdPaths);
            $thirdPaths = array_filter($thirdPaths, function ($path) use ($minThird) {
                return strlen($path) === $minThird;
            });

            $result += $minThird * (int)substr(implode('', $item), 0, -1);
        }

        return $result;
    }

    private function getPath(array $item, array $start, array $map): array
    {
        $paths = [];
        foreach ($item as $nextTarget) {
            $visited = [];
            $nextPaths = [];
            $explore = [[$start[0], $start[1], '']];
            $minimal = 100;
            do {
                $current = array_shift($explore);
                $visited[$current[0] . '-' . $current[1] . '-' . $current[2]] = true;
                if ($map[$current[0]][$current[1]] === $nextTarget) {
                    $nextPaths[] = $current[2] . 'A';
                    $start = [$current[0], $current[1]];
                    $minimal = min(strlen($current[2]), $minimal);
                    continue;
                }
                if (strlen($current[2]) > $minimal) {
                    continue;
                }
                $neighbours = $this->getNeighbours($current, $map);
                foreach ($neighbours as $neighbour) {
                    if (!isset($visited[$neighbour[0] . '-' . $neighbour[1] . '-' . $neighbour[2]])
                        || $map[$neighbour[0]][$neighbour[1]] === $nextTarget) {
                        $explore[] = [$neighbour[0], $neighbour[1], $current[2] . $neighbour[2]];
                    }
                }
            } while (count($explore) > 0);
            $tmp = [];
            foreach ($nextPaths as $nextPath) {
                if (strlen($nextPath) === ($minimal + 1)) {
                    foreach ($paths as $path) {
                        $tmp[] = $path . $nextPath;
                    }
                }
            }
            if (empty($tmp)) {
                $tmp = $nextPaths;
            }
            $paths = $tmp;
        }

        return $paths;
    }

    private function getNeighbours(array $point, array $map): array
    {
        $neighbours = [];
        foreach ($this->moves as $key => $move) {
            $new = [$point[0] + $move[0], $point[1] + $move[1]];
            if (isset($map[$new[0]][$new[1]]) && $map[$new[0]][$new[1]] !== '') {
                $neighbours[] = [$new[0], $new[1], $key];
            }
        }

        return $neighbours;
    }
}
