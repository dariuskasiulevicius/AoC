<?php

namespace AdventOfCode\Year2020\Day19;

ini_set('memory_limit', '200G');

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        return 0;
        $result = 0;
        $rules = [];
        $items = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            if (false !== strpos($item, ":")) {
                $model = new Model();
                $model->assign($item);
                $rules[$model->getId()] = $model;
                if ($model->getId() === null) {
                    $stop = true;
                }
            } elseif (!empty($item)) {
                $items[] = $item;
            }
        }
        sort($rules);
        $len = count($rules);
        do {
            $all = false;
            $error = 0;
            for ($i = $len - 1; $i >= 0; $i--) {
                if (null === $rules[$i]->getVariations()) {
                    $err = $this->fillIt($rules[$i], $rules);
                    $all = $all || $err;
                    if ($err) {
                        $error++;
                    }
                }
            }
        } while ($all);
        $rule = $rules[0]->getVariations();
        foreach ($items as $item) {
            if ($this->isValid($item, $rule)) {
                $result++;
            }
        }

        return $result;
    }

    /**
     * @param Model   $rule
     * @param Model[] $rules
     */
    protected function fillIt(Model $rule, $rules)
    {
        $error = false;
        $result = [];
        foreach ($rule->getPatterns() as $items) {
            $variatons = [];
            foreach ($items as $item) {
                if (null === $rules[$item]->getVariations()) {
                    $error = true;
                    break 2;
                }
                if (empty($variatons)) {
                    $variatons = $rules[$item]->getVariations();
                } else {
                    $b = $rules[$item]->getVariations();
                    $new = [];
                    foreach ($b as $bb) {
                        foreach ($variatons as $aa) {
                            $new[] = $aa . $bb;
                        }
                    }
                    $variatons = $new;
                }
            }
            $result = array_merge($result, $variatons);
        }
        if (!$error) {
            $rule->setVariations($result);
        }

        return $error;
    }

    protected function isValid($item, $rule)
    {
        foreach ($rule as $pattern) {
            if ($pattern === $item) {
                return true;
            }
        }

        return false;
    }
}
