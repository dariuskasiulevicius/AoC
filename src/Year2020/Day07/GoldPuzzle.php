<?php

namespace AdventOfCode\Year2020\Day07;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    protected $rules;

    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $models = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $model = new Model();
            $model->assign($item);
            $models[$model->getFirstCode()] = $model;
        }

        $rules = [0 => [$models[md5('shiny gold')], 1]];
        do {
            $newRules = [];
            foreach ($rules as $rule) {
                /** @var Model $bag */
                $bag = $rule[0];
                $count = $rule[1];
                foreach ($bag->getBags() as $key => $item) {
                    $newRules[] = [$models[md5($key)], $item * $count];
                    $result += $item * $count;
                };
            }
            $rules = $newRules;
        } while (!empty($rules));

        //$found = ['dull lime' => 1, 'pale coral' => 2, 'wavy silver' => 1, 'muted black' => 5];


        return $result;
    }

}
