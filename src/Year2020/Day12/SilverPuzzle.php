<?php

namespace AdventOfCode\Year2020\Day12;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $items = [];
        $place = [0, 0];
        $face = 90;
        foreach ($inputData as $item) {
            //your custom code goes here
            $model = new Model();
            $model->assign($item);
//            $items[] = $model;
            if ($model->getAction() == 'N') {
                $place[1] += $model->getCount();
            } elseif ($model->getAction() == 'S') {
                $place[1] -= $model->getCount();
            } elseif ($model->getAction() == 'E') {
                $place[0] += $model->getCount();
            } elseif ($model->getAction() == 'W') {
                $place[0] -= $model->getCount();
            } elseif ($model->getAction() == 'L') {
                $face -= $model->getCount();
            } elseif ($model->getAction() == 'R') {
                $face += $model->getCount();
            } elseif ($model->getAction() == 'F') {
                while ($face >= 360) {
                    $face -= 360;
                }
                while($face <0){
                    $face+=360;
                }
                if (abs($face) === 0) {
                    $place[1] += $model->getCount();
                } elseif (abs($face) === 90) {
                    $place[0] += $model->getCount();
                } elseif (abs($face) === 180) {
                    $place[1] -= $model->getCount();
                } elseif (abs($face) === 270) {
                    $place[0] -= $model->getCount();
                }
            }
        }
        $result = abs($place[0])+abs($place[1]);

        return $result;
    }
}
