<?php

namespace AdventOfCode\Year2020\Day16;

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
        $nextData = 0;
        $data = [];
        $info = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            if ($item === 'your ticket:') {
                $nextData = 2;
            } elseif ($nextData === 2) {
                $ticket = $data = explode(',', $item);
                $nextData = 0;
            } elseif ($item === 'nearby tickets:') {
                $nextData = 1;
            } elseif ($nextData === 1) {
                $data = explode(',', $item);
                $result += $this->isValid($data, $info);
            } elseif (!empty($item)) {
                $model = new Model();
                $model->assign($item);
                $info[$model->getType()] = $model;
            }
        }


        return $result;
    }

    protected function isValid($data, $validators)
    {
        $fail = 0;
        foreach ($data as $item) {
            $valid = false;
            foreach ($validators as $validator) {
                foreach ($validator->getValues() as $range) {
                    if ($item >= $range[0] && $item <= $range[1]) {
                        $valid = true;
                    }
                }
            }
            if (!$valid) {
                $fail+=$item;
            }
        }

        return $fail;
    }
}

