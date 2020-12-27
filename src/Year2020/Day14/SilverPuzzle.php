<?php

namespace AdventOfCode\Year2020\Day14;

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
        $mask = '';
        $mem = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $model = new Model ();
            $model->assign($item);
            if ($model->getAction() === 'mask') {
                $mask = $model->getValue();
            } elseif ($model->getAction() === 'mem') {
                $mem[$model->getAddress()] = $model->getValue() & $mask['and'] | $mask['or'];
            }
        }
        $result = array_sum($mem);

        return $result;
    }
}
