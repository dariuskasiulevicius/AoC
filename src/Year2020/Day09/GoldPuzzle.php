<?php

namespace AdventOfCode\Year2020\Day09;

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
        $numbers = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            $numbers[] = (int) $item;
        }
        $result = $this->getFirstBad($numbers, 25);

        return $result;
    }

    protected function getFirstBad($numbers, $size)
    {
        $stack = [];
        $result = 0;
        for ($i = 0; $i<$size; $i++) {
            $stack[] = $numbers[$i];
        }
        $len = count($numbers);
        for($k = $size; $k<$numbers; $k++) {
            $has = $this->isHas($stack);
            if (false !== $has) {
                $result = $has;
                break;
            }
            if (!$this->isValid($stack, $numbers[$k])){
                $result = $numbers[$k];
                break;
            } else {
                $stack[] = $numbers[$k];
                array_shift($stack);
            }
        }

        return $result;
    }

    protected function isHas($stack)
    {
        $result = false;
        do {
            if (array_sum($stack) === 393911906) {
                $result = min($stack) + max($stack);
                break;
            }
            array_shift($stack);
        } while(count($stack) > 0);

        return $result;
    }

    protected function isValid($stack, $number)
    {
        foreach ($stack as $item1) {
            foreach ($stack as $item2) {
                if($item1+$item2 === $number){
                    return true;
                }
            }
        }

        return false;
    }
}
