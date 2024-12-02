<?php

namespace AdventOfCode\Year2023\Day17;

use AdventOfCode\Year2023\DataInput;
use AdventOfCode\Year2023\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    private $nodeMap = [];
    private $reverseMap = [];
    private $map;

    private $maxNodes;
    private $maxLine;

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $map = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $map[] = array_map('intval', str_split($item));
        }

//        $this->map = $this->makeMap($map);
        $this->map = $map;
        $lineNode = count($this->map);
        $this->maxLine = $lineNode;
        $this->maxNodes = $lineNode * $lineNode;

        $node = 0;
        for ($y = 0; $y < $lineNode; $y++) {
            for ($x = 0; $x < $lineNode; $x++) {
                $this->nodeMap[$node] = [$x, $y];
                $this->reverseMap[implode(';', [$x, $y])] = $node;
                $node++;
            }
        }

        $goal = end($this->reverseMap);
        $cameFrom = $this->aStar(0, $goal);
        ksort($cameFrom);

        $current = $goal;
        $result = 0;
        while (isset($cameFrom[$current])) {
            $coordinate = $this->nodeMap[$current];
            $score = $this->map[$coordinate[1]][$coordinate[0]];
            $result += $score;
            $current = $cameFrom[$current];
        }

        return $result;
    }

    private function aStar($start, $goal)
    {
        $openSet = [$start];
        $cameFrom = [];

        $gScore = [];
        $fScore = [];
        for ($i = 0; $i < $this->maxNodes; $i++) {
            $gScore[$i] = PHP_INT_MAX;
            $fScore[$i] = PHP_INT_MAX;
        }
        $gScore[0] = 0;
        $fScore[0] = $this->calculateEstimatedCost($start, $goal);

        $examindeNodes = 0;
        while (!empty($openSet)) {
            [$current, $bestNodeKey] = $this->getBestNode($openSet, $goal, $fScore);
            if ($current === $goal) {
                break;
            }

            unset($openSet[$current]);
            $neighbors = $this->getNeighbors($current, $cameFrom);
            foreach ($neighbors as $neighbor) {
                [$neighborX, $neighborY] = $this->nodeMap[$neighbor];
                $tentative_gScore = $gScore[$current] + $this->map[$neighborY][$neighborX];
                if ($tentative_gScore <= $gScore[$neighbor]) {
                    $cameFrom[$neighbor] = $current;
                    $gScore[$neighbor] = $tentative_gScore;
                    $fScore[$neighbor] = $tentative_gScore + $this->calculateEstimatedCost($neighbor, $goal);
                    if (!isset($openSet[$neighbor])) {
                        $openSet[$neighbor] = true;
                    }
                }
            }
            $examindeNodes++;
        }

        echo 'Examined nodes: ' . $examindeNodes . PHP_EOL;

        return $cameFrom;
    }

    private function getNeighbors($node, $cameFrom)
    {
        $result = [];
        $coordinates = $this->nodeMap[$node];
        foreach ([[-1, 0], [0, -1], [1, 0], [0, 1]] as $item) {
            $key = implode(';', [$coordinates[0] + $item[0], $coordinates[1] + $item[1]]);
            if (isset($this->reverseMap[$key]) && (!isset($cameFrom[$node]) || $cameFrom[$node] !== $this->reverseMap[$key])) {
                $result[] = $this->reverseMap[$key];
                //$cameFrom[$this->reverseMap[$key]] = $node;
            }
        }
        foreach ($result as $key => $item) {
            if (!$this->canGoStrait($item, $node, $cameFrom)) {
                unset($result[$key]);
            }
        }

        return $result;
    }

    private function canGoStrait($item, $node, $cameFrom)
    {
        $valid = true;
        $prev = $this->nodeMap[$item];
        $prevX = $prev[0];
        $countX = 1;
        $prevY = $prev[1];
        $countY = 1;
        $item = $node;
        while($item !== 0) {
            $node = $this->nodeMap[$item];
            if($node[0] === $prevX) {
                $countX++;
            } else {
                $prevX = $node[0];
                $countX = 1;
            }
            if ($countX > 4) {
                $valid = false;
                break;
            }

            if($node[1] === $prevY) {
                $countY++;
            } else {
                $prevY = $node[1];
                $countY = 1;
            }
            if ($countY > 4) {
                $valid = false;
                break;
            }
            $item = $cameFrom[$item];
        }

        return $valid;
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
//        $from = $this->nodeMap[$fromNode];
//        $to = $this->nodeMap[$toNode];
//
//        return sqrt(
//            ($from[0] - $to[0]) ** 2 +
//            ($from[1] - $to[1]) ** 2
//        );

//        $from = $this->nodeMap[$fromNode];
//        $score = $this->map[$from[1]][$from[0]];
//        $increase = [[0, 1], [1, 0]];
//        $number = 1;
//        $limit = $this->maxLine - 1;
//        while ($from[0] !== $limit && $from[1] !== $limit) {
//            $add = $increase[$number % 2];
//            $number++;
//            $from[0] = min($from[0] + $add[0], $limit);
//            $from[1] = min($from[1] + $add[1], $limit);
//            $score += $this->map[$from[1]][$from[0]];
//        }

//        return $score;
    }

    private function makeMap($map)
    {
        $newMap = [];
        $count = count($map);
        for ($y = 0; $y < 5; $y++) {
            for ($x = 0; $x < 5; $x++) {
                foreach ($map as $rowNr => $row) {
                    foreach ($row as $itemNr => $item) {
                        $newY = $rowNr + $y * $count;
                        $newX = $itemNr + $x * $count;
                        $newMap[$newY][$newX] = (($item + $x + $y) % 9) === 0 ? 9 : ($item + $x + $y) % 9;
                    }
                }
            }
        }

        return $newMap;
    }
}
