<?php

namespace AdventOfCode\Year2022\Day05;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = '';
        $nodes = [];
        $init = true;
        $actions = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $elements = str_split($inputData->getFullLine(), 4);

            if (empty((int)$elements[0]) && $init) {
                $nodeNumber = 1;
                foreach ($elements as $node) {
                    $node = trim($node);
                    if (!empty($node)) {
                        $letter = str_replace(['[', ']'], '', $node);
                        $model = new Model();
                        $model->setValue($letter);
                        if (!empty($nodes[$nodeNumber])) {
                            $nodes[$nodeNumber]->getLast()->setNext($model);
                        } else {
                            $nodes[$nodeNumber] = $model;
                        }
                    }
                    $nodeNumber++;
                }
            } elseif (!empty((int)(trim($elements[0]))) || empty(trim($item))) {
                $init = false;
            } else {
                $actions[] = trim($item);
            }
        }
        ksort($nodes);

        foreach ($actions as $action) {
            $pattern = '/move (\d+) from (\d+) to (\d+)/';
            if (preg_match($pattern, $action, $matches) === 1) {
                $from = $matches[2];
                $to = $matches[3];
                for ($i = 1; $i <= $matches[1]; $i++) {
                    $movingItem = $nodes[$from];
                    $nodes[$from] = $movingItem->getNext();
                    $movingItem->setNext($nodes[$to]);
                    $nodes[$to] = $movingItem;
                }
            } else {
                var_export($action);
                exit(255);
            }
        }

        foreach ($nodes as $item) {
            $result.= $item->getValue();
        }

        return $result;
    }
}
