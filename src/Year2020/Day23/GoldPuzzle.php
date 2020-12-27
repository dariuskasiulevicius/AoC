<?php

namespace AdventOfCode\Year2020\Day23;

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
        $cups = str_split('624397158', 1);
        $max = max($cups);
        for ($i = $max + 1; $i <= 1000000; $i++) {
            $cups[]=$i;
        }
        $max = count($cups);
        $move = 1;
        $allCups = [];
        $prev = null;
        foreach ($cups as $item) {
            $model = new Model();
            $model->number = (int)$item;
            if ($prev !== null) {
                $prev->next = $model;
            }
            $prev = $model;
            $allCups[$item] = $model;
        }
        /** @var Model $currentCup */
        $currentCup = reset($allCups);
        $last = end($allCups);
        $last->next = $currentCup;
//            echo $currentCup->print($currentCup->number, 0) . PHP_EOL;

        for ($step = 0; $step < 10000000; $step++) {
            $three = [];
            $next = $currentCup->next;
            $firstThree = $next;
            for ($x = 1; $x <= 3; $x++) {
                $three[] = $next->number;
                $lastThree = $next;
                $next = $next->next;
            }
            $currentCup->next = $next;
            $destinationCupNumber = $currentCup->number - 1;
            $currentCup = $next;
            do {
                if ($destinationCupNumber < 1) {
                    $destinationCupNumber += $max;
                }
                $found = true;
                if (in_array($destinationCupNumber, $three)) {
                    $destinationCupNumber--;
                    $found = false;
                }
            } while (!$found);

            $destinationCup = $allCups[$destinationCupNumber];
            $lastThree->next = $destinationCup->next;
            $destinationCup->next = $firstThree;

            $move++;
            if ($move % 1000000 === 0) {
                echo $move . PHP_EOL;
            }
        }

        $next = $allCups[1]->next;
        $result = $next->number;
        echo $next->number . PHP_EOL;
        $next = $next->next;
        $result *= $next->number;
        echo $next->number . PHP_EOL;

        return $result;
    }
}
