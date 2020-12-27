<?php

namespace AdventOfCode\Year2020\Day08;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    protected array $actions = [];

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        foreach ($inputData as $item) {
            $model = new Model();
            $model->assign($item);
            $this->actions[] = $model;
        }

        $iteration = 0;
        $change = 0;
        do {
            list($result, $break, $newChange) = $this->getAcc($change);
            if ($newChange === $change) {
                echo ' Change is same. ';
                break;
            }
            $change = $newChange;
            if ($break === false) {
                echo ' Break loop. ';
                break;
            }
            $iteration++;
            echo ' i ';
            echo $iteration;
        } while ($break);

        return $result;
    }

    protected function getAcc(int $change)
    {
        $acc = 0;
        $step = 0;
        $break = false;
        $visited = [];
        $changed = false;
        $actionNumber = 0;
        echo ' c ';
        echo $change;
        do {
            $actionNumber++;
            $action = $this->actions[$step];
            if (isset($visited[$step])) {
                $break = true;
                break;
            }
            $visited[$step] = true;
            $operation = $action->getOperation();
            if ($actionNumber > $change && false === $changed) {
                if ($operation === 'nop') {
                    $operation = 'jmp';
                    $changed = true;
                    $change = $actionNumber;
                } elseif ($operation === 'jmp') {
                    $operation = 'nop';
                    $changed = true;
                    $change = $actionNumber;
                }
            }
            if ($operation === 'acc') {
                $acc += $action->getCount();
                $step++;
            } elseif ($operation === 'nop') {
                $step++;
            } elseif ($operation === 'jmp') {
                $step += $action->getCount();
            }
        } while (isset($this->actions[$step]));

        return [$acc, $break, $change];
    }
}
