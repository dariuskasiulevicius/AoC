<?php

namespace AdventOfCode\Year2020\Day22;

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
        $players = [];
        $deck = [];
        foreach ($inputData as $item) {
            //your custom code goes here
            if (!empty($item)) {
                $deck[] = $item;
            } else {
                $model = new Model();
                $model->assign($deck);
                $players[] = $model;
                $deck = [];
            }
        }
        if (!empty($deck)) {
            $model = new Model();
            $model->assign($deck);
            $players[] = $model;
        }

        $deck1 = $players[0]->getDeck();
        $deck2 = $players[1]->getDeck();

        do {
            $card1 = array_shift($deck1);
            $card2 = array_shift($deck2);
            if ($card1 > $card2) {
                $deck1[] = $card1;
                $deck1[] = $card2;
            } else {
                $deck2[] = $card2;
                $deck2[] = $card1;
            }
        } while (!(empty($deck1) || empty($deck2)));

        if (count($deck1) > 0) {
            $max = count($deck1);
            $deck = $deck1;
        } else {
            $max = count($deck2);
            $deck = $deck2;
        }
        foreach ($deck as $item) {
            $result += $item * $max;
            $max--;
        }

        return $result;
    }
}
