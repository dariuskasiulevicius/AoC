<?php

namespace AdventOfCode\Year2024\Day21;

ini_set('memory_limit', '100G');

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
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
        '<' => [0, -1],
        '^' => [-1, 0],
        'v' => [1, 0],
        '>' => [0, 1],
    ];

    private array $memory = [];

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
            echo implode('',$item) . PHP_EOL;
            $firstPaths = $this->getPath($item, $this->keyPadStart, $this->keyPad);
            $firstPaths = $this->minimizeList($firstPaths);
            $min = PHP_INT_MAX;
            foreach ($firstPaths as $path) {
                $count = $this->getShortestPath($path);
                echo $path . ' ' . $count . PHP_EOL;
                $min = min($count, $min);
            }
            $result += $min * (int)substr(implode('', $item), 0, -1);
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

    function getCount(string $path): int
    {
        $prev = '';
        $count = 0;
        foreach (str_split($path) as $char) {
            if ($char !== $prev) {
                $count++;
            }
            $prev = $char;
        }

        return $count;
    }

    public function minimizeList(array $secondPaths): array
    {
        $minLength = PHP_INT_MAX;
        $minChanges = PHP_INT_MAX;
        $metaData = [];
        foreach ($secondPaths as $key => $path) {
            $count = $this->getCount($path);
            $length = strlen($path);
            if ($length <= $minLength && $count <= $minChanges) {
                $metaData[] = [$length, $count, $key];
            }
            $minLength = min($length, $minLength);
            $minChanges = min($count, $minChanges);
        }

        foreach ($metaData as $metaDatum) {
            if ($metaDatum[0] === $minLength && $metaDatum[1] === $minChanges) {
                $firstPaths[] = $secondPaths[$metaDatum[2]];
            }
        }

        return $firstPaths;
    }

    private function getShortestPath(string $path): int
    {
        $parts = $this->getExplodePath($path);

        for ($i = 0; $i < 25; $i++) {
            $newParts = [];
            foreach ($parts as $part => $count) {
                if (isset($this->memory[$part])) {
                    $paths = $this->memory[$part];
                } else {
                    $paths = $this->getPath(str_split($part), $this->arrowPadStart, $this->arrowPad);
                    $paths = $this->minimizeList($paths);
//                    if (count($paths) > 1) {
//                        var_export($part);
//                        var_export($paths);
//                        throw new \LogicException('More than one path');
//                    }
                    $this->memory[$part] = [$paths[0]];
                }
                $nextParts = $this->getExplodePath($paths[0]);
                array_walk($nextParts, function ($val, $key) use ($count, &$newParts) {
                    $val *= $count;
                    if (isset($newParts[$key])) {
                        $newParts[$key] += $val;
                    } else {
                        $newParts[$key] = $val;
                    }
                });
            }
            $parts = $newParts;
        }
        $result = 0;
        foreach ($parts as $key => $part) {
            $result += strlen($key) * $part;
        }

        return $result;
    }

    private function getExplodePath(string $path): array
    {
        $parts = explode('A', $path);
        $result = [];
        $last = array_key_last($parts);
        foreach ($parts as $k => $item) {
            if ($k === $last) {
                continue;
            }
            $key = $item . 'A';
            if (!isset($result[$key])) {
                $result[$key] = 0;
            }
            ++$result[$key];
        }

        return $result;
    }
}
