<?php

namespace AdventOfCode\Year2020\Day19;

ini_set('memory_limit', '200G');

use AdventOfCode\Year2020\DataInput;
use AdventOfCode\Year2020\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $rules = [];
        $items = [];
        $max = 0;
        $maxRule = 0;
        foreach ($inputData as $item) {
            //your custom code goes here
            if (false !== strpos($item, ":")) {
                $model = new Model();
                $model->assign($item);
                if (in_array($model->getId(), [0, 8, 11])) {
                    continue;
                }
                $rules[$model->getId()] = $model;
                $maxRule = max($maxRule, $model->getId());
                if ($model->getId() === null) {
                    $stop = true;
                }
            } elseif (!empty($item)) {
                $max = max($max, strlen($item));
                $items[] = $item;
            }
        }
        $error = 0;
        for ($i = $maxRule; $i >= 0; $i--) {
            if (isset($rules[$i]) && null === $rules[$i]->getVariations()) {
                $err = $this->fillIt($rules[$i], $rules, $max, 0);
                if ($err) {
                    $error++;
                }
            }
        }
        echo $error . PHP_EOL;
        echo 'Done' . PHP_EOL;
        $rules42 = $rules[42]->getVariations();
        $rules31 = $rules[31]->getVariations();

        foreach ($rules42 as $item) {
            if (in_array($item, $rules31)) {
                echo 'very bad data ' . $item;

                return;
            }
        }

        $len = strlen($rules42[0]);
        $seqs = [];
        foreach ($items as $key => $item) {
            $parts = str_split($item, $len);
            $seq = [];
            foreach ($parts as $part) {
                if (in_array($part, $rules42)) {
                    $seq[] = 42;
                }
                if (in_array($part, $rules31)) {
                    $seq[] = 31;
                }
            }
            if ($this->isValid($seq)) {
                $result++;
            }
        }


        echo 'mem peak ' . memory_get_peak_usage(true) . PHP_EOL;
        echo 'mem usage ' . memory_get_usage(true) . PHP_EOL;

        return $result;
    }

    /**
     * @param Model   $rule
     * @param Model[] $rules
     */
    protected function fillIt(Model $rule, $rules, $max, $len)
    {
        $result = [];
        foreach ($rule->getPatterns() as $items) {
            $variatons = [];
            $newMax = 0;
            foreach ($items as $item) {
                if (null === $rules[$item]->getVariations()) {
                    if ($item === $rule->getId()) {
                        $new = [];
                        foreach ($result as $aa) {
                            $new[] = '(' . $aa . ')+';
                        }
                        $rules[$item]->setVariations($new);
                    } else {
                        $this->fillIt($rules[$item], $rules, $max, $len + $newMax);
                    }
                }
                if (empty($variatons)) {
                    $variatons = $rules[$item]->getVariations();
                    foreach ($variatons as $variaton) {
                        $newMax = max($newMax, strlen($variaton));
                    }
                } else {
                    $b = $rules[$item]->getVariations();
                    $new = [];
                    foreach ($b as $bb) {
                        foreach ($variatons as $aa) {
                            $new[] = $aa . $bb;
                            $newMax = max($newMax, strlen($aa . $bb));
                        }
                    }
                    $variatons = $new;
                }
            }
            $result = array_merge($result, $variatons);
        }
        $rule->setVariations($result);
    }

    protected function isValid($seq)
    {
        $count42 = 0;
        $count31 = 0;
        $last = 42;
        $valid = true;
        foreach ($seq as $item) {
            if ($last === 31 && $item !== 31) {
                $valid = false;
                break;
            } elseif ($item === 42) {
                $count42++;
            } elseif ($item === 31) {
                $count31++;
            } else {
                throw new \Exception('Unexpected value ' . $item);
            }
            $last = $item;
        }
        if (
            $count31 === 0
            || $count42 <= $count31
        ) {
            $valid = false;
        }

        return $valid;
    }
}
