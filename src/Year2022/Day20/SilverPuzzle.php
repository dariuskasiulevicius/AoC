<?php

namespace AdventOfCode\Year2022\Day20;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $items = [];
        /** @var Model $prev */
        $prev = null;
        $zero = null;
        foreach ($inputData as $item) {
            //your custom code goes here
            $node = new Model();
            $number = (int)$item;
            $node->setNumber($number);
            if ($number === 0) {
                $zero = $node;
            }
            if ($prev !== null) {
                $node->setLeft($prev);
                $prev->setRight($node);
            }
            $prev = $node;
            $items[] = $node;
        }
        /** @var Model $first */
        $first = $items[0];
        $first->setLeft($prev);
        $prev->setRight($first);

        $nodeCount = count($items) - 1;
//        $this->print($zero, $nodeCount);

        foreach ($items as $item) {
            $steps = $item->getNumber() % $nodeCount;
            if($steps === 0){
                continue;
            }
            $next = $item;
            //remove from old place
            $left = $item->getLeft();
            $right = $item->getRight();
            $left->setRight($right);
            $right->setLeft($left);
            if ($steps > 0) {
                for ($i = 0; $i < $steps; $i++) {
                    $next = $next->getRight();
                }
            } elseif ($steps < 0) {
                for ($i = 0; $i >= $steps; $i--) {
                    $next = $next->getLeft();
                }
            }
            //insert in to new place
            $left = $next;
            $right = $next->getRight();
            $left->setRight($item);
            $right->setLeft($item);
            $item->setLeft($left);
            $item->setRight($right);
//            $this->print($zero, $nodeCount);
        }
//            $this->print($zero, $nodeCount);

        $itemCount = count($items);
        $sumItems = [1000, 2000, 3000];
        $sumItems = array_map(fn($value):int => $value % $itemCount, $sumItems);
        foreach ($sumItems as $steps) {
            $next = $zero;
            for ($i = 0; $i < $steps; $i++){
                $next = $next->getRight();
            }
            $result += $next->getNumber();
        }

        return $result;
    }

    private function print($item, $count)
    {
        for ($i = 0; $i <= $count; $i++) {
            echo $item->getNumber() . ' ';
            $item = $item->getRight();
        }
        echo PHP_EOL;
    }
}
