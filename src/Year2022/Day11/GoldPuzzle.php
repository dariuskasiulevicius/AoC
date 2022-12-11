<?php

namespace AdventOfCode\Year2022\Day11;

use AdventOfCode\Year2022\DataInput;
use AdventOfCode\Year2022\PuzzleResolver;

class GoldPuzzle implements PuzzleResolver
{
    /**
     * @return mixed
     */
    public function resolve(DataInput $inputData)
    {
        $result = 0;
        $monkeys = [];
        $monkey = new Model();
        $division = 1;
        foreach ($inputData as $item) {
            //your custom code goes here
            if (empty($item)) {
                $monkeys[$monkeyNumber] = $monkey;
                $monkey = new Model();
                continue;
            }
            $items = explode(' ', $item);
            if ($items[0] === 'Monkey') {
                $monkeyNumber = (int)str_replace(':', '', $items[1]);
            } elseif ($items[0] === 'Starting') {
                foreach ($items as $number) {
                    $number = str_replace(',', '', $number);
                    if (((string)((int)$number)) === $number) {
                        $monkey->addItem((int)$number);
                    }
                }
            } elseif ($items[0] === 'Operation:') {
                array_shift($items);
                $monkey->setOperation(implode(' ', $items));
            } elseif ($items[0] === 'Test:') {
                $test = (int)end($items);
                $monkey->setTest($test);
                $division *= $test;
            } elseif ($items[0] === 'If') {
                if ($items[1] === 'true:') {
                    $monkey->setCorrect((int)end($items));
                } elseif ($items[1] === 'false:') {
                    $monkey->setWrong((int)end($items));
                }
            }
        }
        $monkeys[$monkeyNumber] = $monkey;

        for($round = 0; $round < 10000; $round++) {
            foreach ($monkeys as $monkey) {
                foreach ($monkey->getItems() as $item) {
                    $monkey->increaseInspected();
                    $new = $monkey->doOperation($item);
                    $new = $new % $division;
                    $redirect = $monkey->getRedirection($new);
                    $monkeys[$redirect]->addItem($new);
                }
                $monkey->setItems([]);
            }
        }
        $inspection = [];
        foreach ($monkeys as $monkey) {
            $inspection[] = $monkey->getInspected();
        }
        rsort($inspection);

        return array_shift($inspection) * array_shift($inspection);
    }
}
