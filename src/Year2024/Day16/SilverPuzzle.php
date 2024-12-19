<?php

namespace AdventOfCode\Year2024\Day16;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
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
        $map =[];
        foreach ($inputData as $line => $item) {
            $y = $line - 1;
            foreach (str_split($item) as $x => $char) {
                $key = $this->getKey($x, $y);
                if ($char === '#') {
                    $map[$key] = '#';
                } elseif ($char === 'S') {
                    $start = [$x, $y, 'E'];
                }  elseif ($char === 'E') {
                    $end = [$x, $y];
                }
            }
        }

        [$path, $result] = $this->aStar($map, $start, $end);

        return $result;
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

        while (!empty($openSet)) {
            $current = array_reduce(array_keys($openSet), function ($carry, $item) use ($fScore) {
                return $fScore[$item] < $fScore[$carry] ? $item : $carry;
            }, array_keys($openSet)[0]);

            $currentCoords = explode(';', $current);
            $currentX = (int)$currentCoords[0];
            $currentY = (int)$currentCoords[1];
            $currentFacing = $currentCoords[2];

            if ($currentX === $end[0] && $currentY === $end[1]) {
                return [$this->reconstructPath($cameFrom, $current), $fScore[$current]];
            }

            unset($openSet[$current]);

            foreach ($this->getNeighbors($currentX, $currentY, $currentFacing) as $neighbor) {
                $neighborKey = $this->getKey($neighbor[0], $neighbor[1], $neighbor[2]);
                $mapNeighborKey = $this->getKey($neighbor[0], $neighbor[1]);
                if (isset($map[$mapNeighborKey]) && $map[$mapNeighborKey] === '#') {
                    continue;
                }

                $tentativeGScore = $gScore[$current] + $neighbor[3];

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
        $totalPath = [$current];
        while (isset($cameFrom[$current])) {
            $current = $cameFrom[$current];
            $totalPath[] = $current;
        }
        return array_reverse($totalPath);
    }
}
