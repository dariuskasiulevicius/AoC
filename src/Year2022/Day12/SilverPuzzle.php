<?php

namespace AdventOfCode\Year2022\Day12;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    private $nodeMap = [];
    private $reverseMap = [];
    private $map;

    private $maxNodes;

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $map = [];
        $start = [];
        $end = [];
        $y = 0;
        foreach ($inputData as $item) {
            //your custom code goes here
            $line = str_split($item);
            $map[] = array_map('ord', $line);
            foreach ($line as $x => $value) {
                if ('S' === $value) {
                    $start = [$x, $y];
                    $map[$y][$x] = ord('a');
                }
                if ('E' === $value) {
                    $end = [$x, $y];
                    $map[$y][$x] = ord('z');
                }
            }

            $y++;
        }

        return $this->solve($map, $start, $end);
    }


    public function solve($map, $start, $end)
    {
        $this->map = $map;
        $lineNode = count($this->map);
        $colNode = count(end($this->map));
        $this->maxNodes = $lineNode * $colNode;

        $node = 0;
        for ($y = 0; $y < $lineNode; $y++) {
            for ($x = 0; $x < $colNode; $x++) {
                $this->nodeMap[$node] = [$x, $y];
                $this->reverseMap[implode(';', [$x, $y])] = $node;
                $node++;
            }
        }

        $begining = $this->reverseMap[implode(';', $start)];
        $goal = $this->reverseMap[implode(';', $end)];
        $cameFrom = $this->aStar($begining, $goal);
        ksort($cameFrom);

        $path = [];
        $current = $goal;
        $result = 0;
        while (isset($cameFrom[$current])) {
            $path[] = $current;
            $result++;
            $current = $cameFrom[$current];
        }


//        $this->printMap($path, $colNode);

        return $result;
    }

    private function aStar($start, $goal)
    {
        $openSet = [];
        $openSet[$start] = true;
        $cameFrom = [];

        $gScore = [];
        $fScore = [];
        for ($i = 0; $i < $this->maxNodes; $i++) {
            $gScore[$i] = PHP_INT_MAX;
            $fScore[$i] = PHP_INT_MAX;
        }
        $gScore[$start] = 1;
        $fScore[$start] = $this->calculateEstimatedCost($start, $goal);

        $examinedNodes = 0;
        while (!empty($openSet)) {
            [$current, $bestNodeKey] = $this->getBestNode($openSet, $goal, $fScore);
            if ($current === $goal) {
                break;
            }

            unset($openSet[$current]);
            $neighbors = $this->getNeighbors($current);
            foreach ($neighbors as $neighbor) {
                $tentative_gScore = $gScore[$current] + 1;
                if ($tentative_gScore < $gScore[$neighbor]) {
                    $cameFrom[$neighbor] = $current;
                    $gScore[$neighbor] = $tentative_gScore;
                    $fScore[$neighbor] = $tentative_gScore + $this->calculateEstimatedCost($neighbor, $goal);
                    if (!isset($openSet[$neighbor])) {
                        $openSet[$neighbor] = true;
                    }
                }
            }
            $examinedNodes++;
        }

        return $cameFrom;
    }

    private function getNeighbors($node)
    {
        $result = [];
        $coordinates = $this->nodeMap[$node];
        $startValue = $this->map[$coordinates[1]][$coordinates[0]];
        foreach ([[-1, 0], [0, -1], [1, 0], [0, 1]] as $item) {
            $newX = $coordinates[0] + $item[0];
            $newY = $coordinates[1] + $item[1];
            $key = implode(';', [$newX, $newY]);
            if (isset($this->reverseMap[$key])) {
                $nextValue = $this->map[$newY][$newX];
                if ($startValue == $nextValue || $startValue + 1 == $nextValue || $startValue - 1 == $nextValue ||
                    $startValue - 2 == $nextValue) {
                    $result[] = $this->reverseMap[$key];
                }
            }
        }

        return $result;
    }

    private function getBestNode($nodes, $goal, $fScore)
    {
        $best = null;
        foreach ($nodes as $node => $val) {
            $estimatedCost = $fScore[$node];
            if ($best === null || $estimatedCost < $best[1]) {
                $best = [$node, $estimatedCost];
            }
        }

        return $best;
    }

    private function calculateEstimatedCost($fromNode, $toNode)
    {
        return 0;
    }

    private function printMap($mapNodes, $col)
    {
        $i = 0;
        foreach ($this->nodeMap as $node => $coordinates) {
            if ($i >= $col) {
                $i = 0;
                echo PHP_EOL;
            }
            $value = $this->map[$coordinates[1]][$coordinates[0]];
            if (in_array($node, $mapNodes)) {
                echo "\e[41m".chr($value)."\e[49m";
            } else {
                echo chr($value);
            }
            $i++;
        }
        echo PHP_EOL;
    }
}
