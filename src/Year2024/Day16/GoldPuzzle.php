<?php

namespace AdventOfCode\Year2024\Day16;

ini_set('memory_limit', '200G');

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    private const DIRECTIONS = [
        'N' => [0, -1],
        'E' => [1, 0],
        'S' => [0, 1],
        'W' => [-1, 0],
    ];

    private const ROTATION_COST = 1000;

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $start = [];
        $end = [];
        $map = [];
        foreach ($inputData as $line => $item) {
            $y = $line - 1;
            foreach (str_split($item) as $x => $char) {
                $key = $this->getKey($x, $y);
                if ($char === '#') {
                    $map[$key] = '#';
                } elseif ($char === 'S') {
                    $start = [$x, $y, 'E'];
                } elseif ($char === 'E') {
                    $end = [$x, $y];
                }
            }
        }

        $paths = $this->aStar($map, $start, $end);
        $points = [];
        foreach ($paths as $path) {
            foreach ($path as $item) {
                $points[substr($item, 0, -1)] = true;
            }
        }

        return count($points);
    }

    private function getKey(int $x, int $y, string $facing = ''): string
    {
        return $x . ';' . $y . ($facing ? ';' . $facing : '');
    }

    private function aStar(array $map, array $start, array $end)
    {
        $openSet = [$this->getKey($start[0], $start[1], $start[2]) => $start];
        $cameFrom = [];
        $gScore = [$this->getKey($start[0], $start[1], $start[2]) => 0];
        $fScore = [$this->getKey($start[0], $start[1], $start[2]) => $this->heuristic($start, $end)];
        $stepScore = [$this->getKey($start[0], $start[1], $start[2]) => 0];
        $paths = [];
        $cheapestCost = PHP_INT_MAX;

        while (!empty($openSet)) {
            $current = array_reduce(array_keys($openSet), function ($carry, $item) use ($fScore) {
                return $fScore[$item] < $fScore[$carry] ? $item : $carry;
            }, array_keys($openSet)[0]);

            $currentCoords = explode(';', $current);
            $currentX = (int)$currentCoords[0];
            $currentY = (int)$currentCoords[1];
            $currentFacing = $currentCoords[2];

            if ($currentX === $end[0] && $currentY === $end[1]) {
                $this->printMap($map, $cameFrom);
                return $this->reconstructPath($cameFrom, $current);
            }

            unset($openSet[$current]);
            if ($cheapestCost !== PHP_INT_MAX && $fScore[$current] > $cheapestCost) {
                continue;
            }

            foreach ($this->getNeighbors($currentX, $currentY, $currentFacing) as $neighbor) {
                $neighborKey = $this->getKey($neighbor[0], $neighbor[1], $neighbor[2]);
                $mapNeighborKey = $this->getKey($neighbor[0], $neighbor[1]);
                if (isset($map[$mapNeighborKey]) && $map[$mapNeighborKey] === '#') {
                    continue;
                }

                $tentativeGScore = $gScore[$current] + $neighbor[3];
                $tentativeStepScore = $stepScore[$current] + 1;

                if (!isset($gScore[$neighborKey]) || $tentativeGScore < $gScore[$neighborKey]) {
                    $cameFrom[$neighborKey] = [$current];
                    $gScore[$neighborKey] = $tentativeGScore;
                    $stepScore[$neighborKey] = $tentativeStepScore;
                    $fScore[$neighborKey] = $tentativeGScore + $this->heuristic($neighbor, $end);
                    if (!isset($openSet[$neighborKey])) {
                        $openSet[$neighborKey] = $neighbor;
                    }
                } elseif ($tentativeGScore === $gScore[$neighborKey]) {
                    $cameFrom[$neighborKey][] = $current;
                }
            }
        }

        return [$paths, $cheapestCost];
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
                    echo ' ';
                }
            }
            echo PHP_EOL;
        }
    }

    private function heuristic(array $a, array $b): int
    {
        return abs($a[0] - $b[0]) + abs($a[1] - $b[1]);
    }

    private function getNeighbors(int $x, int $y, string $facing): array
    {
        $neighbors = [];
        foreach (self::DIRECTIONS as $direction => $move) {
            $newX = $x + $move[0];
            $newY = $y + $move[1];
            $rotationCost = $this->getRotationCost($facing, $direction);
            $neighbors[] = [$newX, $newY, $direction, 1 + $rotationCost];
        }
        return $neighbors;
    }

    private function getRotationCost(string $currentFacing, string $newFacing): int
    {
        $directions = array_keys(self::DIRECTIONS);
        $currentIndex = array_search($currentFacing, $directions);
        $newIndex = array_search($newFacing, $directions);
        $diff = abs($currentIndex - $newIndex);
        return min($diff, 4 - $diff) * self::ROTATION_COST;
    }

    private function reconstructPath(array $cameFrom, string $current): array
    {
        $totalPaths = [[$current]];
        $repeat = true;
        while ($repeat) {
            $repeat = false;
            $newPaths = [];
            foreach ($totalPaths as $totalPath) {
                $current = $totalPath[0];
                if (isset($cameFrom[$current])) {
                    $repeat = true;
                    foreach ($cameFrom[$current] as $prev) {
                        $newPaths[] = array_merge([$prev], $totalPath);
                    }
                }
            }
            if ($repeat) {
                $totalPaths = $newPaths;
            }
        }
        return array_map('array_reverse', $totalPaths);
    }
}
