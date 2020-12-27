<?php

namespace AdventOfCode\Year2020\Day08;

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
        $actions = [];
        foreach ($inputData as $item) {
            $model = new Model();
            $model->assign($item);
            $actions[] = $model;
        }
        $acc = 0;
        $step = 0;
        $visited = [];
        do {
            $action = $actions[$step];
            if (isset($visited[$step])){
                break;
            }
            $visited[$step] = true;
            if ($action->getOperation() === 'acc') {
                $acc += $action->getCount();
                $step++;
            } elseif ($action->getOperation() === 'nop') {
                $step++;
            } elseif ($action->getOperation() === 'jmp') {
                $step += $action->getCount();
            }
        } while (isset($actions[$step]));

        $result = $acc;
        return $result;
    }
}
