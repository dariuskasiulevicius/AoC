<?php

namespace AdventOfCode\Year2021\Day15;

ini_set('memory_limit', '200G');

use AdventOfCode\Year2021\DataInput;
use AdventOfCode\Year2021\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
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

        $lineNode = count($map);
        $maxNodes = $lineNode * $lineNode;
        $graph = array_fill(0, $maxNodes, array_fill(0, $maxNodes, 0));

        for ($x = 0; $x < $lineNode; $x++) {
            for ($y = 0; $y < $lineNode; $y++) {
                $fromNode = $y * $lineNode + $x;
                if (($y + 1) < $lineNode) {
                    $toNode = ($y + 1) * $lineNode + $x;
                    $graph[$fromNode][$toNode] = $map[$y + 1][$x];
                }
                if (($x + 1) < $lineNode) {
                    $toNode = $y * $lineNode + $x + 1;
                    $graph[$fromNode][$toNode] = $map[$y][$x + 1];
                }
                if (($y - 1) >= 0) {
                    $toNode = ($y - 1) * $lineNode + $x;
                    $graph[$fromNode][$toNode] = $map[$y - 1][$x];
                }
                if (($x - 1) >= 0) {
                    $toNode = $y * $lineNode + $x - 1;
                    $graph[$fromNode][$toNode] = $map[$y][$x - 1];
                }
            }
        }

        $dist = $this->dijkstra($graph, 0, $maxNodes);

        echo 'mem peak ' . memory_get_peak_usage(true) . PHP_EOL;
        echo 'mem usage ' . memory_get_usage(true) . PHP_EOL;

        return end($dist);
    }

    private function dijkstra($graph, $src, $V)
    {
        $dist = [];
        $sptSet = [];

        for ($i = 0; $i < $V; $i++) {
            $dist[$i] = PHP_INT_MAX;
            $sptSet[$i] = false;
        }
        $dist[$src] = 0;

        for ($count = 0; $count < $V; $count++) {
            $u = $this->minDistance($dist, $sptSet, $V);
            $sptSet[$u] = true;

            for ($v = 0; $v < $V; $v++) {
                if (!$sptSet[$v] && $graph[$u][$v] != 0 &&
                    $dist[$u] != PHP_INT_MAX &&
                    $dist[$u] + $graph[$u][$v] < $dist[$v]) {
                    $dist[$v] = $dist[$u] + $graph[$u][$v];
                }
            }
        }

        return $dist;
    }

    private function minDistance($dist, $sptSet, $V)
    {
        $min = PHP_INT_MAX;
        $min_index = -1;

        for ($i = 0; $i < $V; $i++) {
            if ($sptSet[$i] == false && $dist[$i] <= $min) {
                $min = $dist[$i];
                $min_index = $i;
            }
        }

        return $min_index;
    }
}
