<?php

namespace AdventOfCode\Year2024\Day23;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $nodes = [];
        foreach ($inputData as $item) {
            [$n1, $n2] = explode('-', $item);
            if (!isset($nodes[$n1])) {
                $nodes[$n1] = [];
            }
            $nodes[$n1][] = $n2;
            if (!isset($nodes[$n2])) {
                $nodes[$n2] = [];
            }
            $nodes[$n2][] = $n1;
        }

        $maxClique = [];
        $this->bronKerboschPivot([], array_keys($nodes), [], $nodes, $maxClique);
        sort($maxClique);

        return implode(',', $maxClique);
    }

    private function bronKerboschPivot($R, $P, $X, $nodes, &$maxClique)
    {
        if (empty($P) && empty($X)) {
            if (count($R) > count($maxClique)) {
                $maxClique = $R;
            }
            return;
        }

        if (count($P) > 0) {
            $u = $P[0];
            foreach (array_diff($P, $nodes[$u]) as $v) {
                $newR = $R;
                $newR[] = $v;
                $newP = array_values(array_intersect($P, $nodes[$v]));
                $newX = array_values(array_intersect($X, $nodes[$v]));

                $this->bronKerboschPivot($newR, $newP, $newX, $nodes, $maxClique);

                $P = array_diff($P, [$v]);
                $X[] = $v;
            }
        }
    }
}
