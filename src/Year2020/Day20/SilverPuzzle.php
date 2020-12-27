<?php

namespace AdventOfCode\Year2020\Day20;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $tiles = [];
        $tile = [];
        foreach ($inputData as $item) {
            if (!empty($item)) {
                $tile[] = $item;
            } else {
                $model = new Model();
                $model->assign($tile);
                $tiles[] = $model;
                $tile = [];
            }
        }
        if (!empty($tile)){
            $model = new Model();
            $model->assign($tile);
            $tiles[] = $model;
        }

        $edges = [];
        $counts = [];
        foreach ($tiles as $tile) {
            $id = $tile->getId();
            $counts[$id] = 0;
            foreach ($tile->getEdges() as $edge) {
                if (isset($edges[$edge])) {
                    $edges[$edge][] = $id;
                    foreach ($edges[$edge] as $key) {
                        $counts[$key]++;
                    }
                } else {
                    $edges[$edge] = [$id];
                }
            }
        }
        $min = min($counts);
        $result=1;
        foreach ($counts as $key => $count) {
            if ($count === $min){
                $result *= $key;
            }
        }

        return $result;
    }
}
