<?php

namespace AdventOfCode\Year2020\Day12;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $place = ['x' => 0, 'y' => 0];
        $point = ['x' => 10, 'y' => 1];
//        $face = 45;
        foreach ($inputData as $key => $item) {
            echo $key;
            echo PHP_EOL;
            //your custom code goes here
            $model = new Model();
            $model->assign($item);
            if ($model->getAction() === 'N') {
                $point['y'] += $model->getCount();
            } elseif ($model->getAction() === 'S') {
                $point['y'] -= $model->getCount();
            } elseif ($model->getAction() === 'E') {
                $point['x'] += $model->getCount();
            } elseif ($model->getAction() === 'W') {
                $point['x'] -= $model->getCount();
            } elseif ($model->getAction() === 'L') {
                $deg = $model->getCount();
                $face = $this->getDegree($point['x'], $point['y']);
                while ($deg > 0) {
                    $x = $point['x'];
                    $point['x'] = $point['y'];
                    $point['y'] = $x;
                    if ($face === 45) {
                        $point['x'] = abs($point['x']) * -1;
                        $point['y'] = abs($point['y']) * 1;
                        $face = 315;
                    } elseif ($face === 315) {
                        $point['x'] = abs($point['x']) * -1;
                        $point['y'] = abs($point['y']) * -1;
                        $face = 225;
                    } elseif ($face === 225) {
                        $point['x'] = abs($point['x']) * 1;
                        $point['y'] = abs($point['y']) * -1;
                        $face = 135;
                    } elseif ($face === 135) {
                        $point['x'] = abs($point['x']) * 1;
                        $point['y'] = abs($point['y']) * 1;
                        $face = 45;
                    }
                    $deg -= 90;
                }
            } elseif ($model->getAction() === 'R') {
                $deg = $model->getCount();
                $face = $this->getDegree($point['x'], $point['y']);
                while ($deg > 0) {
                    $x = $point['x'];
                    $point['x'] = $point['y'];
                    $point['y'] = $x;
                    if ($face === 45) {
                        $point['x'] = abs($point['x']) * 1;
                        $point['y'] = abs($point['y']) * -1;
                        $face = 135;
                    } elseif ($face === 135) {
                        $point['x'] = abs($point['x']) * -1;
                        $point['y'] = abs($point['y']) * -1;
                        $face = 225;
                    } elseif ($face === 225) {
                        $point['x'] = abs($point['x']) * -1;
                        $point['y'] = abs($point['y']) * 1;
                        $face = 315;
                    } elseif ($face === 315) {
                        $point['x'] = abs($point['x']) * 1;
                        $point['y'] = abs($point['y']) * 1;
                        $face = 45;
                    }
                    $deg -= 90;
                }
            } elseif ($model->getAction() === 'F') {
                $step = $model->getCount();
                $place['x'] += $step * $point['x'];
                $place['y'] += $step * $point['y'];
            }
        }
        var_export($place);

        return abs($place['x']) + abs($place['y']);
    }

    private function getDegree(int $x, int $y)
    {
        if ($x >= 0 && $y >= 0) {
            $degree = 45;
        } elseif ($x < 0 && $y >= 0) {
            $degree = 315;
        } elseif ($x >= 0 && $y < 0) {
            $degree = 135;
        } elseif ($x < 0 && $y < 0) {
            $degree = 225;
        } else {
            $degree = 0;
        }

        return $degree;
    }
}
