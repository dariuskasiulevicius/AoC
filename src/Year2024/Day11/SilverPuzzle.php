<?php

namespace AdventOfCode\Year2024\Day11;

use AdventOfCode\Year2024\DataInput;
use AdventOfCode\Year2024\PuzzleResolver;

class SilverPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $start = null;
        $last = null;
        foreach ($inputData as $item) {
            foreach (explode(' ', $item) as $num) {
                $stone = new Model($num);
                if($start === null){
                    $start = $stone;
                } else {
                    $last->setNext($stone);
                    $stone->setPrev($last);
                }
                $last = $stone;
            }
        }

        $stones = $start;
        for($i= 0; $i < 25; $i++){
            $stones = $this->step($stones);
//            $result = $this->printResult($stones);
        }

        $cur = $stones;
        while($cur !== null){
            $result++;
            $cur = $cur->getNext();
        }

        return $result;
    }

    private function printResult(Model $cur)
    {
        while($cur !== null){
            echo $cur->getNumber();
            echo ' ';
            $cur = $cur->getNext();
        }
        echo PHP_EOL;
    }

    private function step(Model $stones)
    {
        $start = $stones;
        $cur = $stones;
        while( $cur !== null) {
            if($cur->getNumber() === 0){
                $cur->setNumber(1);
            } elseif (strlen((string)$cur->getNumber()) % 2 === 0) {
                $string = (string)$cur->getNumber();
                $leftNumber = (int)substr($string, 0, strlen($string) / 2);
                $rightNumber = (int)substr($string, strlen($string) / 2);
                $cur->setNumber($rightNumber);
                $newNode = new Model($leftNumber);
                $newNode->setPrev($cur->getPrev());
                $newNode->setNext($cur);
                $cur->setPrev($newNode);
                if($newNode->getPrev() !== null){
                    $newNode->getPrev()->setNext($newNode);
                } else {
                    $start = $newNode;
                }
            } else {
                $cur->setNumber($cur->getNumber() * 2024);
            }
            $cur = $cur->getNext();
        }
        return $start;
    }
}
