<?php

namespace AdventOfCode\Year2020\Day07;

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
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
            $models[] = $model;
        }

        $found = ['shiny gold'];
        $this->rules = [];
        do {
            $newFound = [];
            foreach ($found as $item) {
                $newRules = $this->getRulesFor($item, $models);
                $newFound = array_merge($newFound, $newRules);
            }
            $found = $newFound;
        } while (!empty($found));

        $rules = array_unique($this->rules);
        $result = count($rules);

        return $result;
    }

    private function getRulesFor(string $bagColor, array $models)
    {
        $colors = [];
        foreach ($models as $model) {
            $found = $model->hasBag($bagColor);
            if (null !== $found) {
                $colors[] = $found;
                $this->rules[] = $model->getCode();
            }
        }

        return $colors;
    }
}
