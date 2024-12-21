<?php

namespace AdventOfCode\Year2024\Day18;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    private const DIRECTIONS = [
        [0, -1],
        [1, 0],
        [0, 1],
        [-1, 0],
    ];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $map = [];
        foreach ($inputData as $item) {
            [$x, $y] = explode(',', $item);
            $map[$this->getKey($x, $y)] = '#';
        }

        $start = [0, 0];
//        $end = [70, 70];
//        $limit = 1024;
        $end = [6, 6];
        $limit = 12;
        $lmap = array_slice($map, 0, $limit);
        [$path, $result] = $this->aStar($lmap, $start, $end, $end);

        return $result;
    }

    private function getKey(int $x, int $y): string
    {
        return $x . ';' . $y;
    }

    private function aStar(array $map, array $start, array $end, array $max)
    {
        $openSet = [$this->getKey($start[0], $start[1]) => $start];
        $cameFrom = [];
        $gScore = [$this->getKey($start[0], $start[1]) => 0];
        $fScore = [$this->getKey($start[0], $start[1]) => $this->heuristic($start, $end)];
//        $this->printMap($map, $cameFrom);
        while (!empty($openSet)) {
            $current = array_reduce(array_keys($openSet), function ($carry, $item) use ($fScore) {
                return $fScore[$item] < $fScore[$carry] ? $item : $carry;
            }, array_keys($openSet)[0]);

            $currentCoords = explode(';', $current);
            $currentX = (int)$currentCoords[0];
            $currentY = (int)$currentCoords[1];

            if ($currentX === $end[0] && $currentY === $end[1]) {
//                $this->printMap($map, $cameFrom);
                return [$this->reconstructPath($cameFrom, $current), $fScore[$current]];
            }

            unset($openSet[$current]);

            foreach ($this->getNeighbors($currentX, $currentY) as $neighbor) {
                $neighborKey = $this->getKey($neighbor[0], $neighbor[1]);
                $mapNeighborKey = $this->getKey($neighbor[0], $neighbor[1]);
                if ((isset($map[$mapNeighborKey]) && $map[$mapNeighborKey] === '#')
                    || $neighbor[0] < 0 || $neighbor[1] < 0
                    || $neighbor[0] > $max[0] || $neighbor[1] > $max[1]) {
                    continue;
                }

                $tentativeGScore = $gScore[$current] + $neighbor[2];

                if (!isset($gScore[$neighborKey]) || $tentativeGScore < $gScore[$neighborKey]) {
                    $cameFrom[$neighborKey] = $current;
                    $gScore[$neighborKey] = $tentativeGScore;
                    $fScore[$neighborKey] = $tentativeGScore + $this->heuristic($neighbor, $end);
                    if (!isset($openSet[$neighborKey])) {
                        $openSet[$neighborKey] = $neighbor;
                    }
                }
            }
        }

        return null; // No path found
    }

    private function heuristic(array $a, array $b): int
    {
        return abs($a[0] - $b[0]) + abs($a[1] - $b[1]);
    }

    private function getNeighbors(int $x, int $y): array
    {
        $neighbors = [];
        foreach (self::DIRECTIONS as $move) {
            $newX = $x + $move[0];
            $newY = $y + $move[1];
            $neighbors[] = [$newX, $newY, 1];
        }
        return $neighbors;
    }

    private function reconstructPath(array $cameFrom, string $current): array
    {
        $totalPath = [$current];
        while (isset($cameFrom[$current])) {
            $current = $cameFrom[$current];
            $totalPath[] = $current;
        }
        return array_reverse($totalPath);
    }

    private function printMap(array $map, array $cameFrom): void
    {
        $maxX = max(array_map(function ($item) {
            return (int)explode(';', $item)[0];
        }, array_keys($map)));
        $maxY = max(array_map(function ($item) {
            return (int)explode(';', $item)[1];
        }, array_keys($map)));
        $visited = array_flip(array_map(function ($item) {
            [$x, $y] = explode(';', $item);
            return $this->getKey($x, $y);
        }, array_keys($cameFrom)));

        for ($y = 0; $y <= $maxY; $y++) {
            for ($x = 0; $x <= $maxX; $x++) {
                $key = $this->getKey($x, $y);
                if (isset($map[$key])) {
                    echo $map[$key];
                } elseif (isset($visited[$key])) {
                    echo 'O';
                } else {
                    echo '.';
                }
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }
}
